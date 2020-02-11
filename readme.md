#Setting up application

__After git clone run the following command__
__Go inside the cloned folder__

$composer install

__Copy the .env.example to env and do following modifications__

$cp .env.example .env

__Add the following application url in .env__

This will need when running Selenium tests. Kindly note if not Selenium test cases will not run
APP_URL=http://localhost/test/public


__Create aa empty mysql database__

Set database settings in .env file

DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

__Give permission for logs and public folders. Kindly note for the testing it would be ok to give chmod 777__

$sudo chmod -R 777 storage/

__Setting up databases__

Run the following command to setup your database. This will create complete table structure in your database
$php artisan migrate:refresh

__Test card details for Stripe payments__

Card Details

Jenny Rosen

4242 4242 4242 4242

Exp Month year 12/18

CVS 123

__Testing Stripe payments__

This is my test account to stripe please login and see once you done payments to verify.

nad.live@gmail.com

Nad@1234

__Running PHPUnit and Selenium tests__

Kindly note I have written considerable amount of unit test during the time I had with few selenium test to cover some of the sections
You can see the unit test in tests/Feature directory

I have mocked the payment gatewal call so that Unit test will not intterupt due to payment gateway

Run the following command to run unit tests

 $./vendor/bin/phpunit

Please note you need to install xdebug if you need see the code coverage report

$brew install php70-xdebug


__Unit test will run without selenium server too__

To test selenium test run the following command

$php artisan selenium:start

__You will able to find the code coverage report in the following location__

./reports

