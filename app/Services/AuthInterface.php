<?php

namespace App\Services;

use SebastianBergmann\CodeUnit\FunctionUnit;

interface AuthInterface
{
    public function login($data): ?bool;
    public function register($data): array;
    public function forgotPassword($data): bool;
    public function reset($data): bool;
    public function ensureIsNotRateLimited($data);
    public function throttleKey($email);

}