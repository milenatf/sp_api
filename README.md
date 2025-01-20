# Instalação em ambiente de desenvolvimento

## Requirements
    - Laravel 11
    - PHP 8.2 ou maior
    - Docker
    - Docker compose

## Passos iniciais para levantar o ambiente

Criar o .env no diretório raiz da aplicação
```sh
cp .env.example .env
```

Alterar as variáveis de ambiente no .env
> APP_NAME="Sim Pará"
>
> APP_URL=http://localhost:8003
>
> DB_CONNECTION=mysql
>
> DB_HOST=db_sim_para
>
> DB_PORT=3306
>
> DB_DATABASE=db_sim_para
>
> DB_USERNAME=admin
>
> DB_PASSWORD=123

Gerar as imagens e os containers

```sh
docker compose up --build
```

Se, no log do container do mysql, for exibida a mensagem abaixo, quer dizer que o banco de dados está executando corretamente

> db_micro_auth | 2025-01-08T17:25:24.343789Z 0 [System] [MY-011323] [Server] X Plugin ready for connections. Bind-address: '::' port: 33060, socket: /var/run/mysqld/mysqlx.sock

> db_micro_auth | 2025-01-08T17:25:24.343867Z 0 [System] [MY-010931] [Server] /usr/sbin/mysqld: ready for connections. Version: '8.0.40' socket: '/var/run/mysqld/mysqld.sock' port: 3306 MySQL Community Server - GPL.


Acessar o container da aplicação
```sh
docker compose exec sim_para_app bash
```

Instalar as dependências

```sh
composer install
```
Gerar a chave do laravel

```sh
php artisan key:generate
```
Executar a migration
```sh
php artisan migrate
```

No container da aplicação, gerar o usuario master
```sh
php artisan db:seed
```

Acessar a aplicação no navegador
```
localhost:8003
```

Autenticar, como master, na aplicação
> login: master@mail.com.br
>
> senha: !Password123

- IMPLEMENTAR O PASSWORD RESET
- E O ENVIO DE EMAIL PARA O RESET PASSWORD
- Levantar os requisitos das validações dos campos da tabela posts
- Mudar o dto de StorePostDTO e UpdatePostDTO para StoreUpdatePostDTO