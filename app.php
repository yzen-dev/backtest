<?php
declare(strict_types=1);

use App\Service\TaskWorker\TaskWorker;

$worker = new TaskWorker();
$worker->handle();