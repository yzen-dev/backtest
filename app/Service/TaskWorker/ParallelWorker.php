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

    public function onProcessCreate(Semaphore $semaphore)
    {
    }

    public function onProcessDestroy()
    {
    }

    public function run($input)
    {
        /** @var Task $input */
        $input->handle();
    }
}
