<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Tests\TestCase;
use App\Service\TaskWorker\TaskFactory;
use App\Service\TaskWorker\TaskAdapters\AmocrmAdapter;
use App\Service\TaskWorker\TaskAdapters\AccountAdapter;

final class TaskFactoryTest extends TestCase
{
    /**
     * Проверка инициализации задач
     *
     * @testdox Фабрика Task
     * @group dto_factory
     * @dataProvider defaultDataSet
     * @param $data
     */
    public function testParseFile($data): void
    {
        foreach ($data as $item) {
            $data = (object) $item;
            $dto = TaskFactory::get($data);
            switch ($data->category) {
                case 'account':
                    $this->assertInstanceOf(AccountAdapter::class, $dto);
                    break;
                case 'amocrm':
                    $this->assertInstanceOf(AmocrmAdapter::class, $dto);
                    break;
            }
        }
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
