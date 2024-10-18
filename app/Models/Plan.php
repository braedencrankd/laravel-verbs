<?php

namespace App\Models;

use App\States\PlanReportState;
use App\States\GlobalReportState;
use App\Events\PlanReportGenerated;
use App\Events\GlobalReportGenerated;
use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    use HasSnowflakes;

    public function generateReport(): PlanReportState
    {
        return PlanReportGenerated::fire(plan_id: $this->id)
            ->states()
            ->firstOfType(PlanReportState::class);
    }

    public static function generateGlobalReport(): GlobalReportState
    {
        $e = GlobalReportGenerated::fire();

        return $e->states()->firstOfType(GlobalReportState::class);
    }
}
