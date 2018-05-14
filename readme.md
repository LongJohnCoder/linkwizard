# url_shortner
#Tier5 URL Shortner


Run commands as instructed

sudo apt-get update

#installing php 7.0

sudo apt-get install -y php7.0 libapache2-mod-php7.0 php7.0-cli php7.0-common php7.0-mbstring php7.0-gd php7.0-intl php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-zip php7.0-soap libphp7.0-embed php7.0-opcache php7.0-cgi php7.0-bcmath php7.0-curl

#check your php version by php -v

sudo a2dismod php{your_version_number}
sudo a2enmod php7.0
sudo service apache2 restart

sudo update-alternatives --set php /usr/bin/php7.0
sudo update-alternatives --set phar /usr/bin/phar7.0
sudo update-alternatives --set phar.phar /usr/bin/phar.phar7.0
sudo update-alternatives --set phpize /usr/bin/phpize7.0
sudo update-alternatives --set php-config /usr/bin/php-config7.0

#installing browscap.ini

sudo wget -0 /etc/php/7.0/apache2/browscap.ini http://browscap.org/stream?q=BrowsCapINI

#now go to file /etc/php/7.0/apache2/php.ini and search for 'browscap.ini' by pressing ctrl+w
#if browscap extension is commented out paste the line below

browscap = /etc/php/7.0/apache2/browscap.ini

#now go to /etc/apache2/sites-available and create a local host file
#run below command

cd /etc/apache2/sites-available
sudo touch tr5.test.conf

#now open the file tr5.test.conf
sudo nano tr5.test.conf

#then paste these lines
...........................................................
<VirtualHost *:80>

        ServerAdmin webmaster@localhost
        ServerName  tr5.test
        DocumentRoot /var/www/html/url_shortner

        <Directory /var/www/html/url_shortner>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
...........................................................*

#then ctrl+x and then y to save

#now open /etc/hosts and paste the following lines

sudo nano /etc/hosts
127.0.0.1 tr5.test

#now run enable the virtual host just created

sudo a2ensite tr5.test.conf
sudo service apache2 restart


#now go to your html directory and run commands using https
git clone https://github.com/tier5/url_shortner.git

#----OR USING SSH------

git clone git@github.com:tier5/url_shortner.git

#then run following commands

sudo chown tier5:tier5 -R url_shortner

#go inside project directory and run the following commands

git checkout dev

cd url_shortner

composer update

sudo chmod 777 -R storage/ bootstrap/

php artisan key:generate

nano .env

#paste the following lines within the dotted lines into env file

....................................................................

APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://tr5.test
APP_HOST = tr5.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortner
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

.............................................................

#dont forget to give your db username and db password
#save the file after completion by ctrl+x and then y

#run migration
php artisan migrate

#run seeder
php artisan db:seed
