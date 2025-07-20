<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;


interface TaskInterface
{
    public function stored($data): array;
    public function approval($id): bool;
    public function editTask($id, $data): bool;
    public function bindTask($id, $workerId): bool;
    public function deleteTask($id);
    public function revision($data): array;
    public function getAllTask($status = 'done', $isDeadline = false): Collection;
}
