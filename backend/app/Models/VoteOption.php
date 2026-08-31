<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @property int $id
 * @property int $vote_id
 * @property string $title
 * @property string $content
 *
 * @property Vote $vote
 * @property Voice[] $voices
 */
class VoteOption extends Model
{
    use HasFactory;
    protected $table = 'vote_options';
    protected $fillable = [
        'vote_id',
        'title',
        'content',
    ];

    /**
     * Get the vote that this option belongs to.
     */
    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class);
    }

    /**
     * Get the voices for this vote option.
     */
    public function voices(): HasMany
    {
        return $this->hasMany(Voice::class);
    }
}
