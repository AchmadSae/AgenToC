<?php

namespace App\Services;

use SebastianBergmann\CodeUnit\FunctionUnit;

interface AuthInterface
{
    public function login($data): array;
    public function register($data, $isTransaction = false): array;
    public function forgotPassword($data): bool;
    public function reset($data): bool;
    public function ensureIsNotRateLimited($data);
    public function throttleKey($email);
    public function hasVerifiedEmail($userDetailId);

    public function deleteRelatedUser($userDetailId): bool;


}
