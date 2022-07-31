<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Nette\Utils\Random;

/**
 * Device Model
 * @property int $id
 * @property int $app_id
 * @property int $uid
 * @property string $language
 * @property string $os
 * @property string $token
 */
class Device extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_id',
        'uid',
        'language',
        'os',
        'token'
    ];

    /**
     * Purchases
     * @return HasMany
     */
    public function purchase(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * App
     * @return BelongsTo
     */
    public function app(): BelongsTo
    {
        return $this->belongsTo(App::class);
    }

    /**
     * Generate Hash
     * @return bool|string
     */
    public static function hash(): bool|string
    {
        return hash('sha256', Str::random(18));
    }

    /**
     * Generate UID
     * @return string
     */
    public static function uid(): string
    {
        return Random::generate(10, '0-9');
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Purchase::class)->orderBy('expire_time', 'DESC')->latest();
    }

}
