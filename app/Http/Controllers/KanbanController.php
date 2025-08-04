<?php
namespace App\Http\Controllers;
use App\Models\KanbanModel;
use App\Services\KanbanInterface;
use Illuminate\Support\Facades\Request;

class KanbanController extends Controller
{
      protected KanbanInterface $kanbanService;

      public function update(Request $request)
      {
            $task = KanbanModel::findOrfail($request->id);
            $task->name = $request->name;
            $task->update();

            return response()->json(['task' => $task]);
      }

      public function reorder(Request $request)
      {
            $tasks = $request->tasks;
            foreach ($tasks as $task) {
                  $t = KanbanModel::find($task['id']);
                  $t->order = $task['order'];
                  $t->status = $task['status'];
                  $t->save();
            }

            return response()->json(['message' => 'Tasks order updated successfully']);
      }

      public function destroy(Request $request)
      {
            KanbanModel::where('id', $request->id)->delete();

            return response()->json(['message' => 'Task deleted successfully']);
      }
}
