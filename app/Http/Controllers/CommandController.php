<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use App\Services\MethodServiceUtil;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CommandController extends Controller
{
    protected MethodServiceUtil $MethodServiceUtil;

    /**
     * send chat
     * @param mixed $taskId $message
     **/

    public function sendChat(Request $request, $taskId)
    {
        $data = $request->validate([
            'message' => 'required',
            'taskId' => 'required'
        ]);
        try {
            $this->MethodServiceUtil->sendMessage($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * push notification
     **/

    public function sendNotification(Request $request)
    {
        $data = $request->validate([
            'text' => 'required',
            'userId' => 'required'
        ]);
        try {
            $this->MethodServiceUtil->sendNotification($data);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * show notification
     **/

    public function showNotification(Request $request)
    {
        $user = auth()->user();
        $user_detail_id = $user->user_detail_id;

        return NotificationModel::where('user_id', $user_detail_id)
            ->where('is_read', false)
            ->latest()
            ->get();
    }

    /**
     * mark the as read
     **/

    public function markAsRead($id)
    {
        $notif = NotificationModel::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return response()->json(['status' => 'marked']);
    }

}
