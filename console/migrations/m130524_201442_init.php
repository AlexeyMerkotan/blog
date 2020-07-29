<?php

use yii\db\Migration;
use common\models\Role;
use backend\library\DbTableName;
use common\models\User;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'image' => $this->string(255)->null(),
            'role' => $this->string()->defaultValue(Role::ROLE_USER),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->batchInsert(DbTableName::TABLE_USER, [
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email',
            'status',
            'image',
            'role',
            'created_at',
            'updated_at'
        ], [
            [
            'test',
            'B22bSfGed68nQ7CAvjetcikueAcjuv8p',
            '$2y$13$ulQYX1ZNIDka2xiANldLaeMD72qfockf9a.3tOQMZR0a7Wdkm77/W',
            '',
            'test@net.ua',
            User::STATUS_ACTIVE,
            Role::ROLE_ADMIN,
            1595869719,
            1595869719,
            'P2qX4Pyg1-bpOBf7uU7yUFd0_vY0hteV_1595869719'
            ]
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
