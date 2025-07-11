<?php

namespace App\Services;

use App\Models\KanbanModel;
use App\Repositories\KanbanInterface;
use App\Models\TaskModel;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class KanbanImpl implements KanbanInterface
{
    private $role;
    public function __construct()
    {
        $r = session('currentRole');
        $this->role = $r;
    }

    public function getItems(): Collection
    {
        $items = KanbanModel::with('task')->get();
        return $items;
    }

    public function getItemByStatus($id): KanbanModel
    {
        $item = KanbanModel::where('status', $id)->first();
        return $item;
    }

    public function storedDefult($data): array
    {
        $item = KanbanModel::where('status', $role)->first();
        return $item->toArray();
    }

    public function stored($data): array
    {
        $lastOrder = KanbanModel::where('status', $data['status'])->max('order');
        $data['order'] = $lastOrder + 1;

        $item = new KanbanModel($data);
        $item->save();

        $item = KanbanModel::create($data);
        return $item->toArray();
    }

    public function update($id, $data): bool
    {
        $item = KanbanModel::find($id);
        $item->update($data);
        return true;
    }

    public function destroy($id): bool
    {
        $item = KanbanModel::find($id);
        $item->delete();
        return true;
    }

    public function reorder($datas): bool
    {
        try {
            //code...
            foreach ($datas as $data) {
                # code...
                $t = KanbanModel::find($data['id']);
                $t->order = $data['order'];
                $t->status = $data['status'];
                $t->save();
            }
        } catch (\Throwable $th) {
            throw new BadRequestHttpException($th->getMessage());
            return false;
        }
        return true;
    }
}
