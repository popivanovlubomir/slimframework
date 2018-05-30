# Slim Framework 3 Skeleton Application

Used Slim Framework 3 to build very basic simple register/login/show data app using JWT token for authorization.

## Install the Application

    composer install

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

## Use application
* Import postman collections and environment files
* Run the app via you local webserver
* Create database and set the name/connection data in the phinx.yml in order to be able to run the migrations
* Run:
## 
    php vendor/bin/phinx migrate -e development
* Use postman to test endpoints