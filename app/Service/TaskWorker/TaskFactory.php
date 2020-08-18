<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;


use App\Service\TaskWorker\TaskAdapters\AmocrmAdapter;
use App\Service\TaskWorker\TaskAdapters\AccountAdapter;
use stdClass;

/**
 * Class TaskFactory
 * 
 * Генерация адаптеров задач
 * 
 * @package App\Service\TaskWorker
 */
class TaskFactory
{
    /**
     * Сопаставление категории и класса адаптера
     */
    private const MAPPING = [
        'amocrm' => AmocrmAdapter::class,
        'account' => AccountAdapter::class,
    ];

    /**
     * Получение адаптера задачи по его категории
     *
     * @param stdClass $arg
     * @return Task
     * @throws \ReflectionException
     */
    public static function get(stdClass $arg): Task
    {
        $taskClass = self::getClass($arg->category);
        if (class_exists($taskClass)) {
            $dto = DTOFactory::get($arg);;
            return new $taskClass($dto);
        }
        throw new \RuntimeException('Неудалось определить DTO класс для категории ' . $arg->category);
    }

    /**
     * Получение класса по ключу (категории) 
     * 
     * @param string $slug Категория
     * @return string|null Класс адаптера
     */
    private static function getClass(string $slug): ?string
    {
        if (array_key_exists($slug, self::MAPPING)) {
            return self::MAPPING[$slug];
        }
        return null;
    }
}
