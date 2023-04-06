# Sezane test information

## Installation

### Docker initialization 
1. ``` docker compose build ```
2. ``` docker exec -it www_sezane_test bash ```

### Project initialization 
1. ``` composer install ```
2. ``` php bin/console doctrine:database:create ```
2. ``` php bin/console doctrine:database:create --env=test ```
3. ``` php bin/console do:mi:mi ```
4. ``` php bin/console doctrine:fixtures:load ```


## URL 

api doc : http://127.0.0.1:8000/api/doc
phpmyadmin : http://127.0.0.1:8080
website : http://127.0.0.1:8000
