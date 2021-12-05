# pumpingstation-backend

SETUP

В корневой папке 
docker-compose build

docker-compose up -d

docker-compose exec web composer require laravel/passport

docker-compose exec web php artisan passport:install --force

