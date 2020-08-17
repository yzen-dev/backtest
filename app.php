<?php
declare(strict_types=1);

use App\Service\TaskWorker\TaskWorker;

$worker = new TaskWorker((int)$_ENV['NUMBER_THREADS']);
$worker->handle();
