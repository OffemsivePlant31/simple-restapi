# Инструкция по запуску при использовании WSL/Linux.

## Первоначальная установка:
1. Скопировать репозиторий к себе
    ```bash
    git clone https://github.com/OffemsivePlant31/simple-restapi.git
    ```
2. Перейти в директорию проекта и создать .env файл
    ```bash
    cd simple-restapi
    cp .env.example .env
    ```
3. Поднять контейнеры
    ```bash
    docker-compose -f docker-compose.prod.yml up -d
    ```
4. Накатить миграции и запустить сидеры
    ```bash
    docker compose -f docker-compose.prod.yml exec app php artisan migrate:refresh --seed
    ```
5. После этого можно открыть фронт по адресу localhost:{port}, где port можно посмотреть с помощью данной команды либо в дашборде Docker Desktop
    ```bash
    docker compose -f docker-compose.prod.yml ps webserver-frontend
    ```
