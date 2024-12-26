A web application that provides an API for obtaining the Bitcoin cryptocurrency rate: BTC/USD, BTC/EUR, etc.

DEPLOY:
1. git clone https://github.com/ArtemKondratiuk/api-bitcoin
2. docker-compose build
3. docker-compose up -d
4. docker exec -it api-bitcoin-php-fpm bash
and inside container
5. cd ../app
6. composer install
7. bin/console doctrine:migrations:migrate

COMMAND FOR  UPDATE CURRENCY AUTOMATIOCALLY ONCE AN HOUR 

9. bin/console messenger:consume -v scheduler_default

COMMAND FOR POPULATE DB OR/AND UPDATE

bin/console app:currency-update

EXAMPLE REQUEST:

for get all currency

http://localhost/api/currency

for get currency by range

http://localhost/api/currency?from=2024-12-25 18:01:27&to=2024-12-25 18:14:37&page=1

