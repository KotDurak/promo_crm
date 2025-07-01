# Symfony + PostgreSQL Docker Setup

Этот проект демонстрирует создание и запуск Symfony-приложения с базой данных PostgreSQL, управляемой через Docker Compose. В проекте используются контейнеры для сервера, базы данных и веб-интерфейса для управления базой.

---

## Что было сделано

- Настроена инфраструктура Docker Compose с сервисами:
    - Symfony приложение
    - Nginx
    - PostgreSQL
    - Adminer (или pgAdmin) для управления базой
- Создан Dockerfile для PHP с Xdebug
- Настроены подключения к базе данных из Symfony
- Проверена работоспособность базы и соединения

---

## Как запустить проект локально

### 1. Клонируйте репозиторий или подготовьте проект

git clone <вашрепозиторий>
cd <папкапроекта>

### 2. Соберите проект
docker-compose up -d --build
docker-compose run --rm app composer create-project symfony/website-skeleton .


Контейнеры запустятся и будут доступны по портам:

- **Symfony**: [http://localhost:8080](http://localhost:8080)
- **Nginx**: [http://localhost:8080](http://localhost:8080)
- **PostgreSQL**: DATABASE_URL="postgresql://symfony_user:secret@db:5432/symfony?serverVersion=16&charset=utf8"
- **Adminer** (если включен): [http://localhost:8082](http://localhost:8082)
