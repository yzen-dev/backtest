<?php
declare(strict_types=1);

namespace App\Service\TaskWorker\TaskAdapters;

use Flagmer\Billing\Account;
use App\Service\TaskWorker\Task;
use Flagmer\Billing\Account\processPaymentDto;

/**
 * Class AccountAdapter
 * @package App\Service\TaskWorker\TaskAdapters
 */
class AccountAdapter implements Task
{
    /**
     * @var Account
     */
    private Account $job;
    
    /**
     * @var processPaymentDto
     */
    private processPaymentDto $dto;

    /**
     * AccountAdapter constructor.
     * @param processPaymentDto $dto
     */
    public function __construct(processPaymentDto $dto)
    {
        $this->job = new Account();
        $this->dto = $dto;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $this->job->processPaymentAction($this->dto);
    }
}
