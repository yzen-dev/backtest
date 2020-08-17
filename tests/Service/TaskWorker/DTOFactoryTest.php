<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Tests\TestCase;
use App\Service\TaskWorker\DTOFactory;
use Flagmer\Billing\Account\processPaymentDto;
use Flagmer\Integrations\Amocrm\sendLeadDto;

final class DTOFactoryTest extends TestCase
{
    /**
     * Проверка инициализации DTO объекта
     *
     * @testdox Фабрика DTO
     * @group dto_factory
     * @dataProvider defaultDataSet
     * @param $data
     */
    public function testParseFile($data): void
    {
        foreach ($data as $item) {
            $data = (object) $item;
            $dto = DTOFactory::get($data);
            switch ($data->category) {
                case 'account':
                    $this->assertInstanceOf(processPaymentDto::class, $dto);
                    break;
                case 'amocrm':
                    $this->assertInstanceOf(sendLeadDto::class, $dto);
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
