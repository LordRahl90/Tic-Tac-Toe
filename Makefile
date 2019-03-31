start:
	docker-compose up -d
	docker-compose exec app php artisan config:cache

migrate:
	docker-compose exec app php artisan migrate:fresh --seed

stop:
	docker-compose kill