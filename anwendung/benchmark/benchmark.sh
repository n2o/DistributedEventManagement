#!/bin/bash
echo "#############################"
echo "#                           #"
echo "# Benchmarking Meissner App #"
echo "#                           #"
echo "#############################"

echo "Test #1"
purge

sleep 5

echo "\n#1: static page" >> filter.txt
ab -c 20 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: static page" >> filter.txt
ab -c 20 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: static page" >> filter.txt
ab -c 20 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: static page" >> filter.txt
ab -c 20 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: static page" >> filter.txt
ab -c 20 -n 1000 http://localhost/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #2"
purge

sleep 5

echo "\n#1: event of meissner app, 0 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: event of meissner app, 0 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: event of meissner app, 0 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: event of meissner app, 0 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: event of meissner app, 0 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/52/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #3"
purge

sleep 5

echo "\n#1: event of meissner app, 10 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: event of meissner app, 10 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: event of meissner app, 10 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: event of meissner app, 10 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: event of meissner app, 10 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/50/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #4"
purge

sleep 5

echo "\n#1: event of meissner app, 100 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: event of meissner app, 100 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: event of meissner app, 100 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: event of meissner app, 100 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: event of meissner app, 100 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/51/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

####################
echo "Test #5"
purge

sleep 5

echo "\n#1: event of meissner app, 200 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/53/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#2: event of meissner app, 200 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/53/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#3: event of meissner app, 200 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/53/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#4: event of meissner app, 200 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/53/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt

sleep 5

echo "\n#5: event of meissner app, 200 properties" >> filter.txt
ab -c 20 -n 1000 http://localhost/anwendung/meissner/events/edit/53/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt