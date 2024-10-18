<?php

namespace App\Events;

use App\States\CustomerState;
use Thunk\Verbs\Attributes\Autodiscovery\StateId;
use Thunk\Verbs\Event;

class CustomerCount extends Event
{
    #[StateId(CustomerState::class)]
    public int $customer_id;

    // public function validate(CustomerState $state)
    // {
    //     $this->assert(
    //         $state->trial_started_at === null
    //             || $state->trial_started_at->diffInDays() > 365,
    //         'This user has started a trial within the last year.'
    //     );
    // }

    public function apply(CustomerState $state)
    {
        $state->count = $state->count + 1;
    }
}
