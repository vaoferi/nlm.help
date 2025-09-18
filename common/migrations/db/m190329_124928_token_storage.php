<?php

use yii\db\Migration;

/**
 * Class m190329_124928_token_storage
 */
class m190329_124928_token_storage extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token_storage}}', [
            'id' => $this->primaryKey(),
            'client' => $this->string(255),
            'token' => $this->text(),
            'expire_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token_storage}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190329_124928_token_storage cannot be reverted.\n";

        return false;
    }
    */
}
