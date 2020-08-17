<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;

use QXS\WorkerPool\WorkerPool;
use QXS\WorkerPool\WorkerPoolException;

/**
 * Class TaskWorker
 *
 * Воркер для обработки задач
 *
 * @package App\Service\TaskWorker
 */
class TaskWorker
{
    /**
     * Сервис для разбора задач
     * @var ParseTasksList
     */
    private $parsingService;
    /**
     * @var int Кол-во потоков
     */
    private int $numberThreads;

    /**
     * TaskWorker constructor.
     * @param int $numberThreads Кол-во потоков
     */
    public function __construct(int $numberThreads)
    {
        $this->parsingService = new ParseTasksList();
        $this->numberThreads = $numberThreads;
    }

    /**
     * Выполнить список задач
     * @throws WorkerPoolException
     */
    public function handle()
    {
        $list = $this->parsingService->parse(__DIR__ . '/../../../tasks.json')->getTaskList();

        $wp = new WorkerPool();
        $wp->setWorkerPoolSize($this->numberThreads)->create(new ParallelWorker());
        if (!empty($list)) {
            foreach ($list as $item) {
                $wp->run($item);
            }
        }
        $wp->waitForAllWorkers();
    }
}
