<?php

namespace App\Services;

use App\DTO\DashboardDTO;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Concurrency;

class StatsService
{
    public function __construct(
        protected IncomeStatsService $incomeStatsService,
        protected OutcomeStatsService $outcomeStatsService,
        protected BusinessCategoryStatsService $businessCategoryStatsService,
        protected ColorService $colorService
    ) {}

    public function getIncomesVsOutcomesData(?DashboardDTO $dashboardDTO = null): array
    {
        [$incomeTotal, $outcomeTotal] = Concurrency::run([
            fn() => $this->incomeStatsService->getIncomeTotal($dashboardDTO),
            fn() => $this->outcomeStatsService->getOutcomeTotal($dashboardDTO)
        ]);

        return [
            'datasets' => [
                [
                    'label' => __('Finances'),
                    'data' => [$incomeTotal, $outcomeTotal],
                    'backgroundColor' => ['#22c55e', '#ef4444'],
                ],
            ],
            'labels' => [__('Income'), __('Outcome')],
        ];
    }

    public function getIncomesSummary(?DashboardDTO $dashboardDTO = null): array
    {
        $incomes = $this->incomeStatsService->getIncomesSummary($dashboardDTO);

        return [
            'datasets' => [
                [
                    'label' => __('Incomes'),
                    'data' => array_column($incomes, 'amount'),
                    'backgroundColor' => $this->colorService->getColors(count($incomes))
                ],
            ],
            'labels' => array_column($incomes, 'name'),
        ];
    }

    public function getBusinessCategoryOutcomes(?DashboardDTO $dashboardDTO = null): array
    {
        $businessCategories = $this->businessCategoryStatsService->getBusinessCategoryOutcomes($dashboardDTO);

        return [
            'datasets' => [
                
            ]
        ];
    }
}
