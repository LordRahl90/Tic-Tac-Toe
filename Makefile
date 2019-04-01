APP_ENV_FILE=.envs/local/.app.env
MYSQL_ENV_FILE=.envs/local/.mysql.env
TRUE=1
FALSE=0

start:
	@if [ -a $(MYSQL_ENV_FILE) ]; then \
    	docker-compose up -d ; \
	    docker-compose exec app php artisan config:cache ; \
	    docker-compose exec app php artisan migrate --seed; \
	else \
		echo "No Application config file found.\nPlease run 'cp .envs/local/.mysql.env.example .envs/local/.mysql.env' and set the values"; \
	fi;

	@if [ -a $(APP_ENV_FILE) ]; then echo "Application file set successfully." ; \
	 else \
	 echo "No Application config file found.\nPlease run 'cp .envs/local/.app.env.example .envs/local/.app.env' and set the values"; \
	  exit 0; \
  	fi ;

migrate:
	docker-compose exec app php artisan migrate --seed

fresh-migrate:
	docker-compose exec app php artisan migrate:fresh --seed

clear-cache:
	docker-compose exec app php artisan config:cache

stop:
	docker-compose kill

restart:
	docker-compose kill
	docker-compose up -d