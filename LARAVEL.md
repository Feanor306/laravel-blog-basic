## INSTALLATION
Install xampp -> https://www.apachefriends.org/index.html
Install composer -> https://getcomposer.org/
Install octobercms -> https://octobercms.com/docs/setup/installation

## XAMPP SETUP
{path}\xampp\apache\conf\httpd.conf 
>DocumentRoot "{PROJECT FILE PATH}"
><Directory "{PROJECT FILE PATH}">

{path}\xampp\apache\conf\extra\httpd-vhosts.conf 
><VirtualHost laravel.test:3000>
>this may also require changes to the hosts file in windows 127.0.0.1 laravel.test
>ENV variables can be set here => SetEnv DB_CONNECTION mysql

## DOCUMENTATION
LARAVEL -> https://laravel.com/docs/7.x
ELOQUENT -> https://laravel.com/docs/7.x/eloquent
OCTOBERCMS -> https://octobercms.com/docs/setup/installation 

## CREATE PROJECT
composer create-project --prefer-dist laravel/laravel {NAME}
composer create-project october/october {NAME}

## CHEAT SHEET
LARAVEL -> https://github.com/piotr-jura-udemy/laravel-cheat-sheet
MARKDOWN -> https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet 
ORIG PROJECT -> https://github.com/piotr-jura-udemy/laravel-course

## LARAVEL UI
DOC -> https://laravel.com/docs/7.x/frontend
composer require laravel/ui --dev
php artisan ui bootstrap
php artisan ui bootstrap --auth
>can use vue or react instead of bootstrap

## WEBPACK / LARAVEL MIX
*DOCUMENTATION* -> https://laravel.com/docs/7.x/mix
*NODE AND NPM REQUIRED* -> https://nodejs.org/en/download/

*INSTALL PRESET PACKAGES FROM package.json*
npm install

*INCLUDE ALL JS / CSS / SASS RESOURCES IN webpack.min.js*
npm run dev 
npm run watch

## TESTING
*UNIT TEST COMMAND*
./vendor/bin/phpunit

*LARAVEL DEBUGBAR*
composer require barryvdh/laravel-debugbar --dev

## AUTHENTICATION
*SINCE LARAVEL 7.0+ WE NEED TO GENERATE AUTH CONTROLLERS*
composer require laravel/ui
php artisan ui:controllers

*SCAFFOLD ROUTES AND VIEWS FOR AUTHENTICATION*
php artisan make:auth

*CAN ALSO GENERATE AUTH VIEWS WHILE SETTING UP UI*
php artisan ui bootstrap --auth

## FILE UPLOADS
*CONFIGURATION AT App\config\filesystems.php*
*SET THIS INTO .ENV FILE*
FILESYSTEM_DRIVER=public

*CREATE SYMBOLIC LINK FROM 'public/storage' to 'storage/app/public'*
php artisan storage:link

## ARTISAN COMMANDS
### CONTROLLERS
*CREATE CONTROLLER* in \app\http\controllers\ 
php artisan make:controller {NAME}Controller 
*CREATE RESOURCE CONTROLLER*
php artisan make:controller {NAME}Controller --resource

*CUSTOM REQUEST* in \app\http\requests\
php artisan make:request {Name}         {f ex StorePost}

*AUTH POLICY FOR MODEL*
php artisan make:policy {ModelName}Policy --model={ModelName} 

### MODELS
*CREATE MODEL WITH MIGRATION* in \app\ 
php artisan make:model {TableName} -m
*ALTER TABLE MIGRATION* in \database\migrations
php artisan make:migration add_{field}_to_{table_name}_table --table={table_name}

*RUN MIGRATIONS* 
php artisan migrate
*REVERT AND RECREATE ALL MIGRATIONS*
php artisan migrate:refresh

### FACTORY
*CREATE FACTORY*
php artisan make:factory {ModelName}Factory --model={ModelName}

*CREATE SEEDER*
php artisan make:seeder UsersTableSeeder
*RUN THIS AFTER EACH NEW SEEDER*
composer dump-autoload

*SEED DATABASE*
php artisan db:seed 
php artisan migrate:refresh --seed


