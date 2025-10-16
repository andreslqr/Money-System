<?php

namespace App\Filament\Widgets;

use App\DTO\DashboardDTO;
use App\Filament\Widgets\Concerns\HasDashboardFilters;
use App\Filament\Widgets\Concerns\HasPageFiltersDTO;
use App\Services\StatsService;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class IncomesVsOutcomesChart extends ChartWidget
{
    use HasDashboardFilters;

    protected ?string $heading = 'Incomes Vs Outcomes';

    
    protected function getData(): array
    {
        return $this->statsService->getIncomesVsOutcomesData(
            $this->pageFiltersDTO()
        );  
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
