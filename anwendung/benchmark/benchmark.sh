#!/bin/bash
echo "#############################"
echo "#                           #"
echo "# Benchmarking Meissner App #"
echo "#                           #"
echo "#############################"

echo "Test #1: static page"
purge

sleep 5

echo "\n#1: static page" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: static page" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: static page" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: static page" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: static page" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #2: 0 Properties"
purge

sleep 5

echo "\n#1: event of meissner app, 0 properties" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #3: 10 Properties"
purge

sleep 5

echo "\n#1: event of meissner app, 10 properties" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #4: 100 Properties"
purge

sleep 5

echo "\n#1: event of meissner app, 100 properties" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #5: Naked cakePHP"
purge

sleep 5

echo "\n#1: Naked cakePHP" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/anwendung/cakePHP/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt