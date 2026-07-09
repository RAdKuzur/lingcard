<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $path
 * @property string $ip
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at

 */
class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'ip',
        'user_agent',
        'time',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}
