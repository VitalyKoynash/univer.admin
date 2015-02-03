<?php

use yii\db\Schema;
use yii\db\Migration;
//$ yii migrate/up --migrationPath=console/migrations
class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // PRAGMA foreign_keys=ON;
        
        /*
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        
        $this->createTable('{{%edbouser}}', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'password' => Schema::TYPE_STRING . ' NOT NULL',
            'sessionguid' => Schema::TYPE_STRING. '(36)',
            'sessionguid_updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        
        $this->createTable('{{%edbouser_user}}', [
            'id' => Schema::TYPE_PK,
            'id_edbouser' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'id_user' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            //"FOREIGN KEY (id_user) REFERENCES {{{%user}}}(id) ON DELETE SET NULL ON UPDATE CASCADE",
            //"FOREIGN KEY (id_edbouser) REFERENCES {{{%edbouser}}}(id) ON DELETE SET NULL ON UPDATE CASCADE",
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            "FOREIGN KEY (id_user) REFERENCES {{%user}}(id) ON DELETE CASCADE ON UPDATE CASCADE",
            "FOREIGN KEY (id_edbouser) REFERENCES {{%edbouser}}(id) ON DELETE CASCADE ON UPDATE CASCADE",
        ], $tableOptions);

        $this->createIndex('idx_id_user', '{{%edbouser_user}}' , 'id_user', true);
        $this->createIndex('idx_id_edbouser', '{{%edbouser_user}}' , 'id_edbouser', false);
        */
        //$this->addForeignKey('fk_edbouser_user_id_user', '{{%edbouser}}','id_user','{{%user}}','id','CASCADE','CASCADE');
        //$this->addForeignKey('fk_edbouser_user_id_edbouser', '{{%edbouser}}','id_edbouser','{{%edbouser}}','id','CASCADE','CASCADE');


        $this->createTable('{{%edbo_KOATUUL1}}', [
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

        ], $tableOptions);

    }

    public function safeDown()
    {
        return;
        $this->dropTable('{{%edbouser_user}}');
        $this->dropTable('{{%edbouser}}');
        $this->dropTable('{{%user}}');
        
        $this->dropTable('{{%edbo_KOATUUL1}}');
    }
}
