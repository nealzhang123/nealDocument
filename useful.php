<!-- load the youdao traslate plugins into the page-->
<div id="YOUDAO_SELECTOR_WRAPPER" style="display:none; margin:0; border:0; padding:0; width:320px; height:240px;"></div>
<script type="text/javascript" src="http://fanyi.youdao.com/openapi.do?keyfrom=tuicool&key=974115503&type=selector&version=1.2&translate=on" charset="utf-8"></script>
<?php

//WordPress 解决方案
//这个函数可用来判断是否在多站点管理目录下
is_network_admin




//Linux相关实用命令
//report file system disk space usage
df

//scp是有Security的文件copy，基于ssh登录。操作起来比较方便，比如要把当前一个文件copy到远程另外一台主机上，可以如下命令。
scp /home/daisy/full.tar.gz root@172.19.2.75:/home/root
//然后会提示你输入另外那台172.19.2.75主机的root用户的登录密码，接着就开始copy了。

//如果想反过来操作，把文件从远程主机copy到当前系统，也很简单。
scp root@/full.tar.gz 172.19.2.75:/home/root/full.tar.gz home/daisy/full.tar.gz