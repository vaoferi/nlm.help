<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Article;
use common\models\ArticleCategory;
use omgdef\multilingual\MultilingualTrait;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    use MultilingualTrait;

    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['article.status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
        return $this;
    }

    /**
     * @return ArticleQuery
     */
    public function aboutUs()
    {
        return $this->andWhere([
            'about_us' => true
        ]);
    }

    /**
     * @param int $partner_id
     * @return $this
     */
    public function byPartner(int $partner_id)
    {
        $this->joinWith(['articlePartners' => function (ActiveQuery $query) use ($partner_id) {
            return $query->andOnCondition(['partner_id' => $partner_id]);
        }]);
        $this->andWhere(['IS NOT', '{{%article_partner}}.id', null]);
        return $this;
    }

    /**
     * @param int $project_id
     * @return $this
     */
    public function byProject(int $project_id)
    {
        $this->joinWith(['projectArticles' => function (ActiveQuery $query) use ($project_id) {
            return $query->andOnCondition(['project_id' => $project_id]);
        }]);
        $this->andWhere(['IS NOT', '{{%project_article}}.id', null]);
        return $this;
    }

    /**
     * @param int $help_center_id
     * @return $this
     */
    public function byHelpCenter(int $help_center_id)
    {
        $this->joinWith(['helpCenterArticles' => function (ActiveQuery $query) use ($help_center_id) {
            return $query->andOnCondition(['help_center_id' => $help_center_id]);
        }]);
        $this->andWhere(['IS NOT', '{{%help_center_article}}.id', null]);
        return $this;
    }
}
