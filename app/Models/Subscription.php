<?php

namespace App\Models;

use App\Events\SubscriptionCancelled;
use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasSnowflakes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'bool',
        'cancelled_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function cancel()
    {
        SubscriptionCancelled::fire(subscription_id: $this->id);
    }
}
