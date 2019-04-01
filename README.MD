# TIC-TAC-TOE WEB-APP.
This Application is a web based Tic-Tac-Toe app developed with vuejs and laravel.<br />
Vue-JS is used for the front end. Vuex is used for the store.<br />

Laravel is used for the backend mainly because it is 'batteries included.'



To Setup The Application, Follow the following steps.
# With Docker (Preferred)

# Pre-requisite.
* docker
* docker-compose


* run `git clone https://github.com/LordRahl90/Tic-Tac-Toe`.
* run `cd Tic-Tac-Toe`
* run `cp .envs/local/.mysql.env.example .envs/local/.mysql.env` and also set the variables accordingly.
* run `nano .envs/local/.mysql.env` to set the environment variables for the database
* run `cp .envs/local/.app.env.example .envs/local/.app.env`  and set the variables accordingly.
* run `nano .envs/local/.app.env` to use the database settings for the application
NB: Please make sure that the database values match, else the application won't connect to the database <br />
* run `make start` to start the system (this might take a while for the first run).
* to stop the application, run `make stop`

# Useful Commands

* `make fresh-migrate` to refresh the database migrations.
* `make clear-cache` to clear the config cache
* `make stop` to kill the application
* `make restart` to restart the application without refreshing the database.


# Regular/Development

# Pre-requisites
* php-7
* composer
* nodejs/npm

For development/contributions, make sure `composer`,`node` and `npm` are installed.
* run `git clone https://github.com/LordRahl90/Tic-Tac-Toe`.
* run `cd Tic-Tac-Toe`
* update `cp .env.example .env` and update with valid db credentials
* run `composer install` to install all the dependencies.
* run `npm install` to install the npm dependencies.
* run `php artisan key:generate` to generate the encryption key.
* run `php artisan migrate --seed` to generate the migrations and seed the default computer player.
* run `php artisan serve` To run the application on `localhost:8000`



The default port is 9901, however, it can be changed in the `docker-compose.yml` file to any available port.<br />
To Stop the application, run `make stop`
