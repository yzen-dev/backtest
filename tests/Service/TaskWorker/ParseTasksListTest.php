<?php
declare(strict_types=1);

namespace Tests\Sevice\TaskWorker;

use Exception;
use Tests\TestCase;
use Tests\Factory\TestTasks;
use App\Service\TaskWorker\Task;
use App\Service\TaskWorker\ParseTasksList;

final class ParseTasksListTest extends TestCase
{
    private ParseTasksList $parsingService;

    protected function setUp(): void
    {
        $this->parsingService = new ParseTasksList();
        parent::setUp();
    }

    /**
     * Проверка выкидывания ошибки при неверном формате
     *
     * @testdox Ошибочный формат данных
     * @group parse_tasks
     */
    public function testParseFileErrorFormat(): void
    {
        $path = 'tmp/testParseFileErrorFormat.json';
        $myfile = fopen($path, 'wb') or die('Cannot open the file');
        fwrite($myfile, '[');
        fclose($myfile);
        try {
            $this->parsingService->parse($path);
        } catch (Exception $e) {
            $this->assertTrue(true);
            return;
        }
        $this->fail('Ошибка не вызвана');
    }

    /**
     * Проверка пустого списка задач
     *
     * @testdox Пустой список задач
     * @group parse_tasks
     * @throws Exception
     */
    public function testParseFileEmpty(): void
    {
        $path = 'tmp/testParseFileEmpty.json';
        $myfile = fopen($path, 'wb') or die('Cannot open the file');
        fwrite($myfile, '[]');
        fclose($myfile);
        $result = $this->parsingService->parse($path)->getTaskList();
        $this->assertIsArray($result);
        $this->assertEquals([], $result);
    }

    /**
     * Проверка разбора списка задач
     *
     * @testdox Разбор списка задач
     * @group parse_tasks
     * @dataProvider defaultDataSet
     * @param $data
     * @throws Exception
     */
    public function testParseFile($data): void
    {
        $path = 'tmp/testParseFile.json';
        $myfile = fopen($path, 'wb') or die('Cannot open the file');

        fwrite($myfile, json_encode($data, JSON_UNESCAPED_UNICODE));
        fclose($myfile);
        $result = $this->parsingService->parse($path)->getTaskList();
        $this->assertIsArray($result);
        foreach ($result as $item) {
            $this->assertInstanceOf(Task::class, $item);
        }
    }

    public function defaultDataSet(): array
    {
        return TestTasks::getCollection();
    }

}
