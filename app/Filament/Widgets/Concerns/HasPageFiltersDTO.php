<?php

namespace App\Filament\Widgets\Concerns;

use App\DTO\BaseDTO;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Collection;

trait HasPageFiltersDTO
{
    use InteractsWithPageFilters;

    // protected static string $pageFiltersDTO;

    // protected static array $DTOmappings = [];

    protected function pageFiltersDTO(): BaseDTO
    {
        return static::$pageFiltersDTO::from(
            Collection::make($this->pageFilters)
                        ->mapWithKeys(function($value, $key): array {
                            return [
                                (static::$DTOmappings[$key] ?? $key) => $value
                            ];
                        })
                        ->toArray()
        );
    }
}
