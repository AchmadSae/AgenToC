<?php

namespace App\Repositories;

use App\Models\TaskModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

interface TaskInterface
{

    public function stored($data): array;
    public function approval($id): bool;
    public function bindTask($id, $workerId): bool;
    public function deleteTask($id);
}
