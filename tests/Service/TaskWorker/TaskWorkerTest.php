<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Tests\Factory\TestTasks;
use Tests\TestCase;
use App\Service\TaskWorker\TaskWorker;

/**
 * Class TaskWorkerTest
 * @package Tests\Sevice\TaskWorker
 */
final class TaskWorkerTest extends TestCase
{
    /**
     * Проверка работы воркера
     *
     * @testdox Task worker
     * @group worker
     * @dataProvider defaultDataSet
     * @param array[][][] $data
     * @throws \QXS\WorkerPool\WorkerPoolException
     */
    public function testParseFile(array $data): void
    {
        $path = 'tmp/testWorkerFile.json';
        $myfile = fopen($path, 'wb') or die('Cannot open the file');

        fwrite($myfile, json_encode($data, JSON_UNESCAPED_UNICODE));
        fclose($myfile);
        $worker = new TaskWorker();
        $worker->setNumberThreads(2)->setDir($path);
        $worker->handle();
        $this->assertTrue(true);
    }

    /**
     * Дефолтный набор данных для тестирования
     * 
     * @return array[][][]
     */
    public function defaultDataSet(): array
    {
        return TestTasks::getCollection();
    }

}
