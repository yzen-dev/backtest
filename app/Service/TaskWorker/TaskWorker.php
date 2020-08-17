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
    private int $numberThreads = 2;
    
    /**
     * @var string Файл который парсим
     */
    private string $dir = __DIR__ . '/../../../tasks.json';

    /**
     * TaskWorker constructor.
     */
    public function __construct()
    {
        $this->parsingService = new ParseTasksList();
    }

    /**
     * Выполнить список задач
     * @throws WorkerPoolException
     */
    public function handle(): void
    {
        $list = $this->parsingService->parse($this->dir)->getTaskList();

        $wp = new WorkerPool();
        $wp->setWorkerPoolSize($this->numberThreads)->create(new ParallelWorker());
        if (!empty($list)) {
            foreach ($list as $item) {
                $wp->run($item);
            }
        }
        $wp->waitForAllWorkers();
    }

    /**
     * @return int
     */
    public function getNumberThreads(): int
    {
        return $this->numberThreads;
    }

    /**
     * @param int $numberThreads
     */
    public function setNumberThreads(int $numberThreads): TaskWorker
    {
        $this->numberThreads = $numberThreads;
        return $this;
    }

    /**
     * @return int|string
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param int|string $dir
     */
    public function setDir($dir): TaskWorker
    {
        $this->dir = $dir;
        return $this;
    }
}
