<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\TransactionsController;
use App\Models\GlobalParam;
use App\Services\MethodServiceUtil;
use App\Services\TransactionsInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Auth;

class TransactionsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected TransactionsInterface $transactionService;
    protected MethodServiceUtil $methodService;
    protected TransactionsController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Create mocks for dependencies
        $this->transactionService = Mockery::mock(TransactionsInterface::class);
        $this->methodService = Mockery::mock(MethodServiceUtil::class);

        // Create test user and authenticate
        $user = new \App\Models\User([
            'id' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_detail_id' => 'UD123'
        ]);

        $this->actingAs($user);

        // Create controller instance with mocked dependencies
        $this->controller = new TransactionsController($this->transactionService, $this->methodService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function test_successful_checkout()
    {
        // Mock transaction service response
        $mockResponse = [
            'status' => true,
            'transaction' => [
                'id' => 'TXN123',
                'user_id' => 'test@example.com',
                'product_id' => 'PROD123',
                'status' => 'pending'
            ]
        ];

        $this->transactionService
            ->shouldReceive('checkout')
            ->once()
            ->andReturn($mockResponse);

        // Make request
        $response = $this->post(route('checkout'), [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'product_code' => 'PROD123',
            'title' => 'Test Product',
            'description' => 'Test Description'
        ]);

        // Assertions
        $response->assertStatus(200);
        $response->assertViewIs('receipt');
        $response->assertViewHas('status', true);
        $response->assertViewHas('data');
    }

    /** @test */
    public function test_checkout_validation_fails()
    {
        $response = $this->post(route('checkout'), []);

        $response->assertSessionHasErrors([
            'email', 'name', 'product_code', 'title', 'description'
        ]);
    }

    /** @test */
    public function test_checkout_service_throws_exception()
    {
        $this->transactionService
            ->shouldReceive('checkout')
            ->once()
            ->andThrow(new \Exception('Service error'));

        $response = $this->post(route('checkout'), [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'product_code' => 'PROD123',
            'title' => 'Test Product',
            'description' => 'Test Description'
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function test_upload_file_checkout_success()
    {
        // Create a fake uploaded file
        $uploadedFile = UploadedFile::fake()->create(
            'test.pdf',
            100, // size in KB
            'application/pdf'
        );

        // Create a request with the uploaded file
        $request = new \Illuminate\Http\Request();
        $request->files->set('file', $uploadedFile);

        // Mock the saveFile method to return a successful response
        $this->methodService->shouldReceive('saveFile')
            ->once()
            ->with(Mockery::on(function ($arg) use ($uploadedFile) {
                return $arg === $uploadedFile;
            }))
            ->andReturn([
                'file_paths' => ['/storage/assets/media/task/test_123.pdf']
            ]);

        // Call the controller method
        $response = $this->controller->uploadFileCheckout($request);

        // Assert the response
        $this->assertEquals(200, $response->getStatusCode());
        $response->assertJson([
            'status' => true,
            'message' => 'File uploaded successfully',
            'file_paths' => ['/storage/assets/media/task/test_123.pdf']
        ]);
    }

    /** @test */
    public function test_upload_file_checkout_no_file()
    {
        $response = $this->post(route('upload-file-checkout'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
                'message' => 'File not found'
            ]);
    }

    /** @test */
    public function test_upload_file_checkout_error()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('test.pdf', 100);

        $this->methodService
            ->shouldReceive('saveFile')
            ->once()
            ->andThrow(new \Exception('Upload failed'));

        $response = $this->post(route('upload-file-checkout'), [
            'file' => $file
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
                'message' => 'Upload failed'
            ]);
    }
}
