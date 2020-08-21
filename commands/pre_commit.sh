#!/bin/bash

PASS=true
echo "Validating PHPCS:"

which ./vendor/bin/phpcs &> /dev/null
if [ $? -eq 1 ]; then
  echo "Please install PHPCS"
  exit 1
fi

./vendor/bin/phpcs --config-set default_standard phpcs.xml
./vendor/bin/phpcs --extensions=php app --standard=PSR2

if [ $? -eq 0 ]; then
  echo "PHPCS Passed!"
else
  echo "PHPCS Failed!"
  PASS=false
fi

echo "PHPCS validation completed!"

if ! $PASS; then
  echo "COMMIT FAILED: Ваш коммит содержит файлы, которые не прошли PHPCS."
  echo "COMMIT FAILED: Исправьте ошибки PHPCS и повторите попытку."
  exit 1
else
  echo "COMMIT SUCCEEDED"
fi

exit $?