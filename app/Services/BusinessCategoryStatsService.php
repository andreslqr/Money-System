<?php

namespace App\Services;

use App\DTO\DashboardDTO;
use App\Models\BusinessCategory;
use Illuminate\Database\Eloquent\Builder;

class BusinessCategoryStatsService
{
    public function query(?DashboardDTO $filters = null): Builder
    {
        return BusinessCategory::query()
                            ->when($filters?->businessCategoryIds, function(Builder $query, array $ids): void {
                                $query->whereKey($ids);
                            })
                            ->when($filters?->businessIds, function(Builder $query, array $ids): void {
                                $query->whereHas('business', function(Builder $query) use ($ids): void {
                                    $query->whereKey($ids);
                                });
                            })
                            ->when($filters?->userIds, function(Builder $query, array $ids): void {
                                $query->where(function(Builder $query) use ($ids): void {
                                    $query->whereHas('outcomes', function(Builder $query) use ($ids): void {
                                        $query->whereIn('user_id', $ids);
                                    })
                                    ->orWhereHas('incomes', function(Builder $query) use ($ids): void {
                                        $query->whereIn('user_id', $ids);
                                    });
                                });   
                            })
                            ->when($filters?->accountingPeriodIds, function(Builder $query, array $ids): void {
                                $query->where(function(Builder $query) use ($ids): void {
                                    $query->whereHas('outcomes', function(Builder $query) use ($ids): void {
                                        $query->whereIn('accounting_period_id', $ids);
                                    })
                                    ->orWhereHas('incomes', function(Builder $query) use ($ids): void {
                                        $query->whereIn('accounting_period_id', $ids);
                                    });
                                });  
                            });
    }

    public function getBusinessCategoryOutcomes(?DashboardDTO $dashboardDTO = null): array
    {
        return [];


    }
}
