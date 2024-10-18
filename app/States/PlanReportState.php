<?php

namespace App\States;

use Thunk\Verbs\State;
use Illuminate\Support\Carbon;
use App\Events\SubscriptionCancelled;
use App\Events\SubscriptionStarted;

class PlanReportState extends State
{
    public int $total_subscriptions = 0;

    public int $subscribes_since_last_report = 0;

    public int $unsubscribes_since_last_report = 0;

    public Carbon $last_reported_at;

    public function summary(): string
    {
        $churn = $this->subscribes_since_last_report > 0
            ? ($this->unsubscribes_since_last_report / $this->subscribes_since_last_report) * 100
            : 0;

        return implode('; ', [
            "{$this->subscribes_since_last_report} subscribe(s)",
            "{$this->unsubscribes_since_last_report} unsubscribe(s)",
            "{$churn}% churn",
        ]);
    }

    public function applySubscriptionStarted(SubscriptionStarted $e)
    {
        $this->total_subscriptions++;
        $this->subscribes_since_last_report++;
    }

    public function applySubscriptionCancelled(SubscriptionCancelled $e)
    {
        $this->unsubscribes_since_last_report++;
        $this->total_subscriptions--;
    }
}
