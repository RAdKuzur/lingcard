<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *  @property int $id
 * @property int $user_id
 * @property int $news_id
 * @property int $status
 *
 * @property User $user
 * @property News $news
 *
 */
class Reaction extends Model
{
    protected $table = 'reactions';
    protected $fillable = [
        'news_id',
        'user_id',
        'status'
    ];

    public function news() : BelongsTo
    {
        return $this->belongsTo(News::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
