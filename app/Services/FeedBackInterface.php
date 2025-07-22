<?php

namespace App\Services;

interface FeedBackInterface
{
    /**
     * Store feedback data.
     *
     * @param array $data
     * @return array
     */
    public function store(array $data): array;

    /**
     * Get all feedbacks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllFeedbacks();

    /**
     * Get feedback by ID.
     *
     * @param int $id user ID
     * @return mixed
     */
    public function getFeedbackById(int $id);

    /**
     * Delete feedback by ID.
     *
     * @param int $id feedback ID
     * @return bool
     **/

    public function deleteFeedbackById(int $id);
}
