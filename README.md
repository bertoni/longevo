TEST LONGEVO
============


Criar o Banco de Dados

    php bin/console doctrine:database:create


Validar o schema do Banco de Dados

    php bin/console doctrine:schema:validate


Gerar o schema do Banco de Dados

    php bin/console doctrine:schema:update --force


Gerar os links simbólicos dos bundles

    php bin/console assets:install --symlink


Não esquecer das permissões nas pastas que necessitam de escrita

    chmod -R 2775 var/logs/
    chmod -R 2775 var/cache/


Gerar a massa de dados

    php bin/console doctrine:fixtures:load


Rodar os Testes

    ./vendor/phpunit/phpunit/phpunit --colors=always --configuration tests/AttendanceBundle/phpunit_suitcases.xml --testsuite all

