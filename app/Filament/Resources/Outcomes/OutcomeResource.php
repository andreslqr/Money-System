<?php

namespace App\Filament\Resources\Outcomes;

use App\Enums\OutcomeStatus;
use App\Filament\Resources\AccountingPeriods\Filters\AccountingPeriodFilter;
use App\Filament\Resources\Businesses\BusinessResource;
use App\Filament\Resources\Outcomes\Pages\ManageOutcomes;
use App\Filament\Resources\PaymentMethods\Filters\PaymentMethodFilter;
use App\Filament\Resources\Users\Filters\UserFilter;
use App\Models\AccountingPeriod;
use App\Models\Outcome;
use App\Models\PaymentMethod;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OutcomeResource extends Resource
{
    protected static ?string $model = Outcome::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowRightStartOnRectangle;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 0;

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
                    ->stripCharacters(',')
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
                    ->required()
                    ->createOptionForm(function(Schema $schema): Schema {
                        return BusinessResource::form($schema);
                    }),
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
                    ->searchable()
                    ->relationship('user', 'name')
                    ->default(fn(): int => auth()->id())
                    ->required(),
                DatePicker::make('expense_date')
                    ->default(fn() => Carbon::now())
                    ->required(),
                Select::make('status')
                    ->options(OutcomeStatus::class)
                    ->default(fn(): OutcomeStatus => OutcomeStatus::Paid)
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
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Outcome $record): bool => $record->trashed()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('accountingPeriod.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('paymentMethod.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('business.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->alignEnd()
                    ->numeric()
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->translateLabel()
                            ->money(config('app.currency'))
                    ),
                TextColumn::make('expense_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
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
                AccountingPeriodFilter::make('accountingPeriod'),
                UserFilter::make('user'),
                PaymentMethodFilter::make('paymentMethod')
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
            ->defaultSort('expense_date', 'desc')
            ->defaultGroup('accountingPeriod.name');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageOutcomes::route('/'),
        ];
    }
}
