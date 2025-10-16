<?php

namespace App\Filament\Widgets\Concerns;

use App\DTO\DashboardDTO;
use App\Services\StatsService;

trait HasDashboardFilters
{
    use HasPageFiltersDTO;

    protected StatsService $statsService;

    protected static string $pageFiltersDTO = DashboardDTO::class;

    protected static array $DTOmappings = [
        'accounting_period' => 'accountingPeriodIds',
        'business_category' => 'businessCategoryIds',
        'business' => 'businessIds',
        'user' => 'userIds'
    ];

    public function __construct()
    {
        $this->statsService = app(StatsService::class);
    }
}
