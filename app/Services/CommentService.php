<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\CommentModel;

class CommentService
{
    public function storeComment(int $articleId, string $title, string $content): void
    {
        CommentModel::query()->create([
            'article_id' => $articleId,
            'title' => $title,
            'content' => $content,
        ]);
    }
}
