<?php
/**
 * Created by Rex IT
 * @author Konstantin Kharalampidi <kharalampidi@rexit.info>
 */

namespace common\widgets;


use yii\helpers\Html;
use yii\widgets\LinkPager;

class PaginationSectionWidget extends LinkPager
{
    public $disabledListItemSubTagOptions = [
        'tag' => 'a'
    ];

    public $options = [
        'class' => 'pagination__list'
    ];

    public $activePageCssClass = 'current';

    public $sectionClass = 'pagination';

    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo Html::tag('section', $this->renderPageButtons(), ['class' => $this->sectionClass]);
    }
}