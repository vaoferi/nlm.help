<?php

use yii\db\Migration;

/**
 * Class m190315_133859_category_descs
 */
class m190315_133859_category_descs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%article_category_lang}}', [
            'id' => $this->primaryKey(),
            'article_category_id' => $this->integer(),
            'language' => $this->string(64),
            'title' => $this->string(512),
            'description' => $this->text()
        ]);

        $this->addForeignKey('fk_article_cat_lang', '{{%article_category_lang}}', 'article_category_id', '{{%article_category}}', 'id', 'cascade', 'cascade');
        $query = new \yii\db\Query();
        $command = $query->select(['id', 'title'])
            ->from('{{%article_category}}')
            ->createCommand();
        $result = $command->queryAll();
        $insert = [];
        foreach ($result as $category) {
            foreach (Yii::$app->params['availableLocales'] as $code => $lang) {
                $insert[] = [
                    'title' => $category['title'],
                    'article_category_id' => $category['id'],
                    'language' => $code
                ];
            }
        }
        Yii::$app->getDb()->createCommand()->batchInsert('{{%article_category_lang}}', ['title', 'article_category_id', 'language'], $insert)->execute();
        $this->dropColumn('{{%article_category}}', 'title');
        $this->dropColumn('{{%article_category}}', 'body');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%article_category}}', 'title', $this->string(255));
        $this->addColumn('{{%article_category}}', 'body', $this->text());
        $this->dropForeignKey('fk_article_cat_lang', '{{%article_category_lang}}');
        $this->dropTable('{{%article_category_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190315_133859_category_descs cannot be reverted.\n";

        return false;
    }
    */
}
