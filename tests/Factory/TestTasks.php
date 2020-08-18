<?php
declare(strict_types=1);

namespace Tests\Factory;


/**
 * Class TestTasks
 * @package Tests\Factory
 */
class TestTasks
{
    /**
     * Дефолтный набор данных для тестирования
     *
     * @return array[][][]
     */
    public static function getCollection(): array
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
