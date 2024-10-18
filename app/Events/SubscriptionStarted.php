<?php

namespace App\Events;

use Thunk\Verbs\Event;
use App\Models\Subscription;
use App\States\GlobalReportState;
use App\States\PlanReportState;
use App\States\SubscriptionState;
use Thunk\Verbs\Support\StateCollection;

class SubscriptionStarted extends Event
{
    public int $user_id;

    public int $plan_id;

    public ?int $subscription_id = null;

    public function states(): StateCollection
    {
        $this->subscription_id ??= snowflake_id();

        return new StateCollection([
            SubscriptionState::load($this->subscription_id),
            PlanReportState::load($this->plan_id),
            GlobalReportState::singleton(),
        ]);
    }

    public function validate(SubscriptionState $state)
    {
        return ! $state->is_active;
    }

    public function apply(SubscriptionState $state)
    {
        $state->is_active = true;
        $state->plan_id = $this->plan_id;
    }

    public function handle()
    {
        [$subscription_state] = $this->states();

        Subscription::create([
            'id' => $subscription_state->id,
            'user_id' => $this->user_id,
            'plan_id' => $this->plan_id,
            'is_active' => true,
        ]);
    }
}
