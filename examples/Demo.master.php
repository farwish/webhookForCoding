<?php

include('../src/autoload.php');
(new \WebHook\PullMaster('/www/web', 8090, 'log.txt'));
