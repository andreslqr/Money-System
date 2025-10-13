<?php

namespace App\Filament\Resources\Incomes;

use App\Filament\Resources\Incomes\Pages\ManageIncomes;
use App\Models\AccountingPeriod;
use App\Models\Income;
use App\Models\PaymentMethod;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowLeftEndOnRectangle;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->string()
                    ->maxLength(255),
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->prefix('$'),
                Select::make('payment_method_id')
                    ->relationship('paymentMethod')
                    ->options(function(): Collection {
                        return auth()->user()
                                    ->paymentMethods()
                                    ->get(['payment_methods.id', 'name'])
                                    ->mapWithKeys(fn(PaymentMethod $paymentMethod): array => [$paymentMethod->getKey() => $paymentMethod->name]);
                    })
                    ->required(),
                Select::make('business_id')
                    ->relationship('business', 'name')
                    ->required(),
                FileUpload::make('receipt_photo')
                            ->image()
                            ->visibility('public')
                            ->directory('outcomes')
                            ->imageEditor()
                            ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('accounting_period_id')
                    ->relationship('accountingPeriod', 'name')
                    ->default(fn(): int => AccountingPeriod::latest()->first()->getKey())
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(fn(): int => auth()->id())
                    ->required(),
                DatePicker::make('expense_date')
                    ->default(fn() => Carbon::now())
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('accountingPeriod.name')
                    ->label('accounting period name')
                    ->numeric(),
                TextEntry::make('paymentMethod.name')
                    ->numeric(),
                TextEntry::make('user.name')
                    ->label('User name')
                    ->numeric(),
                TextEntry::make('business.name')
                    ->label('Business name')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('expense_date')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Income $record): bool => $record->trashed()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('accountingPeriod.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('paymentMethod.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('business.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup('accountingPeriod.name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageIncomes::route('/'),
        ];
    }
}
