<?php

namespace App\Events;

use App\Models\Report;
use Thunk\Verbs\Event;
use App\States\PlanReportState;
use App\Events\ResetPlanReportState;
use Thunk\Verbs\Attributes\Hooks\Once;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;

class PlanReportGenerated extends Event
{
    #[StateId(PlanReportState::class)]
    public int $plan_id;

    #[Once]
    public function handle()
    {
        $state = $this->state(PlanReportState::class);

        Report::create([
            'plan_id' => $this->plan_id,
            'subscribes_since_last_report' => $state->subscribes_since_last_report,
            'unsubscribes_since_last_report' => $state->unsubscribes_since_last_report,
            'total_subscriptions' => $state->total_subscriptions,
            'summary' => $state->summary(),
        ]);

        ResetPlanReportState::fire(plan_id: $this->plan_id);
    }
}
