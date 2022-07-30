<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class Purchase extends Model
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
        'device_id',
        'receipt',
        'expire_time',
        'status'
    ];

    /**
     * Device
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Generate Receipt
     * @return string
     */
    public static function receipt(): string
    {
        return Str::random(18) . Random::generate('2', '0-9');
    }

    /**
     * Get Subscription
     * @param $token
     * @return Model|Builder|null
     */
    public static function getSubscription($token): Model|Builder|null
    {
        return self::with('device')
            ->whereRelation('device', 'id', $token)
            ->whereDate('expire_time', '>', date('Y-m-d H:i:s'))
            ->orderBy('expire_time', 'DESC')
            ->first();
    }

    /**
     * Rate Limit
     * @param $receipt
     * @return bool
     */
    public static function rateLimit($receipt): bool
    {
        $last = substr($receipt, -2);
        if (is_numeric($last) && $last % 6 == 0) {
            return false;
        }
        return true;
    }

    /**
     * Verify Purchase
     * @param $os
     * @param $receipt
     * @return array
     */
    public static function verify($os, $receipt): array
    {

        $last = substr($receipt, -1);
        $status = match ($os) {
            'ios' => (is_numeric($last) && $last % 2 != 0),
            'android' => !(is_numeric($last) && $last % 2 != 0),
            default => false,
        };
        return [
            'status' => $status,
            'expire_time' => date('Y-m-d H:i:s', strtotime('+1 month'))
        ];
    }
}
