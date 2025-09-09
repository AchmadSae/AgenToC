<?php

namespace Tests\Util;

use App\Mail\Receipt;
use App\Models\GlobalParam;
use App\Util\EmailUtil;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class EmailUtilTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    public function testSendReceipt()
    {
          $mock = Mockery::mock('alias:' . GlobalParam::class);
          $mock->shouldReceive('where->value')->andReturn('mocked-value');

          $dataReceipt = [
                'full_name' => 'test',
                'order_id' => '100-123456',
                'product_name' => 'test',
                'total_price' => '100000',
                'price' => '100000',
                'ordered_at' => '2025-09-11 12:12:29',
                'email' => 'achmad.saepudin21@gmail.com'
          ];
          $emailUtil = new EmailUtil();
          $response = $emailUtil->sendReceipt($dataReceipt);
          #check assertion not error
          Mail::assertSent(Receipt::class, function ($mail) use ($dataReceipt) {
                $this->assertEquals($dataReceipt['order_id'], $mail->data['order_id']);
                return $mail->hasTo($dataReceipt['email']);
          });


          $this->assertTrue($response);
    }
}
