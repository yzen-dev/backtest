<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;


use ReflectionClass;
use ReflectionProperty;
use Flagmer\Integrations\Amocrm\sendLeadDto;
use Flagmer\Billing\Account\processPaymentDto;
use stdClass;

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
     * Сопаставление категории и класса DTO
     */
    private const MAPPING = [
        'amocrm' => sendLeadDto::class,
        'account' => processPaymentDto::class,
    ];

    /**
     * Получение DTO
     *
     * @param stdClass $arg
     * @return mixed
     * @throws \ReflectionException
     */
    public static function get(stdClass $arg)
    {
        $dtoClass = self::getClass($arg->category);
        if (class_exists($dtoClass)) {
            $dto = new $dtoClass($arg);
            self::fillObject($dto, $arg);
            return $dto;
        }
        throw new \RuntimeException('Неудалось определить DTO класс для категории ' . $arg->category);
    }

    /**
     * Заполнение объекта данными
     *
     * @param sendLeadDto|processPaymentDto $object
     * @param stdClass $arg
     * @throws \ReflectionException
     */
    private static function fillObject(&$object, stdClass $arg): void
    {
        $ref = new ReflectionClass(get_class($object));
        $properties = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $item) {
            if (isset($arg->data->{$item->getName()})) {
                $object->{$item->getName()} = $arg->data->{$item->getName()};
            }
        }
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
