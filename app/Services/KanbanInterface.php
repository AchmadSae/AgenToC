<?php

namespace App\Repositories;

use App\Models\KanbanModel;
use Illuminate\Database\Eloquent\Collection;

interface KanbanInterface
{
    public function getItems(): Collection;
    public function getItemByStatus($id): KanbanModel;
    public function storedDefult($data): array;
    public function stored($data): array;
    public function update($id, $data): bool;
    public function destroy($id): bool;
    public function reorder($data): bool;
}
