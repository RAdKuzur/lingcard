<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property int $base_language_id
 * @property int $target_language_id
 * @property int $role
 * @property bool $is_banned
 * @property-read Language $baseLanguage
 * @property-read Language $targetLanguage
 * @property-read Course[]|HasMany $courses
 *
 * @property News[] $news
 * @property Reaction[] $reactions
 * @property Token[] $tokens
*/
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function baseLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'base_language_id');
    }

    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
