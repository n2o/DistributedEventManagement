#!/bin/bash
# Installation Script for the Meissner Webapplication
# developed within the bachelor thesis of
# Christian Meter, September 2013


set -e

echo "# Checking for latest version of your distribution..."

sudo aptitude update && sudo aptitude dist-upgrade -y

echo "# Now downloading and installing Apache2, PHP5, MySQL, openssl and current version of JavaScript..."

sudo apt-get install -y apache2 mysql-server mysql-client php5 libapache2-mod-php5 php-pear php5-mysql php5-curl php5-common php5-cli php5-gd javascript-common make python gcc g++

echo "# Enabling cURL and mod_rewrite..."

# Enabling curl in php.ini
grep -q -e 'extension=curl.so' /etc/php5/apache2/php.ini || sudo sed -i.bak '$ a\\n; Adding module curl for Meissner Webapplication\nextension=curl.so' /etc/php5/apache2/php.ini

# Enabling mod_rewrite in apache2.conf
grep -q -e 'LoadModule rewrite_module modules/apache2/mod_rewrite.so' /etc/apache2/apache2.conf || sudo sed -i.bak '$ a\\n# Enabling mod_rewrite\nLoadModule rewrite_module modules/apache2/mod_rewrite.so' /etc/apache2/apache2.conf

# Enabling FollowSymLinks for fmeissner app
grep -q -e '<Directory "/var/www/meissner2">' /etc/apache2/apache2.conf || sudo sed -i.bak '$ a\\n# Allowing SymLinks for Meissner Webapplication\n<Directory "/var/www/meissner">\n\tOptions FollowSymLinks\n\tAllowOverride All\n</Directory>' /etc/apache2/apache2.conf

sudo a2enmod rewrite

echo "# Now moving the Meissner webpage to /var/www and changing user privilegs for www-data..."

sudo cp -R meissner/ /var/www/
sudo chown -R www-data:www-data /var/www/meissner
sudo chmod -R 755 /var/www/meissner
sudo mkdir -p /var/www/meissner/app/tmp
sudo chmod -R 777 /var/www/meissner/app/tmp

echo "# Restarting apache..."

sudo /etc/init.d/apache2 stop
sudo /etc/init.d/apache2 start

echo "# Finally installing node.js as WebSocket Server..."

cd /tmp/
wget -c http://nodejs.org/dist/node-latest.tar.gz
tar -xzvf node-latest.tar.gz
rm node-latest.tar.gz*
cd node-*
./configure
make
sudo make install

echo "# At last starting WebSocket Server in /var/www/meissner/app/webroot/websocket/socket-server.js..."

node /var/www/meissner/app/webroot/websocket/socket-server.js &

echo "# To setup the MySQL connection, just type localhost/meissner/setup in your webbrowser."

xdg-open http://localhost/meissner/setup
