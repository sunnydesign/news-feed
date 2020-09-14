# Установка

Выполнить сборку проекта 
```
docker-compose build
```

# Запуск
Запустить docker-контейнеры в фоновом режиме
```
docker-compose up -d
```

- Фронтенд доступен по адресу `https://localhost:9443`
- API доступен по адресу `https://localhost:9443/api/v1/[categories|articles]`

# Документация к API
https://app.swaggerhub.com/apis-docs/sunnydesign/news-feed/v1.1

# Остановка
Остановить docker-контейнеры
```
docker-compose down
```