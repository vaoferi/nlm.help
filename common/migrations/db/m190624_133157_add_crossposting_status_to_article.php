<?php

use common\models\Article;
use yii\db\Migration;

/**
 * Class m190624_133157_add_crossposting_status_to_article
 */
class m190624_133157_add_crossposting_status_to_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%article}}', 'crossposting_status', $this->smallInteger()->notNull()->defaultValue(0));
        $articles = Article::find()->orderBy(['id' => SORT_ASC])->all();
        $numberOfArticles = count($articles);
        if ($numberOfArticles > 2) {
            $newNumber = $numberOfArticles - 2;
            for ($i = 0; $i < $newNumber; $i++) {
                $article = $articles[$i];
                $article->crossposting_status = 1;
                $article->update(false);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%article}}', 'crossposting_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190624_133157_add_crossposting_status_to_article cannot be reverted.\n";

        return false;
    }
    */
}
