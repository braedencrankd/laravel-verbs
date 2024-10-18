<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Subscription;
use App\Events\SubscriptionStarted;
use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use AuthenticatableTrait, HasFactory, HasSnowflakes;

    protected $guarded = [];

    public function subscribe(Plan $plan)
    {
        SubscriptionStarted::fire(
            user_id: $this->id,
            plan_id: $plan->id
        );
    }

    public function activeSubscription(Plan $plan): ?Subscription
    {
        return $this->active_subscriptions()->firstWhere([
            'plan_id' => $plan->id,
        ]);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('is_active', true);
    }
}
