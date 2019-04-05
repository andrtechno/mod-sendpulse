<?php
namespace panix\mod\sendpulse\migrations;

/**
 * Generation migrate by PIXELION CMS
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 *
 * Class m170908_123150_push_templates
 */
use Yii;
use yii\db\Migration;
use panix\mod\sendpulse\models\PushTemplate;


class m170908_123150_push_templates extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(PushTemplate::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(50)->notNull(),
            'body' => $this->string(125)->notNull(),
            'link' => $this->string(255)->null(),
            'icon' => $this->text()->null(),
            'button1_text' => $this->string(25)->null(),
            'button1_link' => $this->string(255)->null(),
            'button2_text' => $this->string(25)->null(),
            'button2_link' => $this->string(255)->null(),

        ], $tableOptions);


        $this->createIndex('switch', PushTemplate::tableName(), 'switch');


    }

    public function down()
    {
        $this->dropTable(PushTemplate::tableName());
    }

}
