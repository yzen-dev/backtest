<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Tests\TestCase;
use App\Service\TaskWorker\TaskWorker;

final class TaskWorkerTest extends TestCase
{
    /**
     * Проверка работы воркера
     *
     * @testdox Task worker
     * @group worker
     * @dataProvider defaultDataSet
     * @param $data
     */
    public function testParseFile($data): void
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
    
    public function defaultDataSet(): array
    {
        return [
            'Task 1' => [[
                [
                    'category' => 'account',
                    'task' => 'processPayment',
                    'data' => [
                        'account_id' => 123,
                        'amount' => 59000
                    ]
                ],
                [
                    'category' => 'amocrm',
                    'task' => 'sendLead',
                    'data' => [
                        'lead_id' => 1
                    ]
                ]
            ]],
            'Task 2' => [[
                [
                    'category' => 'account',
                    'task' => 'processPayment',
                    'data' => [
                        'account_id' => 345,
                        'amount' => 99000
                    ]
                ],
                [
                    'category' => 'amocrm',
                    'task' => 'sendLead',
                    'data' => [
                        'lead_id' => 2
                    ]
                ]
            ]],
        ];
    }

}
