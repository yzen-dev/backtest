<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use ReflectionException;
use Tests\TestCase;
use Tests\Factory\TestTasks;
use App\Service\TaskWorker\DTOFactory;
use Flagmer\Integrations\Amocrm\sendLeadDto;
use Flagmer\Billing\Account\processPaymentDto;

/**
 * Class DTOFactoryTest
 * @package Tests\Sevice\TaskWorker
 */
final class DTOFactoryTest extends TestCase
{
    /**
     * Проверка инициализации DTO объекта
     *
     * @testdox Фабрика DTO
     * @group dto_factory
     * @dataProvider defaultDataSet
     * @param array[][][] $data
     * @throws ReflectionException
     */
    public function testParseFile(array $data): void
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
