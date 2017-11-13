<?php

use yii\db\Schema;
use yii\db\Migration;

class m170831_155917_category_tab extends Migration
{
	//public $tableName = '{{%category}}';
	
    public function safeUp()
    {
		$this->createTable(
            '{{%category}}',
            array(
                'cat_id' => Schema::TYPE_PK,
				'category_id' => Schema::TYPE_INTEGER,
                'lang_id' => Schema::TYPE_INTEGER,
                'cat_name' => Schema::TYPE_STRING . ' NOT NULL',
                'cat_desc' => Schema::TYPE_TEXT . ' NOT NULL',
                'slug' => Schema::TYPE_STRING
            )
        );
		//$this->addForeignKey('category_category_id','category','category_id','news','category_id');
    }

    public function safeDown()
    {
       $this->dropTable('{{%category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170831_155917_category_tab cannot be reverted.\n";

        return false;
    }
    */
}
