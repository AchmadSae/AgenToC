<?php
namespace App\Util;

use App\Models\GlobalParam;
use App\Mail\Receipt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailUtil{
      public function sendReceipt($data): bool{
            try {
                  #send email receipt to user
                  $bank_receiver = GlobalParam::where("code", "=", 'TRANS_BANK')->value("value");
                  $care_number = GlobalParam::where("code", "=", 'TRANS_CARE_NUMBER')->value("value");
                  $company_email = GlobalParam::where("code", "=", 'COMPANY_EMAIL')->value("value");
                  $company_website = GlobalParam::where("code", "=", 'COMPANY_WEBSITE')->value("value");
                  $dataReceipt = [
                        'name' => $data['full_name'],
                        'order_id' => $data['order_id'],
                        'product_name' => $data['product_name'],
                        'total_price' => $data['total_price'],
                        'price' => $data['price'],
                        'bank_receiver' => $bank_receiver ?? 'not found',
                        'care_number' => $care_number ?? 'not found',
                        'company_email' => $company_email ?? 'not found',
                        'company_website' => $company_website ?? 'not found',
                        'ordered_at' => $data['ordered_at'],
                  ];
                  Mail::to($data['email'])->send(new Receipt($dataReceipt));
                  return true;
            }catch (\Exception $e){
                  Log::error('EmailUtil.sendReceipt', [$e->getMessage()]);
                  return false;
            }
      }
}
