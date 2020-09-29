## Laravel Blog learning project
This is a PHP project using the laravel framework that is supposed to simulate a real blog and show the proof of concept and knowledge of Laravel

# HOW TO RUN
## INSTALLATION
Install xampp -> https://www.apachefriends.org/index.html

Install composer -> https://getcomposer.org/

## XAMPP SETUP
{path}\xampp\apache\conf\httpd.conf 

>DocumentRoot "{PROJECT FILE PATH}"

><Directory "{PROJECT FILE PATH}">


{path}\xampp\apache\conf\extra\httpd-vhosts.conf 

><VirtualHost laravel.test:3000>

>this is required only if the default apache port 80 is taken

>creating the virtual host will allow the app to be shown at address laravel.test:3000

>this may also require changes to the hosts file in windows 127.0.0.1 laravel.test

>ENV variables can be set here => SetEnv DB_CONNECTION mysql

## PREPARE DATABASE AND LOCAL FILES

*NODE AND NPM REQUIRED* -> https://nodejs.org/en/download/


*INSTALL PRESET PACKAGES FROM package.json*

npm install

*INCLUDE ALL JS / CSS / SASS RESOURCES IN webpack.min.js*

npm run dev 

npm run watch
