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

//show the configuration of the container
docker inspect container-name

//install php extension 'mycrypt' in apache
sudo apt-get install mycrypt php5-mcrypt
sudo php5enmod mcrypt

sudo apt-get install php5-mysql

//change dns ubuntu
/etc/resolv.conf

//phpmyadmin config file
/home/neal/repo/phpMyAdmin/libraries/config.default.php


sudo mount 192.168.2.122:/var/nfs /home/neal/Desktop/share/

//faster visit wordpress help documents website
127.0.0.1   itmwpb.com
127.0.0.1   0.gravatar.com gravatar.com www.gravatar.com 1.gravatar.com
127.0.0.1   fonts.googleapis.com
127.0.0.1   kwxx.com www.kwxx.com
127.0.0.1   demo.itmwpb.com
127.0.0.1   maps.googleapis.com
127.0.0.1   static.adzerk.net
127.0.0.1   ajax.googleapis.com
127.0.0.1   radio1.itmwpb.com
127.0.0.1   apis.google.com
93.184.216.127 s.w.org
93.184.216.127 ps.w.org
192.0.78.13 www.wordpress.com wordpress.com
127.0.0.1   platform.twitter.com twitter.com
127.0.0.1   www.facebook.com facebook.com
127.0.0.1   google.com www.google.com
127.0.0.1   madtownjamz.com www.madtownjamz.com
127.0.0.1   grpgn.itmwpb.com
127.0.0.1   centralmoinfo.com www.centralmoinfo.com
127.0.0.1   951wayv.com www.951wayv.com
127.0.0.1   s0.wp.com
127.0.0.1   static.ak.facebook.com


useful wordpress plugins
query-monitor    speed up the webside backend

useful study website
http://www.css88.com/


docker run -d --name etongapp -p 80:80 -v /home/neal/repo/stacktechmu:/var/www/html -v /home/neal/repo/log:/var/log/apache2 tutum/apache-php