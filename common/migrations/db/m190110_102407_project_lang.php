<?php

use yii\db\Migration;

/**
 * Class m190110_102407_project_lang
 */
class m190110_102407_project_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%project}}', 'title');
        $this->dropColumn('{{%project}}', 'description');
        $this->createTable('{{%project_lang}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'language' => $this->string(6),
            'title' => $this->string(512),
            'description' => $this->text(),
        ]);

        $this->addForeignKey('fk_project_lang', '{{%project_lang}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%project}}', 'title', $this->string(512));
        $this->addColumn('{{%project}}', 'description', $this->text());
        $this->dropForeignKey('fk_project_lang', '{{%project_lang}}');
        $this->dropTable('{{%project_lang}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190110_102407_project_lang cannot be reverted.\n";

        return false;
    }
    */
}
