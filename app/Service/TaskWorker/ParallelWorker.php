<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;

use QXS\WorkerPool\Semaphore;
use QXS\WorkerPool\WorkerInterface;

/**
 * Class WorkerTask
 * @package Task\WorkerTask
 */
class ParallelWorker implements WorkerInterface
{

    /**
     * {@inheritDoc}
     * @param Semaphore $semaphore
     */
    public function onProcessCreate(Semaphore $semaphore)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function onProcessDestroy()
    {
    }

    /**
     * {@inheritDoc}
     * @param \Serializable $input
     * @return \Serializable|void
     */
    public function run($input)
    {
        /** @var Task $input */
        $input->handle();
    }
}
