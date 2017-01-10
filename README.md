# webhookForCoding

### 简介

本项目用于 coding.net 的 WebHook, 自动让服务器拉取最新代码.  

### 注释预览(局部)  

````php
/**
 * Master Project Webhook.(for coding.net)
 *
 * 约定:
 *
 *  如果项目目录是 /home/wwwroot/Discuz 
 *  那么你应该建一个 Discuz.master.php , 这里约定这个文件名前缀就是项目目录名.
 *      ( 主要为了一目了然, 定义好一个项目的WebHook文件后, 其余项目与之区别仅在于文件名. )
 *      ( 后缀并不要求, 这里是为了与 Discuz.develop.php 区分. )
 *  编辑 Discuz.master.php 加入如下code部分.
 *
 * <code>
 *  include('./src/autoload.php');
 *  (new \WebHook\PullMaster('/home/wwwroot', 9981, 'log.txt')); // 对应类中三个属性.
 *  // Ok, 在网页端指定 Discuz.master.php 即可.
 * </code>
 *
 * @farwish
 */
````

### 实际用法  

`Discuz.master.php`  

````php

include('./webhookForCoding/src/autoload.php');

( new \WebHook\PullMaster('/www/web', 8090) );

````

`Discuz.develop.php`  

````php

include('./webhookForCoding/src/autoload.php');

( new \WebHook\PullDevelop('/www/web', 8090) );

````

### 最后设置

在coding项目 '设置' 里的 'WebHook' 项中指定地址和token.  

举例:  

alconSeek 项目的 master 分支就设置为 your_ip/alconSeek.master.php  

alconSeek 项目的 develop 分支就设置为 your_ip/alconSeek.develop.php  

discuz 项目的 master 分支就设置为 your_ip/discuz.master.php  

discuz 项目的 develop 分支就设置为 your_ip/discuz.develop.php  

...  

