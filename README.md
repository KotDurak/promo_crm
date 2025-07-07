# Промокод-менеджер на Symfony

## Описание проекта

Система управления промокодами с REST API на базе Symfony. Проект предоставляет возможность создания, управления и отслеживания промокодов с использованием PostgreSQL в качестве базы данных.

## Технологии

* **Symfony** - PHP фреймворк
* **PostgreSQL** - база данных
* **Nginx** - веб-сервер
* **PHP 8.2** - язык программирования
* **Docker Compose** - оркестрация контейнеров

## Установка

### Требования

* Docker
* Docker Compose

### Запуск проекта

1. Клонирование репозитория:
```bash
git clone <ссылка-на-репозиторий>
cd проект
```

2. Запуск контейнеров:
```bash
docker-compose up -d
```

## Установка зависимостей

Для установки всех необходимых зависимостей используйте команду:
```bash
docker-compose run --rm app composer install
```

## Миграции

Для применения миграций выполните следующие команды:
```bash
docker-compose run --rm app php bin/console doctrine:migrations:migrate
```

## Использование консольных команд

Для выполнения консольных команд Symfony используйте:
```bash
docker-compose run --rm app php bin/console [команда]
```

Пример:
```bash
docker-compose run --rm app php bin/console doctrine:schema:update --force
```
