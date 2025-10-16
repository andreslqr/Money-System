<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasDashboardFilters;
use Filament\Widgets\ChartWidget;

class IncomeSummaryChart extends ChartWidget
{
    use HasDashboardFilters;

    protected ?string $heading = 'Income Chart';

    protected function getData(): array
    {
        return $this->statsService->getIncomesSummary(
            $this->pageFiltersDTO()
        );
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
