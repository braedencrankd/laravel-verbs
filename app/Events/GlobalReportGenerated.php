<?php

namespace App\Events;

use App\Models\Report;
use Thunk\Verbs\Event;
use App\States\GlobalReportState;
use Thunk\Verbs\Attributes\Hooks\Once;
use Thunk\Verbs\Attributes\Autodiscovery\AppliesToSingletonState;

#[AppliesToSingletonState(GlobalReportState::class)]
class GlobalReportGenerated extends Event
{
    #[Once]
    public function handle()
    {
        $state = $this->state(GlobalReportState::class);

        Report::create([
            'plan_id' => null,
            'subscribes_since_last_report' => $state->subscribes_since_last_report,
            'unsubscribes_since_last_report' => $state->unsubscribes_since_last_report,
            'total_subscriptions' => $state->total_subscriptions,
            'summary' => $state->summary(),
        ]);

        ResetGlobalReportState::fire();
    }
}
