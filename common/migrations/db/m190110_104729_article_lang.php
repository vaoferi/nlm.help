<?php

use yii\db\Migration;

/**
 * Class m190110_104729_article_lang
 */
class m190110_104729_article_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%article}}', 'title');
        $this->dropColumn('{{%article}}', 'body');
        $this->createTable('{{%article_lang}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(512),
            'body' => $this->text(),
        ]);

        $this->addForeignKey('fk_article_lang', '{{%article_lang}}', 'article_id', '{{%article}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%article}}', 'title', $this->string(512)->notNull());
        $this->addColumn('{{%article}}', 'body', $this->text()->notNull());
        $this->dropForeignKey('fk_article_lang', '{{%article_lang}}');
        $this->dropTable('{{%article_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_104729_article_lang cannot be reverted.\n";

        return false;
    }
    */
}
