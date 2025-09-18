<?php
/**
 * Created by PhpStorm.
 * User: rexit
 * Date: 10.05.19
 * Time: 14:58
 */

namespace console\controllers;

;
use common\components\social\Message;
use common\models\Article;
use common\models\ArticleCron;
use common\models\CronLogDetail;
use common\models\CronLogDetailError;
use Yii;
use yii\console\Controller;
use yii\db\ActiveQuery;

class CronController extends Controller
{
    private $log = null;
    public static $log_id = 0;

    public function afterAction($action, $result)
    {
        $this->logExecution();
        return parent::afterAction($action, $result);
    }

    public function beforeAction($action)
    {
        $this->logCreating($action->id);
        return parent::beforeAction($action);
    }

    /**
     * Cron Method to parse data from the lun site
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionPublishArticles()
    {
        Yii::$app-> urlManagerStorage->setBaseUrl(env('STORAGE_HOST_INFO'));
        $dateTime = new \DateTime();
        $currentDate = $dateTime->format('Y-m-d');
        //статьи за последние сутки, которые были опубликованы на сайте, но не было опубликованы в соц сетях
        $dayArticles = Article::find()
            ->published()
            ->joinWith(['translations' => function ($query) {
                /* @var $query ActiveQuery */
                $query->where(['language' => 'ru']);
                $query->andWhere([
                    'and',
                    ['IS NOT', 'title', null],
                    ['!=', 'title', ''],
                ]);
            }])
            ->andWhere(['crossposting_status' => 0])
            ->all();

        if (!empty($dayArticles)) {
            foreach (ArticleCron::clients() as $client => $clientName) {
                $isAllSaved = true;
                $networkClient = Yii::$app->posting->getClient($client);
                $articleCron = new ArticleCron();
                $articleCron->date = $currentDate;
                $articleCron->client = $client;
                $articleCron->status = ArticleCron::STATUS_NOT_POSTED;
                $articleCron->validate();
                if ($articleCron->save()) {
                    foreach ($dayArticles as $dayArticle) {
                        Yii::$app->urlManagerFrontend->setBaseUrl(Yii::getAlias('@frontendUrl'));
                        $articleLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['article/view', 'slug' => $dayArticle->slug]);
                        $thumbnailPath = Yii::getAlias('@storage/web/source') . $dayArticle->thumbnail_path;
                        if ($client === ArticleCron::CLIENT_OK) {
                            $thumbnailPath = Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $dayArticle->thumbnail_path], true);
                        }
                        $message = new Message($dayArticle->title, $thumbnailPath, $articleLink);
                        $postResult = $networkClient->send($message);
                        if ($postResult === true) {
                            $dayArticle->crossposting_status = 1;
                            $dayArticle->save(false);
                        } else {
                            $error = "Article with id: {$dayArticle->id} wasn't posted to {$client}. Reason: {$postResult}";
                            CronLogDetailError::createErrorLogFromCron($error, CronLogDetailError::STATUS_SIMPLE_ERROR);
                            $isAllSaved = false;
                        }
                    }
                }
                if ($isAllSaved) {
                    $articleCron->status = ArticleCron::STATUS_POSTED;
                    $articleCron->update();
                }
            }
        }
    }

    private function logCreating($command)
    {
        $this->log = new CronLogDetail();
        $this->log->command_name = $command;
        $this->log->time_start = time();
        $this->log->status = CronLogDetail::STATUS_FAIL;
        if ($this->log->save()) {
            self::$log_id = $this->log->id;
        }
    }

    private function logExecution()
    {
        if ($this->log !== null) {
            /** @var CronLogDetail $this->log */
            $this->log->time_end = time();
            $this->log->status = CronLogDetail::STATUS_SUCCESS;
            $this->log->save();
        }
    }

    private function addLogDescription($text)
    {
        if ($this->log !== null) {
            /** @var CronLogDetail $this ->log */
            $this->log->description = $text;
            $this->log->save();
        }
    }
}