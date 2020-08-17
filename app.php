<?php
declare(strict_types=1);

use App\Helpers\PrintConsole;
use App\Service\TaskWorker\TaskWorker;

PrintConsole::info('Начинается обработка задач. Потоков: ' . (int)$_ENV['NUMBER_THREADS']);
try {
    $worker = new TaskWorker();
    $worker->setNumberThreads((int)$_ENV['NUMBER_THREADS']);
    $worker->handle();
} catch (\Exception $e) {
    PrintConsole::error('Ошибка обработки задач.' . $e->getMessage());
    PrintConsole::error($e->getTraceAsString());
    exit(0);
}
PrintConsole::success('Все задачи выполнены');
