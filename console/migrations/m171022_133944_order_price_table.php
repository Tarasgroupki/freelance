<?php

use yii\db\Schema;
use yii\db\Migration;

class m171022_133944_order_price_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            '{{%order_price}}',
            array(
                'price_id' => $this->primaryKey(),
				'message_id' => Schema::TYPE_INTEGER,
				'price' => Schema::TYPE_STRING
            )
        );
    }

    public function safeDown()
    {
        $this->dropTable('order_price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171022_133944_order_price_table cannot be reverted.\n";

        return false;
    }
    */
}
