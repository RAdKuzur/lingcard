<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property $vote_option_id
 * @property $time
 *
 * @property User $user
 * @property VoteOption $voteOption
 */
class Voice extends Model
{
    use HasFactory;
    protected $table = 'voices';
    protected $fillable = [
        'user_id',
        'vote_option_id',
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    /**
     * Get the user who cast this voice.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vote option that was chosen.
     */
    public function voteOption(): BelongsTo
    {
        return $this->belongsTo(VoteOption::class);
    }
}
