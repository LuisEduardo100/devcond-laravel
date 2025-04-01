# Sistema de Gestão de Condomínio

-   Cadastro de Usuário
-   Cadastro de Unidades
-   Cadastro de Ativos da Unidade (Moradores, Veículos, Pets)
-   Mural de Avisos
-   Documentos
-   Reserva das áreas comuns (Lista negra de datas)
-   Achados e perdidos
-   Livro de ocorrências
-   Boletos

## JWT DOCS

-   Autenticação
    ### https://jwt-auth.readthedocs.io/en/develop/

## Migration commands

-   php artisan migrate // roda todas as migrations
-   php artisan migrate:rollback // desfaz o último comando que carrega as migration
-   php artisan make:migrate nome-da-migration // cria a migration
-   php artisan migrate:fresh // dropa tabelas, prepara bd e roda as migrations novamente
-   php artisan migrate:reset // reverte as migrations aplicadas sem recriar as tabelas
