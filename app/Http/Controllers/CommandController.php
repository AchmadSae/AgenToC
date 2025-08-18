<?php

namespace App\Http\Controllers;

use App\Services\AuthInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CommandController extends Controller
{
    protected AuthInterface  $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }


    public function hasVerifiedEmail($email)
    {
          try {
                $response = $this->authService->hasVerifiedEmail($email);

                // Initialize default response
                $result = [
                      'status' => false,
                      'data' => null
                ];

                if ($response) {
                      $userData = DB::table('user_detail')
                            ->join('users', 'users.user_detail_id', '=', 'user_detail.id')
                            ->where('users.user_detail_id', $response['userDetailId'])
                            ->select(
                                  'user_detail.credit_number AS card_number',
                                  'users.name'
                            )
                            ->first();

                      $result = [
                            'status' => true,
                            'data' => $userData
                      ];
                }else {
                      $result = [
                            'status' => false,
                            'data' => 'Email not registered or not verified!. Please confirm your email confirmation or try with new email for create Accounts.'
                      ];
                }

                return response()->json($result);

          } catch (\Throwable $th) {
                Log::error('Failed to check email', [
                      'email' => $email,
                      'error' => $th->getMessage(),
                      'trace' => $th->getTraceAsString()
                ]);

                return response()->json([
                      'status' => false,
                      'message' => 'An error occurred while checking email',
                      'error' => config('app.debug') ? $th->getMessage() : null
                ], 500);
          }
    }
}
