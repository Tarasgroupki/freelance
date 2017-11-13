<?php

use yii\db\Schema;
use yii\db\Migration;

class m170925_105802_orders_table extends Migration
{
    public function safeUp()
    {
      $this->createTable(
            '{{%orders}}',
            array(
                'order_id' => Schema::TYPE_PK,
				'user_id' => Schema::TYPE_INTEGER,
				'message_id' => Schema::TYPE_INTEGER,
                'order_title' => Schema::TYPE_STRING . ' NOT NULL',
                'order_desc' => Schema::TYPE_TEXT . ' NOT NULL'
            )
        );
		$this->addForeignKey('orders_user_id','orders','user_id','user','id');
		//$this->addForeignKey('order_message_id','orders','message_id','messages','id');
    }

    public function safeDown()
    {
        $this->dropTable('orders');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170925_205802_orders_table cannot be reverted.\n";

        return false;
    }
    */
}
