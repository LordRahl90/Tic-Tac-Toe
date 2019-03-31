start:
	docker-compose up -d

migrate:
	docker-compose exec app php artisan migrate:fresh --seed

stop:
	docker-compose kill