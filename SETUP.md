# Linkwizard ( Tier5 URI shortener)

## SETUP INSTRCUCTIONS

1. Run this command into terminal to clone the project

```git clone git@github.com:tier5development/url_shortner.git linkwizard```

- In step 1 linkwizard is just a file name in which the user can replace it or if the user will not give the name then project name will be url_shortner.

2. Run this command into terminal to go to the project folder

```cd linkwizard```

- In step 2 give the file name by which you saved the project in your local.

3. Run this command to check your branch

```git branch```

- By git branch the user can see the branch that is master most probably.

4. Run this command to go to the development branch

```git checkout dev```

5. Run this command to pull the remote data into the user local

```git pull origin dev```

6. Run this command to fetch all the updated codes

```git fetch```

7. Run this command into terminal to copy the .env.example file and rename it .env

```cp .env.example .env```

8. Run this command into terminal to edit .env file

```sudo nano .env```

9. Copy this code and paste it in .env file

```
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://tr5.test
APP_HOST = tr5.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={db_name}
DB_USERNAME={db_username}
DB_PASSWORD={db_password}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=database

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=work@tier5.us
MAIL_PASSWORD=!Aworker2#4
MAIL_ENCRYPTION=tls

STRIPE_KEY       = pk_test_NeErELVu7Qbv59BWm0c7HQT1
STRIPE_SECRET    = sk_test_BHTf6x3tSwf9Zf53ZvFaCA95

STRIPE_PUBLISHABLE_SECRET = pk_test_NeErELVu7Qbv59BWm0c7HQT1
```
10. Set database name , user name , user password in .env file

- Change the DB_DATABASE, DB_USERNAME, DB_PASSWORD value with "database name, database username, database password" respectively.

11. Manually Create the databse in mysql

- Create a database in mysql with same database name which you provided as "DB_DATABASE" value.

12. Run this command into terminal to install all dependencies by composer update.

```composer update```

13. Run this command into terminal to generate Laravel Application Key

```php artisan key:gen``` OR ```php artisan key:generate```

- This command will generate a key in .env file.

14. Run this command into terminal to change the code of DatabaseSeeder.php  and save it

```sudo nano database/seeds/DatabaseSeeder.php```

15. Comment the code which is given below

- ```//$this->call(UsersTableSeeder::class);```

16. Run this command to go back to the project folder

```cd ../../```

17. Run this command into terminal to create all tables

```php artisan migrate```

18. Run this command into terminal for seeding table

```php artisan db:seed```

19. Run this command into terminal to give the permission to public , bootstrap and storage folder

```sudo chmod -R 777 public/ bootstrap/ storage/```

20. Run this command to copy settings.php and paste it into the config folder with same name

```cp settings.php config/settings.php```

22. Run this command into terminal to go to the config folder

```cd config```

23. Run this command to change the code of settings.php

```sudo nano settings.php```

24. Set APP_HOST , APP_LOGIN_HOST , APP_REDIRECT_HOST in settings.php file

- Change the APP_HOST , APP_LOGIN_HOST , APP_REDIRECT_HOST with the servername repectively from which the user wants to create the virtual host.

25. Run this command into terminal to copy .htaccess file

```cp .htaccess.example .htaccess```

26. Run this command into terminal to open .htaccess file

```sudo nano .htaccess```

27. Uncomment the following code from .htaccess by (#)

```
#RewriteCond %{HTTP:Authorization} .
#RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
```

## INSTRUCTIONS FOR BROWSCAP.INI

1. Install browscap.ini

```sudo wget -O /etc/php/7.1/apache2/browscap.ini http://browscap.org/stream?q=BrowsCapINI```

- Change the php version as per the user system requires.
- now go to file /etc/php/7.1/apache2/php.ini and search for 'browscap.ini' by pressing ctrl+w
- if browscap extension is commented out paste the line below
- ```browscap = /etc/php/7.1/apache2/browscap.ini```

## INSTRUCTIONS FOR VIRTUAL HOST

1. Run this command into terminal to go the the sites-available folder

```cd /etc/apache2/sites-available/```

2. Run this command into terminal to copy the 000-default.conf to project conf file

```cp 000-default.conf linkwizard.local.conf```

- This linkwizard.local.conf is only the example but the user can give any name with the .conf extension

3. Run this command into terminal to edit the servername , document root and directory

```sudo nano linkwizard.local.conf```

4. Set the ServerName , DocumentRoot and Directory as follows and save it

```
        ServerAdmin webmaster@localhost
        ServerName linkwizard.local
        DocumentRoot /var/www/html/LinkWizard
        <Directory /var/www/html/LinkWizard>
                AllowOverride All
        </Directory>
```

- This is also a example. The user have to give the folder name of the project and server name that the user wants as a virtual host

5. Run this command into terminal to enable the site

```sudo a2ensite linkwizard.local.conf```

6. Run this commans into terminal to restart apache2

```sudo service apache2 reload``` OR ```sudo service apache2 restart```

7. Run this command into terminal to create the virtual host in the localhost

```sudo nano /etc/hosts```

8. Add this code to hosts file which is given below

- 127.0.0.1     linkwizard.local