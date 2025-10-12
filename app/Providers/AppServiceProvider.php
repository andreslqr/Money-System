<?php

namespace App\Providers;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Facades\FilamentTimezone;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentTimezone::set('America/Mexico_City'); 

        Field::configureUsing(function(Field $field): void {
            $field->translateLabel();
        });
        Column::configureUsing(function(Column $column): void {
            $column->translateLabel();
        });
        Entry::configureUsing(function(Column $column): void {
            $column->translateLabel();
        });
        Action::configureUsing(function(Action $action): void {
            $action->translateLabel();
        });
        Table::configureUsing(function(Table $table): void {
            $table->striped()
                    ->reorderableColumns();

        });
    }
}
