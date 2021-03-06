Фоновый обработчик

Для работы интеграций необходимо выполнять задачи в фоне.
Например, нам пришла заявка - мы должны отправить ее на какой-то внешний сервис.

Есть тестовая библиотека с бизнес-логикой. Две функции: Account - processPayment и Amocrm - sendLead.
Список задач, которые нужно выполнить в файле tasks.json

Необходимо написать обработчик, который будет выполнять задачи, указанные в файле.
Важно, чтобы задачи выполнялись параллельно в несколько потоков (N - задается в конфиге).
Можно использовать любые технологии (очереди и тп).

___

### Использование
Перед использованием необходимо вызвать команду 
```
composer install
```
Количество потоков задается с помощью поля **`NUMBER_THREADS`** в **.env**

Для запуска сервиса необходимо вызвать:
```
php index.php
```

Для запуска тестов
```
php ./vendor/bin/phpunit --configuration ./phpunit.xml
or
composer run-script test
```
После тестов будет сгенерирован html файл в директории public, с результатом всех выполненых тестов.

Запускаем phpstan для анализа кода
```
./vendor/bin/phpstan analyse -c ./phpstan.neon
or
composer run-script phpstan
```

Для запуска анализатора php CodeSniffer
```
./vendor/bin/phpcs --config-set default_standard phpcs.xml
./vendor/bin/phpcs --extensions=php
or
composer run-script phpcs
```
