<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id;
 * @property string $name;
 * @property string $created_at;
 * @property string $updated_at;
 * @method static Builder|static query()
 */
class TagModel extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(ArticleModel::class, 'article_tags', 'tag_id', 'article_id');
    }
}
