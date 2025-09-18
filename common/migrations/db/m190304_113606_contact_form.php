<?php

use yii\db\Migration;

/**
 * Class m190304_113606_contact_form
 */
class m190304_113606_contact_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact_form}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(512),
            'phone' => $this->string(512),
            'email' => $this->string(512),
            'body' => $this->text(),
            'help_center_id' => $this->integer(),
            'is_new' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);


        $this->addForeignKey('fk_help_center_contact', '{{%contact_form}}', 'help_center_id', '{{%help_center}}', 'id', 'SET NULL', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_help_center_contact', '{{%contact_form}}');
        $this->dropTable('{{%contact_form}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190304_113606_contact_form cannot be reverted.\n";

        return false;
    }
    */
}

