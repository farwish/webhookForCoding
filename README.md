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

### FAQ  

* 这个项目我已经放在服务器上了，但是没有 pull 文件呀，也没有 log.txt 怎么办？  

1. 确定文件名和你项目的目录名的大小写是否一致，如 Demo/ 和 demo.develop.php 不是正确的一对。  
2. 确定你 Webhook 中的地址能正确访问到文件，如 Demo.develop.php 顶部输出一行文字看能否输出。  
3. 以上都没问题，确定 log.txt 所在目录是否对 ‘执行脚本的用户’ 可写，可用 file_put_contents 测试。  
4. 另外提示，token不正确 或者 不是合并/push到develop的操作，是不记录日志的 (为了避免日志内容太多)。  
5. 实在不行那就去看源文件，在里面做调试吧，内容不多。  
