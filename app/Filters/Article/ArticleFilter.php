<?php

namespace App\Filters\Article;

use App\Filters\EloquentFilterContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ArticleFilter implements EloquentFilterContract
{
    public function __construct(
        protected Request $request
    )
    {
    }

    public function applyEloquent(Builder $model): Builder
    {

        if ($this->request->filled('tag_id')) {
            $model->whereHas('tags', function (Builder $q) {
                $q->where('tags.id', $this->request->get('tag_id'));
            });
        }
        return $model;
    }

    public static function getRequest(Request $request): static
    {
        return new static($request);
    }
}
