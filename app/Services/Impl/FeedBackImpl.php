<?php

namespace App\Services;

use App\Models\FeedBackModel;
use App\Services\FeedBackInterface;
use Illuminate\Support\Facades\DB;

class FeedBackImpl implements FeedBackInterface
{


    public function __construct() {}

    public function store(array $data): array
    {
        DB::transcation(function () use ($data) {
            $feedback = new FeedBackModel();
            $feedback->user_id = $data['user_id'];
            $feedback->message = $data['message'];
            $feedback->rating = $data['rating'];
            $feedback->save();

            return $feedback;
        });

        return $data;
    }

    public function getAllFeedbacks()
    {
        return FeedBackModel::where('message', '=', null)->orderBy('created_at', 'desc')->paginate(5);
    }

    public function getFeedbackById(int $id)
    {
        return FeedBackModel::findOrFail()->where('user_id', $id)->first();
    }

    public function deleteFeedbackById(int $id): bool
    {
        $isUnread = FeedBackModel::where('id', $id)->value('is_read');

        $feedback = FeedBackModel::findOrFail($id);
        return $feedback->delete();
    }
}
