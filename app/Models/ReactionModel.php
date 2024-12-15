<?php
declare(strict_types=1);

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id;
 * @property int $article_id;
 * @property bool @showed;
 * @property bool @liked;
 * @property string $created_at;
 * @property string $updated_at;
 */
class ReactionModel extends Model
{
    use HasFactory, EloquentFilterTrait;

    protected $table = 'reactions';
    protected $fillable = [
        "ip",
        'article_id',
        'showed',
        'liked',
        'created_at',
        'updated_at',
    ];
}
