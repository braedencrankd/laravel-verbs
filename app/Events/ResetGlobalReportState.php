<?php

namespace App\Events;

use Thunk\Verbs\Event;
use App\States\GlobalReportState;
use Thunk\Verbs\Support\StateCollection;

class ResetGlobalReportState extends Event
{
    public function states(): StateCollection
    {
        return new StateCollection([
            GlobalReportState::class => GlobalReportState::singleton(),
        ]);
    }

    public function apply(GlobalReportState $state)
    {
        $state->subscribes_since_last_report = 0;
        $state->unsubscribes_since_last_report = 0;
        $state->last_reported_at = now();
    }
}
