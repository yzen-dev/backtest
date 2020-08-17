<?php
declare(strict_types=1);

namespace App\Service\TaskWorker;


/**
 * Class ParseTasksList
 *
 * Класс для разбора списка задач из JSON
 */
class ParseTasksList
{
    /**
     * Список задач
     * @var array
     */
    private array $taskList = [];


    /**
     * Разбор списка задач
     *
     * @param string $path
     * @return ParseTasksList Список задач (Job)
     * @throws \Exception
     */
    public function parse(string $path): ParseTasksList
    {
        if (!file_exists($path)){
            throw new \RuntimeException("Файл $path для разбора задач не найден.");
        }

        $file = file_get_contents($path);
        try {
            $jsonList = json_decode($file, false    , 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception){
            throw new \RuntimeException("Проверьте корректность формата файла $path");
        }

        foreach ($jsonList as $item) {
            $this->taskList [] = TaskFactory::get($item);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getTaskList() : array
    {
        return $this->taskList;
    }
}
