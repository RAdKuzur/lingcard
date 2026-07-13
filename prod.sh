docker compose -f docker-compose.prod.yml up --build -d
docker compose exec backend php artisan key:generate
docker compose exec backend php artisan jwt:secret