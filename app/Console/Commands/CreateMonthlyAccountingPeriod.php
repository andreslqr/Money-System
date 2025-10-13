<?php

namespace App\Console\Commands;

use App\Enums\AccountingPeriodStatus;
use App\Models\AccountingPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CreateMonthlyAccountingPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounting-period:create 
        {--start-date= : The starting date for accounting period; format: Y-m-d}
        {--end-date= : The ending date for accounting period; format: Y-m-e}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /**
         * @var \Illuminate\Support\Carbon $startDate
         * @var \Illuminate\Support\Carbon $endDate
         */
        [$startDate, $endDate] = $this->getAccountingPeriodDates();
        $name = __('Period from :startYear :startMonth to :endYear :endMonth', [
            'startYear' => $startDate->year,
            'startMonth' => $startDate->locale(config('app.locale'))->monthName,
            'startDay' => $startDate->day,
            'endYear' => $endDate->year,
            'endMonth' => $endDate->locale(config('app.locale'))->monthName,
            'endDay' => $endDate->day,
        ]);

        AccountingPeriod::firstOrCreate([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ], [
            'name' => $name,
            'status' => AccountingPeriodStatus::Open
        ]);
    }

    public function getAccountingPeriodDates(): array
    {
        $startDate = $this->option('start-date') ?
                        Carbon::createFromFormat('Y-m-d', $this->option('start-date')) :
                        Carbon::now()->startOfMonth();

        $endDate = $this->option('end-date') ?
                        Carbon::createFromFormat('Y-m-d', $this->option('start-date')) :
                        Carbon::now()->endOfMonth();
        return [
            $startDate,
            $endDate
        ];
    }
}
