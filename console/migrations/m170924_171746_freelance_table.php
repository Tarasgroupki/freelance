<?php

use yii\db\Migration;

class m170924_171746_freelance_table extends Migration
{
    public function safeUp()
    {	 $this->createTable('newsapps', [
           'newapp_id' => $this->primaryKey(),
		   'news_img' => 'string NOT NULL',
		   'news_views' => $this->integer()->defaultValue(0),
        ]);
		$this->addForeignKey('newsapps_newsapp_id','newsapps','newsapp_id','news','newsapp_id');
       $this->createTable('news', [
            'news_id' => $this->integer(),
			'newsapp_id' => $this->integer(),
			'category_id' => $this->integer(),
			'lang_id' => $this->integer(),
			'news_name' => 'string NOT NULL',
			'news_description' => 'string NOT NULL',
        ]);
		$this->addForeignKey('news_lang_id','news','lang_id','languages','lang_id');
        $this->addForeignKey('news_newsapp_id','news','newsapp_id','newsapps','newsapp_id');
      
		$this->createTable('languages', [
            'lang_id' => $this->primaryKey(),
			'lang_name' => 'string NOT NULL',
			'lang_symbols' => 'string NOT NULL',
			'keywords_lang' => 'string NOT NULL',
			'description_lang' => 'text',
        ]);
		$this->addForeignKey('languages_newsapp_id','languages','lang_id','news','lang_id');

		}

    public function safeDown()
    {
        $this->dropTable('news');
		$this->dropTable('newsapps');
		$this->dropTable('languages');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170924_171746_freelance_table cannot be reverted.\n";

        return false;
    }
    */
}
