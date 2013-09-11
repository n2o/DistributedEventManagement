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

aptitude update && aptitude upgrade

echo "# Done."

echo " "

echo "# Now downloading and installing Apache2, PHP5, MySQL, phpmyadmin and current version of JavaScript..."

apt-get install apache2 php5 libapache2-mod-php5 mysql-server mysql-client php5-mysql phpmyadmin javascript-common

echo "# Done."