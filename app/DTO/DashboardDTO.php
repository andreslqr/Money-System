<?php

namespace App\DTO;

class DashboardDTO extends BaseDTO
{
    public function __construct(
        public array $accountingPeriodIds,
        public array $businessCategoryIds,
        public array $businessIds,
        public array $userIds
    ) { }
}
