<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\CommentModel;
use App\Models\ReactionModel;

class ReactionService
{
    public function checkLikedReaction(string $ip, int $articleId): bool
    {
        $reaction = ReactionModel::query()
            ->where('ip', '=', $ip)
            ->where('article_id', '=', $articleId)
            ->first();
        if ($reaction) {
            if ($reaction->liked === 1) {
                $reaction->update([
                    'liked' => false
                ]);
                return false;
            }
            $reaction->update([
                'liked' => true
            ]);
            return true;
        }
        ReactionModel::query()
            ->create([
                'ip' => $ip,
                'article_id' => $articleId,
                'liked' => true
            ]);
        return true;
    }

    public function checkShowedReaction(string $ip, int $articleId): bool
    {
        $reaction = ReactionModel::query()
            ->where('ip', '=', $ip)
            ->where('article_id', '=', $articleId)
            ->first();
        if ($reaction) {
            if ($reaction->showed === 0) {
                $reaction->update([
                    'showed' => true
                ]);
                return true;
            }
            return false;
        }
        ReactionModel::query()
            ->create([
                'ip' => $ip,
                'article_id' => $articleId,
                'showed' => true
            ]);
        return true;
    }
}
