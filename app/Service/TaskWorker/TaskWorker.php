<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;

use App\Helpers\PrintConsole;

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
     * TaskWorker constructor.
     */
    public function __construct()
    {
        $this->parsingService = new ParseTasksList();
    }

    /**
     * Выполнить список задач
     */
    public function handle()
    {
        PrintConsole::info('Начинается обработка задач. Потоков: ' . $_ENV['NUMBER_THREADS'] );
        try {
            $list = $this->parsingService->parse(__DIR__ . '/../../../tasks.json')->getTaskList();
            /** @var Task $item */
            foreach ($list as $item) {
                $item->handle();
            }
            PrintConsole::success('Все задачи выполнены');
        } catch (\Exception $e) {
            PrintConsole::error('Ошибка обработки задач.' . $e->getMessage());
            PrintConsole::error($e->getTraceAsString());
        }
    }
}
