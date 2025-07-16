<?php

namespace App\Services;


interface TaskInterface
{
    public function stored($data): array;
    public function approval($id): bool;
    public function editTask($id, $data): bool;
    public function bindTask($id, $workerId): bool;
    public function deleteTask($id);
    public function revision($data): array;
}
