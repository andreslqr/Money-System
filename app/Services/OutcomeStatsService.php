<?php

namespace App\Services;

use App\DTO\DashboardDTO;
use App\Models\Outcome;
use Illuminate\Support\Collection;

class OutcomeStatsService extends BalanceStatsService
{
    public function getModel(): string 
    {
        return Outcome::class;
    }

    public function getOutcomeTotal(?DashboardDTO $dashboardDTO = null): float
    {
        return money(
            $this->query($dashboardDTO)
                ->sum('amount')
        )->formatByDecimal();
    }
}
