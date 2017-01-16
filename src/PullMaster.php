<?php

namespace WebHook;

use WebHook\PullInterface;

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

class PullMaster implements PullInterface
{
    /**
     * 项目所在上级目录.
     */
    protected $basedir;

    /**
     * WebHook中填的token.
     */
    protected $token;

    /**
     * 执行结果所记录的日志文件.
     *
     * 默认为本文件所在目录的 log.txt
     */
    protected $logfile;
    
    /**
     * Construct.
     *
     * @param string $basedir 必须, 项目所在上级目录,不含项目目录名.
     * @param mixed  $token.  必须, WebHook的安全码.
     * @param string $logfile 可选, 日志文件,默认本文件目录内log.txt
     */
    public function __construct($basedir, $token, $logfile = 'log.txt')
    {
        $this->basedir  = rtrim($basedir, '/') . '/';
        $this->token    = $token;
        $this->logfile  = $logfile;

        self::doit();
    }

    /**
     * Execute.
     *
     * @farwish
     */
    public function doit()
    {
        //$curfile = basename(__FILE__);
        $array_and = debug_backtrace();
        $curfile = basename(array_pop( $array_and )['file']);
        $project = substr( $curfile, 0, strpos($curfile, '.') );

        $absolute = $this->basedir . $project;

        $command = "cd {$absolute} && git pull";

        $hook_json = file_get_contents('php://input');

        $hook_array = json_decode($hook_json, TRUE);

        // 合并master时, Log & Pull.

        if (
            // token 校验
            $hook_array['token'] == $this->token

            &&

            // 仅在合并到master时
            isset($hook_array['merge_request'])
            && ($hook_array['merge_request']['target_branch'] == 'master')

            // 仅在合并成功时触发
            //&& ($hook_array['merge_request']['status'] = 'ACCEPTED')
        ) {

            date_default_timezone_set('PRC');

            $date = '[ ' . date('Y-m-d H:i:s') . ' ] ';

            $core = 'Repo: ' . 
                $hook_array['repository']['name'] .
                ', Merge Request:(' . 
                $hook_array['merge_request']['source_branch'] . 
                ' -> ' . 
                $hook_array['merge_request']['target_branch'] . 
                '), Status: ' .
                $hook_array['merge_request']['status'];

            $msg = $date . $core . PHP_EOL;

            // echo shell_exec("whoami"); 浏览器中查看运行脚本的用户.
            file_put_contents($this->logfile, $msg, FILE_APPEND);

            // (exec > passthru > shell_exec)
            $return_var = 0;
            $ret = passthru($command, $return_var);

            if ( $return_var === 0 ) {
                $msg = $date . 'command run SUCCESS.' . PHP_EOL;
            } else {
                $msg = $date . 'command run FAILURE!!! ' . $command . PHP_EOL;
            }

            file_put_contents($this->logfile, $msg, FILE_APPEND);
        }
    }
}

