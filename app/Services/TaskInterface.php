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
    public function isRevisionExist($taskId): bool;
    public function storedTicketForRevision($data): array;

    public function downloadAttachment($id): string;
}
