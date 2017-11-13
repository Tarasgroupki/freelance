<?php

use yii\db\Schema;
use yii\db\Migration;

class m171108_163438_order_item_table extends Migration
{
    public function safeUp()
    {
	    $this->createTable(
            '{{%order_item}}',
            array(
                'delivery_id' => $this->primaryKey(),
				'user_id' => Schema::TYPE_INTEGER,
				'img_url' => Schema::TYPE_STRING,
				'link' => Schema::TYPE_STRING
            )
        );
		$this->addForeignKey('order_item_user', 'order_item', 'user_id', 'user', 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        return $this->dropTable('order_item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171108_163438_order_item_table cannot be reverted.\n";

        return false;
    }
    */
}
