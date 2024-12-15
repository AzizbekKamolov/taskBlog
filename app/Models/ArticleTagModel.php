<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTagModel extends Model
{
    use HasFactory;

    protected $table = 'article_tags';
    protected $fillable = ['article_id', 'tag_id', 'created_at', 'updated_at'];
}
