echo "Test #6: 10 Properties"
purge

sleep 5

echo "\n#1: naked meissner app" >> filter.txt
ab -k -c 10 -n 1000 http://localhost/anwendung/meissner/ > output.txt
sed -e '/Time taken/,/Requests per second/!d' output.txt >> filter.txt