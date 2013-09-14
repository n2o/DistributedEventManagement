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

apt-get install apache2 php5 libapache2-mod-php5 mysql-server mysql-client php-pear php5-suhosin php5-mysql phpmyadmin javascript-common openssl
a2enmod rewrite

# echo " "
# echo "# Done."
# echo " "
# echo "# Installing node.js for WebSocket Server..."
# echo " "

# apt-get install python g++ make checkinstall
# mkdir ~/src && cd $_
# wget -N http://nodejs.org/dist/node-latest.tar.gz
# tar xzvf node-latest.tar.gz && cd node-v*
# ./configure
# checkinstall #(remove the "v" in front of the version number in the dialog)
# sudo dpkg -i node_*

echo " "
echo "# Done."
echo " "
echo "# Enabling openSSL to create private / public key pair"
echo " "

sed -i 's/;(extension=openssl.so)/\1/' /etc/php.ini
sed -i 's/;(extension=openssl.so)/\1/' /etc/php5/apache2/php.ini

echo " "
echo "# Done."
echo " "
echo "# Now moving the Meissner webpage to /var/www and changing user privilegs for www-data..."

rm -rf /var/www/meissner
mv meissner/ /var/www
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
echo "# Completed!"
echo " "
echo "# Now you just need to open 'localhost/meissner/setup' in your webbrowser."
echo " "