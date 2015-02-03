<?php

use yii\db\Schema;
use yii\db\Migration;

class m150203_212858_init_edbo extends Migration
{
	public function init()
	{
	    $this->db = 'db_edbo';
	    parent::init();
	}



    public function safeUp()
    {

    	$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%KOATUUL1}}', [
            'id' => Schema::TYPE_PK,
            'Id_KOATUU'  => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'KOATUUCode' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'Type' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'Id_KOATUUName'  => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'KOATUUName' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'KOATUUFullName' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'KOATUUDateBegin' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'KOATUUDateEnd' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'Id_Language' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'KOATUUCodeL1' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'KOATUUCodeL2' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'KOATUUCodeL3' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',

        ], $tableOptions);

        $this->createIndex('idx_KOATUUL1_KOATUUCodeL1', '{{%KOATUUL1}}' , 'KOATUUCodeL1', false);
        $this->createIndex('idx_KOATUUL1_KOATUUCodeL2', '{{%KOATUUL1}}' , 'KOATUUCodeL2', false);
        $this->createIndex('idx_KOATUUL1_KOATUUCodeL3', '{{%KOATUUL1}}' , 'KOATUUCodeL3', false);
        $this->createIndex('idx_KOATUUL1_KOATUUFullName', '{{%KOATUUL1}}' , 'KOATUUFullName', false);
        $this->createIndex('idx_KOATUUL1_KOATUUName', '{{%KOATUUL1}}' , 'KOATUUName', false);
    }

    public function safeDown()
    {
        echo "m150203_212858_init_edbo cannot be reverted.\n";

        return false;
    }
}
