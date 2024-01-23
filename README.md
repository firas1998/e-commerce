# e-commerce project

## Requirements

-   Docker
-   docker-compose v3
-   Free ports required:
    -   8000 (backend)
    -   8080 (frontend)
    -   12574 (mysql)

## Environment variables

```
cd vue-e-commerce
cp .env.example .env

cd ../laravel-e-commerce
cp .env.example .env
```

## Running locally

```
docker-compose up -d
# Accessable on http://localhost:8080/
```
