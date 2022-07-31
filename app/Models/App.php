<?php

namespace App\Models;

use App\Concerns\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App Model
 * @property int $id
 * @property string $name
 * @property string $callback
 */
class App extends Model
{
    use HasFactory, Filterable;

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
        'name',
        'callback'
    ];

    /**
     * Devices
     * @return HasMany
     */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
