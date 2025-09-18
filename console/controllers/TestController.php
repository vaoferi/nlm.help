<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace console\controllers;


use yii\console\Controller;
use yii\mutex\FileMutex;
use yii\mutex\MysqlMutex;

class TestController extends Controller
{
    public function actionIndex()
    {
        $mutex = new FileMutex();
        $start = time();
        if ($mutex->acquire('test', 30)) {
            sleep(3);
            $this->stdout(time() - $start);
        } else {
            $this->stdout("locked");
        }
    }
}