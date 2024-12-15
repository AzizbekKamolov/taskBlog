<?php
namespace App\DataObjects;
use App\Models\ReactionModel;

class ReactionData
{
    public function __construct(
        public int $id,
        public int $article_id,
        public string $ip,
        public bool $showed,
        public bool $liked,
    )
    {
    }

    public static function fromModel(ReactionModel $reactionModel): static
    {
        return new static(
            $reactionModel->id,
            $reactionModel->article_id,
            $reactionModel->ip,
            $reactionModel->showed,
            $reactionModel->liked,
        );
    }
}
