<?php

use yii\db\Migration;

/**
 * Class m190301_143211_fixed_category
 */
class m190301_143211_fixed_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%article_category}}', ['title' => 'Media About us', 'slug' => 'about-us'], ['id' => 1]);

        $this->insert('{{%article_category}}', [
            'slug' => 'news',
            'title' => 'News',
            'status' => \common\models\ArticleCategory::STATUS_ACTIVE,
            'created_at' => time()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190301_143211_fixed_category cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190301_143211_fixed_category cannot be reverted.\n";

        return false;
    }
    */
}
