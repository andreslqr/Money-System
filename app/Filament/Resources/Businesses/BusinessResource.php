<?php

namespace App\Filament\Resources\Businesses;

use App\Filament\Resources\BusinessCategories\BusinessCategoryResource;
use App\Filament\Resources\BusinessCategories\Filters\BusinessCategory;
use App\Filament\Resources\Businesses\Pages\ManageBusinesses;
use App\Models\Business;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use UnitEnum;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 4;

    protected static string | UnitEnum | null $navigationGroup = 'Business';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('business_category_id')
                    ->relationship('businessCategory', 'name')
                    ->getOptionLabelFromRecordUsing(fn(Model $record): View => view('filament.resources.businesses.forms.components.partials.business-category', ['record' => $record]))
                    ->searchable()
                    ->preload()
                    ->allowHtml()
                    ->createOptionForm(function(Schema $schema): Schema {
                        return BusinessCategoryResource::form($schema);
                    })
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('coordinates')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('businessCategory.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                BusinessCategory::make('businessCategory')
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageBusinesses::route('/'),
        ];
    }
}
