<?php

namespace App\Services;

use App\DTO\DashboardDTO;
use Illuminate\Database\Eloquent\Builder;

abstract class BalanceStatsService
{
    protected const CHUNK_COUNT = 500;
    
    public function query(?DashboardDTO $filters = null): Builder
    {
        return $this->getModel()::query()
                    ->when($filters?->accountingPeriodIds, function(Builder $query, array $ids): void {
                        $query->whereIn('accounting_period_id', $ids);
                    })
                    ->when($filters?->businessCategoryIds, function(Builder $query, array $ids): void {
                        $query->whereHas('business', fn(Builder $q) => $q->whereIn('business_category_id', $ids));
                    })
                    ->when($filters?->businessIds, function(Builder $query, array $ids): void {
                        $query->whereIn('business_id', $ids);
                    })
                    ->when($filters?->userIds, function(Builder $query, array $ids): void {
                        $query->whereIn('user_id', $ids);
                    });
    }

    abstract protected function getModel(): string;
}
