<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *  @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property int $status
 *
 * @property User $user
 * @property Post $post
 *
 */
class Reaction extends Model
{
    protected $table = 'reactions';
    protected $fillable = [
        'post_id',
        'user_id',
        'status'
    ];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
