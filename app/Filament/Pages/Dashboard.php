<?php

namespace App\Filament\Pages;

use App\Models\AccountingPeriod;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as Page;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class Dashboard extends Page
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->inlineLabel()
                    ->schema([
                        Select::make('accounting_period')
                                ->multiple()
                                ->options(function(): Collection {
                                    return AccountingPeriod::latest()
                                                            ->pluck('name', 'id');
                                })
                                ->rules([
                                    'integer'
                                ])
                                ->columnSpanFull(),
                        Select::make('business_category')
                                ->label('Category')
                                ->live()
                                ->multiple()
                                ->options(function(): Collection {
                                    return BusinessCategory::query()
                                                            ->pluck('name', 'id');
                                })
                                ->rules([
                                    'integer'
                                ]),
                        Select::make('business')
                                ->multiple()
                                ->options(function(Get $get): Collection {
                                    return Business::query()
                                                    ->select('id', 'business_category_id', 'name')
                                                    ->orderByRaw('business_category_id IN (?) DESC', implode(',', $get('business_category')))
                                                    ->with('businessCategory:id,name')
                                                    ->get()
                                                    ->mapWithKeys(function(Business $business): array {
                                                        return [
                                                            $business->getKey() => "<b>{$business->businessCategory->name}</b>: {$business->name}"
                                                        ];
                                                    });
                                })
                                ->allowHtml()
                                ->rules([
                                    'integer'
                                ]),
                        Select::make('user')
                                ->multiple()
                                ->options(function(): Collection {
                                    return User::query()
                                                ->orderByRaw('id = ? DESC', auth()->id())
                                                ->pluck('name', 'id');
                                })
                                ->rules([
                                    'integer'
                                ]),

                    ])
                    ->columns(3)
                    ->columnSpanFull(1),
            ])
            ->columns(1);
    }
}
