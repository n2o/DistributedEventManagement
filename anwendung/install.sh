#!/bin/bash
# Installation Script for the Meissner Webapplication
# developed within the bachelor thesis of
# Christian Meter, September 2013


clear
echo "########################################################"
echo "#                                                      #"
echo "# Installation of LAMP for the Meissner Webapplication #"
echo "#                                                      #"
echo "########################################################"
echo " "
echo "# Checking for latest version of your distribution..."
echo " "

aptitude update && aptitude upgrade

echo " "
echo "# Done."
echo " "
echo "# Now downloading and installing Apache2, PHP5, MySQL, phpmyadmin, openssl and current version of JavaScript..."
echo " "

apt-get install apache2 mysql-server mysql-client php5 libapache2-mod-php5 php-pear php5-mysql php5-curl php5-common php5-cli php5-gd phpmyadmin javascript-common make python gcc g++

echo " "
echo "# Done."
echo " "
echo "# Enabling cURL and mod_rewrite..."

# Enabling curl in php.ini
grep -q -e 'extension=curl.so' /etc/php5/apache2/php.ini || sed -i.bak '$ a\\n; Adding module curl for Meissner Webapplication\nextension=curl.so' /etc/php5/apache2/php.ini

# Enabling mod_rewrite in apache2.conf
grep -q -e 'LoadModule rewrite_module modules/apache2/mod_rewrite.so' /etc/apache2/apache2.conf || sed -i.bak '$ a\\n# Enabling mod_rewrite\nLoadModule rewrite_module modules/apache2/mod_rewrite.so' /etc/apache2/apache2.conf

# Enabling FollowSymLinks for meissner app
grep -q -e '<Directory "/var/www/meissner2">' /etc/apache2/apache2.conf || sed -i.bak '$ a\\n# Allowing SymLinks for Meissner Webapplication\n<Directory "/var/www/meissner">\n\tOptions FollowSymLinks\n\tAllowOverride All\n</Directory>' /etc/apache2/apache2.conf

a2enmod rewrite

echo " "
echo "# Done."
echo " "
echo "# Now moving the Meissner webpage to /var/www and changing user privilegs for www-data..."

mv meissner/ /var/www/
chown -R www-data:www-data /var/www/meissner
chmod -R 755 /var/www/meissner
chmod -R 777 /var/www/meissner/app/tmp

echo " "
echo "# Done."
echo " "
echo "# Restarting apache..."
echo " "

/etc/init.d/apache2 stop
/etc/init.d/apache2 start

echo " "
echo "# Done."
echo " "
echo "# Finally installing node.js as WebSocket Server..."
echo " "

cd /tmp/
wget http://nodejs.org/dist/node-latest.tar.gz
tar -xzvf node-latest.tar.gz
rm node-latest.tar.gz*
cd node-*
./configure
make
make install

echo " "
echo "# Completed!"
echo " "
echo "# To setup the MySQL connection, just type localhost/meissner/setup in your webbrowser."
echo " "
echo "# At last starting WebSocket Server in /var/www/meissner/app/webroot/websocket/socket-server.js..."
echo " "

node /var/www/meissner/app/webroot/websocket/socket-server.js