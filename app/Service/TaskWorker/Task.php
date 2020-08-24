<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;

/**
 * Interface Task
 * @package App\Service\TaskWorker
 */
interface Task
{

    /**
     * Выполнить задачу
     */
    public function handle(): void;
}
