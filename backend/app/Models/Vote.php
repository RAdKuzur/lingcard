<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @property int $id
 * @property string $title
 * @property bool $is_active
 * @property VoteOption[] $voteOptions
 */
class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    /**
     * Get the options for this vote.
     */
    public function voteOptions(): HasMany
    {
        return $this->hasMany(VoteOption::class);
    }
}
