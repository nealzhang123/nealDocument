**intertech mandrill config,an email api code
New Mandrill accountID : mail@intertechmedia.com 
PW : Mandri11#11

Mandrill api
Created api key : wCDZSKndpEeLDcLs388l5w
Test key : asJwVhABNAyKyIts4JO4yg

https://mandrillapp.com/api/docs/messages.php.html (send email)
https://mandrillapp.com/api/docs/webhooks.php.html (handle bounce)
http://mandrillapp.com

used xml have content:
http://abcnewsradioonline.com/world-news/rss.xml
http://abcnewsradioonline.com/sports-news/rss.xml
http://abcnewsradioonline.com/business-news/rss.xml



**docker configation for the image 'stacktech/lamp' tech created on docker.com
docker run -d --name techserver -p 80:80 -p 3306:3306 -e MYSQL_PASS="abc123" -v /home/neal/repo/wpbitm:/var/www/html -v /home/neal/db:/var/lib/mysql -v /home/neal/repo/log:/var/log/apache2 stacktech/lamp

docker run -d --name allserver -p 80:80 -p 3306:3306 -e MYSQL_PASS="abc123" -v /home/neal/repo:/var/www/html -v /home/neal/db:/var/lib/mysql -v /home/neal/repo/log:/var/log/apache2 stacktech/lamp

//a image include the tool nsenter,is use to connect to the container docker created
docker run -v /usr/local/bin:/target jpetazzo/nsenter 
docker inspect --format "{{ .State.Pid }}" allserver
nsenter --target 5855 --mount --uts --ipc --net --pid

//go inside the contain as a simple method
docker exec -it allserver /bin/bash

//install php extension 'mycrypt' in apache
sudo apt-get install mycrypt php5-mcrypt
sudo php5enmod mcrypt

sudo apt-get install php5-mysql

//change dns ubuntu
/etc/resolv.conf


