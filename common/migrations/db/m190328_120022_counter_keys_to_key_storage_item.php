<?php

use yii\db\Migration;

/**
 * Class m190328_120022_counter_keys_to_key_storage_item
 */
class m190328_120022_counter_keys_to_key_storage_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.counter-medicine',
            'value' => 79459
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.counter-food',
            'value' => 694074
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.counter-law',
            'value' => 4452
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.counter-clothes',
            'value' => 15152
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', ['key' => 'frontend.counter-medicine']);
        $this->delete('{{%key_storage_item}}', ['key' => 'frontend.counter-food']);
        $this->delete('{{%key_storage_item}}', ['key' => 'frontend.counter-law']);
        $this->delete('{{%key_storage_item}}', ['key' => 'frontend.counter-clothes']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190328_120022_counter_keys_to_key_storage_item cannot be reverted.\n";

        return false;
    }
    */
}
