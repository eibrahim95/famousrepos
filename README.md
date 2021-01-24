# Famous Github Repos Discoverer

A small web app built with laravel 8 to discover popular github repositories.

- List Most Famous repositories after a specific date.
- Option to list only 10, 50, 100.
- Filter Results By Programming Language.
- Run using Docker.
- Unit testing & automated testing.


## Using Docker
#### Running the app
You can simply run the app using docker-compose:  
Make sure port 8000 is not used on your host system and run :  
`docker-compose up web`  
You'll find the app running on http://127.0.0.1:8000
#### Running Tests
- You can run tests using `docker-compose run web php artisan test` 
- You can run automated tests using `docker-compose run web php artisan dusk`
- Of course if there is already a container running for the app you can just do :   
`docker exec -it DOCKER_ID php artisan test ` & `docker exec -it DOCKER_ID php artisan dusk `   

## Regular Usage
#### Running the app
- Make sure composer is installed and at the root of the project run : `composer install`
- [For Automated Testing] Make sure to set the right APP_URL in `.env` and run `php artisan dusk:install`
- [For Automated Testing] Make sure a fresh version of google chrome is installed on your system and run : 
`php artisan dusk:chrome-driver --detect`
- [For Automated Testing] On Systems where file permissions matter run : `chmod -R 0755 vendor/laravel/dusk/bin/`
 - Run the app using : `php artisan serve` you'll find it on : http://127.0.0.1:8000 
#### Running Tests
- You can run tests using `php artisan test` 
- You can run automated tests using `php artisan dusk`
