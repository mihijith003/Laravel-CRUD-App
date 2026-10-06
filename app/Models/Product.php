<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory;
    use LogsActivity;


    #Adding Spatie traits
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','description','price','status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('product');
    }

    public const STATUS_ACTIVE = 0;
    public const STATUS_TRASHED = 1;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    /**
     * Hide trashed products from every normal query.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('notTrashed', function (Builder $query) {
            $query->where('status', '!=', self::STATUS_TRASHED);
        });
    }
}
