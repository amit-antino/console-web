<p align="center"><img src="https://simreka.com/wp-content/uploads/2019/04/simrekalogo-e1558361786117.png" width="400"></p>


## About Simreka Product

Simreka empowers consumer product brands and chemical/material manufacturers to rapidly bring new products to market with 100x faster experiments using AI-driven technology. Using Simreka, manufacturers can accelerate process innovation and new product discovery to transform supply chains for chemicals/materials that will be profitable, safer and sustainable. This acceleration is driven by our advanced technology platform (data collection, predictive- simulation, collaboration) that delivers high quality and unique data-driven multi-perspective decision support. By accelerating materials- and process innovation using a unique technology, we improve financial performance, reduce environmental impact, and brand risk for materials manufacturers and brand owners.

- Mission: Helping brands and manufacturers to reduce time-to-market with innovative and better products with advanced data-driven solutions.

- Vision: Contributing to a prosperous and sustainable future by enhancing holistic decision making activities using high quality data and scientific analytics

“Change brings opportunity.” (Nido Qubein)

## Setup Project
### Dependencies software and installation

- Apache Web Server Installation
```
apt install apache2 -y
```
```
nano /etc/apache2/mods-enabled/dir.conf
```
- update dir.conf file
```
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```
- Mysql Server Installation
```
apt install mysql-server -y
```
```
mysql -u root -p
```
- Enter new  password :example (Git@123#)
```
create database DatabaseName;
```
```
create user 'root'@'localhost' identified by 'Git@123$';
```
```
grant all on *.* to 'root'@'localhost';
FLUSH PRIVILEGES;
exit;
```
- Restart mysql server
```
systemctl restart mysql
```
- PHP7.4 installation with required all extension
```
apt install php7.4 -y && apt install php7.4-common php7.4-mysql php7.4-bcmath php7.4-xml php7.4-xmlrpc php7.4-curl php7.4-gd php7.4-imagick php7.4-cli php7.4-dev php7.4-imap php7.4-mbstring php7.4-opcache php7.4-soap php7.4-zip php7.4-intl -y && apt-get install php7.4-ldap
```
- Composer installation
```
curl -sS https://getcomposer.org/installer -o composer-setup.php
```
```
HASH=`curl -sS https://composer.github.io/installer.sig`
```
```
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
```
```
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```
- For installation verification run:
```
composer
```
- Cron Setup
```
 crontab -e
```
- Add these line in crontab and change path according to your project setup
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
### Php.ini file changes
- Enable ldap extension in php.ini
- Enable php_bolt extension in php.ini
### Setup
```
git clone https://github.com/simreka/console-dev.git
```
- go to directory
```
cd console-dev
```
- create new .env file and copy data from .env.example and paste in new .env file
```
cp .env.example .env
```
- change .env file according to database configuration

- set redis credential in .env file

- set email credential in .env file

```
php artisan key:generate
```
- Permission to directories
```
chgrp -R www-data /var/www/project_dir_name
chown -R www-data:www-data /var/www/project_dir_name
chmod -R 775 /var/www/project_dir_name/storage
chown -R www-data.www-data /var/www/project_dir_name/storage
```
```
composer install && composer dump-autoload
```
```
php artisan migrate:fresh
```
```
php artisan db:seed
```
```
php artisan serve

```
```
http://localhost:8000/
```
- Enable Maintenance Mode



```

php artisan down

```



- Disable Maintenance Mode



```

php artisan up

```

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
