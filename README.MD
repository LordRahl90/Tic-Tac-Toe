#TIC-TAC-TOE WEB-APP.
This Application is a web based Tic-Tac-Toe app developed with vuejs and laravel.<br />
Vue-JS is used for the front end. Vuex is used for the store.<br />

Laravel is used for the backend mainly because it is 'batteries included.'

#Pre-requisites
* composer
* nodejs/npm
* docker/docker-compose


To Setup The Application, Follow the following steps.

* Clone the project from the repo.
* Navigate to the folder which the application is downloaded.
* run `composer install` to install all the dependencies.
* run `npm install` to install the npm dependencies.
* copy `.envs/local/.app.env.example` to `.envs/local/.app.env` and set the variables accordingly.
* copy `.envs/local/.mysql.env.example` to `.envs/local/.mysql.env.example` and also set the values accordingly.
    <br />Please make sure that the database values match, else the application won't connect to the database
* run `docker-compose up -d` to start the system (this might take a while for the first run).
* run `make migrate` once the previous installation is completed. This migrate all the database tables, and also seeds the default computer player


The default port is 9901, however, it can be changed in the `docker-compose.yml` file to any available port.<br />
To Stop the application, run `make stop`