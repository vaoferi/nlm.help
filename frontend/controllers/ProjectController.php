<?php

namespace frontend\controllers;

use common\commands\PaymentCommand;
use common\models\OrderProject;
use common\models\Project;
use common\models\ProjectAttachment;
use common\models\Partner;
use common\models\ProjectOrder;
use common\models\query\ProjectQuery;
use frontend\models\ProjectDonateForm;
use trntv\filekit\actions\ViewAction;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use rexit\liqpay\PaymentModel;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ProjectController extends Controller
{
    /**
     * @param int $partner
     * @return string
     */
    public function actionIndex($partner = 0)
    {
        $idx = ProjectOrder::getOrder();
        $projectsQuery = Project::find()
            ->active()
            ->withoutEmptyLang('title')
            ->specOrder($idx);

        //projects for slider without filter.
//        $sliderProjects = $projectsQuery->limit(3)->all();

        //filter projects by get requests
        $this->filterProjects($projectsQuery);
        $pagination = new Pagination([
            'totalCount' => $projectsQuery->count(),
        ]);
        $projects = $projectsQuery
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        return $this->render('index', [
            'projects' => $projects,
            'pagination' => $pagination,
//            'sliderProjects' => $sliderProjects,
        ]);
    }

    /**
     * @param ProjectQuery $query
     */
    protected function filterProjects(ProjectQuery $query)
    {
        $status = Yii::$app->getRequest()->get('status', 0);
        $partner = Yii::$app->getRequest()->get('partner');
        if ($status !== null && $status !== '') {
            $query->andWhere(['is_finished' => (bool)$status]);
        }
        if ($partner) {
            $query->byPartner((int)$partner);
        }
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        /** @var Project $model */
        $model = Project::find()
            ->withoutEmptyLang('title')
            ->active()->andWhere(['slug' => $slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }
        $articles = $model->getArticles()->limit(3)->all();
        $partners = $model->getPartners()->withoutEmptyLang('name')->all();
        $lastPayments = OrderProject::find()
            ->where(['status' => OrderProject::STATUS_PAID])
            ->orderBy(['updated_at' => SORT_DESC])
            ->andWhere(['project_id' => $model->id])
            ->limit(15)
            ->all();
        return $this->render('view', [
            'model' => $model,
            'articles' => $articles,
            'partners' => $partners,
            'lastPayments' => $lastPayments
        ]);
    }

    public function actionDonate($id)
    {
        $project = Project::find()
            ->withoutEmptyLang('title')
            ->active()->andWhere(['{{%project}}.id' => $id])->one();
        if ($project === null) {
            throw new NotFoundHttpException;
        }
        /*
        $model = new ProjectDonateForm();
        $model->payment_system = 'liqpay';
        $model->setProjectId($id);
        $order = $model->createOrder();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            if ($order = $model->createOrder()) {
                $sign = Yii::$app->security->hashData(json_encode(['order_id' => $order->id, 'type' => 'project']), Yii::$app->params['signKey']);
                return $this->redirect(['payment/' . $model->payment_system, 'sign' => $sign]);
            }
        }
        */

        $liqpay = new PaymentModel([
            'public_key' => 'i69391837367',
            'private_key' => '3GW5TmJjT95bB387Xx9ZweWTaV67f8jFHYi17i18',
            'language' => (Yii::$app->language ==='ru')?'ru':'en',
            'order_id' => implode("_", [
                'project',
                $id,
                time()
            ]),
            'amount' => 30,
            'currency' => (Yii::$app->language ==='ru')?PaymentModel::CURRENCY_UAH:PaymentModel::CURRENCY_USD,
            'description' => Yii::t('frontend', 'Donate for: {name} #{number}', [
                'name' => $project->title,
                'number' => implode("_", [
                    'project',
                    $id
                ]),
            ]),
            'action' => PaymentModel::ACTION_PAY_DONATE,
            'sandbox' => YII_ENV_DEV ? '1' : '0',
            'server_url' => Url::to(['/payment/liqpay-ipn'], 'https')
        ]);

        return $this->render('../site/donate_new', compact( 'liqpay'));
    }

    /**
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ProjectAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }
        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name,
            [
                'inline' => true,
                'mimeType' => Yii::$app->fileStorage->getFilesystem()->getMimetype($model->path),
            ]
        );
    }
}
