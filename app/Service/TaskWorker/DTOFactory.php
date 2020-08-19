<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;


use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Flagmer\Integrations\Amocrm\sendLeadDto;
use Flagmer\Billing\Account\processPaymentDto;
use RuntimeException;

/**
 * Class DTOFactory
 *
 * Создание объекта DTO
 *
 * @package App\Service\TaskWorker
 */
class DTOFactory
{
    /**
     * Сопоставление категории и класса DTO
     * 
     * @var array
     */
    private const MAPPING = [
        'amocrm' => sendLeadDto::class,
        'account' => processPaymentDto::class,
    ];

    /**
     * Получение DTO
     *
     * @param object $arg Список аргументов
     * 
     * @return object
     * @throws ReflectionException
     */
    public static function get(object $arg)
    {
        $dtoClass = self::getClass($arg->category);
        if (class_exists($dtoClass)) {
            $dto = new $dtoClass($arg);
            $dto = self::fillObject($dto, $arg);
            return $dto;
        }
        throw new RuntimeException('Не удалось определить DTO класс для категории ' . $arg->category);
    }

    /**
     * Заполнение объекта данными
     *
     * @param object $object Заполняемый объект
     * @param object $arg Список аргументов
     * @return object
     * @throws ReflectionException
     */
    private static function fillObject($object, object $arg): object
    {
        $ref = new ReflectionClass(get_class($object));
        $properties = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $item) {
            if (isset($arg->data->{$item->getName()})) {
                $object->{$item->getName()} = $arg->data->{$item->getName()};
            }
        }
        return $object;
    }

    /**
     * Получение класса по ключу (категории)
     *
     * @param string $slug Категория задачи
     * @return string|null
     */
    private static function getClass(string $slug): ?string
    {
        if (array_key_exists($slug, self::MAPPING)) {
            return self::MAPPING[$slug];
        }
        return null;
    }
}
