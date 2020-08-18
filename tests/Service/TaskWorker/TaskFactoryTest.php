<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Tests\TestCase;
use Tests\Factory\TestTasks;
use App\Service\TaskWorker\TaskFactory;
use App\Service\TaskWorker\TaskAdapters\AmocrmAdapter;
use App\Service\TaskWorker\TaskAdapters\AccountAdapter;

/**
 * Class TaskFactoryTest
 * @package Tests\Sevice\TaskWorker
 */
final class TaskFactoryTest extends TestCase
{
    /**
     * Проверка инициализации задач
     *
     * @testdox Фабрика Task
     * @group dto_factory
     * @dataProvider defaultDataSet
     * @param array[][][] $data
     */
    public function testParseFile(array $data): void
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
