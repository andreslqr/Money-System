<?php

namespace App\Services;

use App\DTO\DashboardDTO;
use App\Models\Income;
use Illuminate\Support\Collection;

class IncomeStatsService extends BalanceStatsService
{
    public function getModel(): string 
    {
        return Income::class;
    }

    public function getIncomeTotal(?DashboardDTO $dashboardDTO = null): float
    {
        $totalAmount = $this->query($dashboardDTO)->sum('amount');

        return money($totalAmount)->formatByDecimal();
    }

    public function getIncomesSummary(?DashboardDTO $dashboardDTO = null): array
    {
        return $this->query($dashboardDTO)
                    ->select('id', 'name', 'amount', 'business_id')
                    ->with('business:id,name')
                    ->get()
                    ->map(function(Income $income): array {
                        return [
                            'id' => $income->getKey(),
                            'name' => "{$income->business->name}: {$income->name}",
                            'amount' => $income->amount->formatByDecimal()
                         ];
                    })
                    ->toArray();
    }
}
