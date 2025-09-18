<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\dto;


use common\models\HelpCenter;
use common\models\HelpCenterService;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class HelpCenterDTO
{
    private $model;

    public $id;

    public $city;

    public $city_key;

    public $name;

    public $description;

    public $thumbnail;

    public $projects = [];

    public $news = [];

    public $services = [];

    public $servicesName = [];

    public $contacts;

    public function __construct(HelpCenter $model)
    {
        $this->model = $model;
        $this->initFields();
    }


    protected function initFields()
    {
        $this->id = $this->getModel()->id;
        $this->city = ArrayHelper::getValue(HelpCenter::getPlaceNames(), $this->getModel()->place_name);
        $this->city_key = $this->getModel()->place_name;
        $this->name = $this->getModel()->name;
        $this->description = $this->getModel()->description;
        $this->contacts = implode("</br>", ArrayHelper::getColumn(explode(PHP_EOL, $this->getModel()->contacts), function($phone) {
            return Html::a($phone, 'tel:'.$phone);
        }));
        $this->thumbnail = $this->getModel()->thumbnail_path ?
            \Yii::$app->glide->createSignedUrl(['glide/index', 'path' => $this->getModel()->thumbnail_path], true) :
            '';
        foreach ($this->getModel()->projects as $project) {
            $this->projects[] = [
                'url' => Url::to(['/project/view', 'slug' => $project->slug]),
                'title' => $project->title
            ];
        }
        foreach ($this->getModel()->articles as $article) {
            $this->news[] = [
                'url' => Url::to(['/article/view', 'slug' => $article->slug]),
                'title' => $article->title
            ];
        }
        foreach ($this->getModel()->helpCenterServices as $service) {
            $this->services[] = $service->service_name;
            $this->servicesName[] = ArrayHelper::getValue(HelpCenterService::getServices(), $service->service_name);
        }
    }

    /**
     * @return HelpCenter
     */
    public function getModel()
    {
        return $this->model;
    }
}