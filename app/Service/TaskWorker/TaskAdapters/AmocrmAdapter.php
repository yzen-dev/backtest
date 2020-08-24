<?php
declare(strict_types=1);

namespace App\Service\TaskWorker\TaskAdapters;

use App\Service\TaskWorker\Task;
use Flagmer\Integrations\AmoCrm;
use Flagmer\Integrations\Amocrm\sendLeadDto;

/**
 * Class AmocrmAdapter
 * @package App\Service\TaskWorker\TaskAdapters
 */
class AmocrmAdapter implements Task
{
    /**
     * @var AmoCrm
     */
    private AmoCrm $job;
    /**
     * @var sendLeadDto
     */
    private sendLeadDto $dto;

    /**
     * AmocrmAdapter constructor.
     * @param sendLeadDto $dto
     */
    public function __construct(sendLeadDto $dto)
    {
        $this->job = new AmoCrm();
        $this->dto = $dto;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $this->job->sendLeadAction($this->dto);
    }
}
