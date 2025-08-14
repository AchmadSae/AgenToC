<?php

namespace Tests\Feature;

use App\Services\MethodServiceUtil;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Fake the storage
        Storage::fake('public');
    }

      /** @test */
      public function it_actually_saves_file_to_public_directory()
      {
            // This test actually saves the file to verify the real behavior
            $file = UploadedFile::fake()->create(
                  'test_actual.pdf',
                  100,
                  'application/pdf'
            );

            // Ensure the directory exists
            $directory = public_path('assets/media/task');
            if (!is_dir($directory)) {
                  mkdir($directory, 0777, true);
            }

            // Make the request to your actual endpoint
            $response = $this->post(route('upload-file-checkout'), [
                  'file' => $file
            ], [
                  'Accept' => 'application/json'
            ]);

            // Assert the response is successful
            $response->assertStatus(200)
                  ->assertJson([
                        'status' => true,
                        'message' => 'File uploaded successfully'
                  ]);

            // Get the actual file path from the response
            $filePath = $response->json('file_paths.0');

            // Remove the leading slash to get the relative path
            $relativePath = ltrim($filePath, '/');

            // Assert the file exists in the public directory
            $this->assertFileExists(public_path($relativePath));

            // Clean up after test
//            if (file_exists(public_path($relativePath))) {
//                  unlink(public_path($relativePath));
//            }
      }

    /** @test */
    public function it_can_upload_a_file()
    {
        // Create a test file
        $file = UploadedFile::fake()->create(
            'test.pdf',
            100, // size in KB
            'application/pdf'
        );

        // Create a mock of the MethodServiceUtil
        $methodService = $this->mock(MethodServiceUtil::class);
        $methodService->shouldReceive('saveFile')
            ->once()
            ->andReturn([
                'file_paths' => ['/public/assets/media/task/test_123.pdf']
            ]);

        // Make the request to upload the file
        $response = $this->post(route('upload-file-checkout'), [
            'file' => $file
        ], [
            'Accept' => 'application/json'
        ]);
        $filePath = $response['file_paths'];
        var_dump($filePath);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'File uploaded successfully',
                'file_paths' => ['/public/assets/media/task/test_123.pdf']
            ]);
    }

    /** @test */
    public function it_returns_error_when_no_file_is_uploaded()
    {
        $response = $this->post(route('upload-file-checkout'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => false,
                'message' => 'File not found'
            ]);
    }
}
