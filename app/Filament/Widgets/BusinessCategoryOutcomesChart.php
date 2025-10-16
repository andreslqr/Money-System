<?php

namespace App\Filament\Widgets;

use App\Filament\Widgets\Concerns\HasDashboardFilters;
use Filament\Widgets\ChartWidget;

class BusinessCategoryOutcomesChart extends ChartWidget
{
    use HasDashboardFilters;

    protected ?string $heading = 'Business Category Outcomes Chart';

    protected function getData(): array
    {
        return $this->statsService->getBusinessCategoryOutcomes(
            $this->pageFiltersDTO()
        );
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
