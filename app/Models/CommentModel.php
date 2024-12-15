<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'article_id',
        'title',
        'content',
        'created_at',
        'updated_at',
    ];
}
