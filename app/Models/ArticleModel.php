<?php
declare(strict_types=1);

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id;
 * @property string $photo;
 * @property string $title;
 * @property string $slug;
 * @property string $short_content;
 * @property string $content;
 * @property int $showed;
 * @property int $liked;
 * @property string $created_at;
 * @property string $updated_at;
 */
class ArticleModel extends Model
{
    use HasFactory, EloquentFilterTrait;

    protected $table = 'articles';
    protected $fillable = [
//      "id",
        "photo",
        "title",
        "slug",
        "short_content",
        "content",
        "showed",
        "liked",
        "created_at",
        "updated_at",
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TagModel::class, 'article_tags', 'article_id', 'tag_id');
    }

    public function isLiked(): HasOne
    {
        return $this->hasOne(ReactionModel::class, 'article_id', 'id')
            ->where('liked', 1)->where('ip', '=', request()->ip());
    }
}
