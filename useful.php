<!-- load the youdao traslate plugins into the page-->
<div id="YOUDAO_SELECTOR_WRAPPER" style="display:none; margin:0; border:0; padding:0; width:320px; height:240px;"></div>
<script type="text/javascript" src="http://fanyi.youdao.com/openapi.do?keyfrom=tuicool&key=974115503&type=selector&version=1.2&translate=on" charset="utf-8"></script>
<?php
*******************************************************************************
//WordPress 解决方案
//这个函数可用来判断是否在多站点管理目录下
is_network_admin

//激活与取消激活插件的时候可以使用的钩子
register_activation_hook( __FILE__, array( 'Akismet', 'plugin_activation' ) );
register_deactivation_hook

//插入数据库之前的数据处理函数
esc_sql

//插入数据库前,设置时区与设定的网站时区一致
$tz = get_option('timezone_string');
if ($tz && function_exists('date_default_timezone_set')) {
    date_default_timezone_set($tz);
}

//将$value值为'3/1/2015'或者'03-01-2015'等的,统一整合成一个格式,PRC为中国时间,UTC是格林时间
$string_gmt = date_create( $value, new DateTimeZone( $tz ) );
$string_gmt->setTimezone( new DateTimeZone( 'PRC' ) );
$date = $string_gmt->format( 'Y-m-d' );

//判断插件是否处于激活状态
is_plugin_active('ninja-forms/ninja-forms.php')

//自动加载类 如果在某个类TempClass里面调用,TempClass::autoloadClass
if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
    spl_autoload_register( 'autoloadClass', true, true);
} else {
    spl_autoload_register( 'autoloadClass' );
}
function autoloadClass($classname){
    $filename = plugin_dir_path( __FILE__ ).'class/class_'.strtolower($classname).'.php';
    if (is_readable($filename)) {
        require_once $filename;
    }
}

//Useful for creating new tables and updating existing tables to a new structure.
dbDelta
*******************************************************************************



*******************************************************************************
//Linux相关实用命令
//report file system disk space usage
df
//显示当前内存使用情况
free

//scp是有Security的文件copy，基于ssh登录。操作起来比较方便，比如要把当前一个文件copy到远程另外一台主机上，可以如下命令。
scp /home/daisy/full.tar.gz root@172.19.2.75:/home/root
//然后会提示你输入另外那台172.19.2.75主机的root用户的登录密码，接着就开始copy了。

//如果想反过来操作，把文件从远程主机copy到当前系统，也很简单。
scp root@/full.tar.gz 172.19.2.75:/home/root/full.tar.gz home/daisy/full.tar.gz

//因为ubuntu默认的sh是连接到dash的,又因为dash跟bash的不兼容所以出错了.执行时可以把sh换成bash 文件名.sh来执行，成功。dash也是一种shell,貌似用户对它的诟病颇多.
sudo dpkg-reconfigure dash
//选择no即可取消默认连接到bash。

//查看端口占用的进程,切换到root能看到更详细一些
netstat -tlnp|grep port端口号
*******************************************************************************



*******************************************************************************
//css学习报告,真是菜鸟啊
//处理div浮动的位置
http://www.jb51.net/css/21615.html
*******************************************************************************

*******************************************************************************
//ngnix学习心得,从零开始学
nginx的error_log类型如下（从左到右：debug最详细 crit最少）： 
[ debug | info | notice | warn | error | crit ] 
例如：error_log logs/nginx_error.log  crit; 
解释：日志文件存储在nginx安装目录下的 logs/nginx_error.log ，错误类型为 crit ，也就是记录最少错误信息；
ps:
阿里云在搭建ngnix的时候查看/alidata/server/nginx/conf/nginx.conf的时候,
想看看配置错误日志位置的时候,看到的这么一行,最后的crit不理解就查了一下.
error_log  /alidata/log/nginx/error.log crit;

所有nginx配置发生改变时，最好都使用如下命令测试配置是否错误后再使用 -s reload 重载 
/alidata/server/nginx/sbin/nginx -t
输入后如果提示如下，则表示配置无误
nginx: the configuration file /alidata/server/nginx/conf/nginx.conf syntax is ok
nginx: configuration file /alidata/server/nginx/conf/nginx.conf test is successful
*******************************************************************************

*******************************************************************************
//mysql 学习过程中一些实用的例子
//查询重复字段时候只取得一行数据
SELECT *, count(distinct meta_value) FROM $postmeta_table WHERE meta_key = 'hospital_table_no' group by meta_value