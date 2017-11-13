<?php

use yii\db\Schema;
use yii\db\Migration;

class m170926_161437_order_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable(
            '{{%order_user}}',
            array(
                'order_id' => Schema::TYPE_INTEGER,
				'user_id' => Schema::TYPE_INTEGER
            )
        );
    }

    public function safeDown()
    {
        $this->dropTable('order_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170926_161437_order_user_table cannot be reverted.\n";

        return false;
    }
    */
}
