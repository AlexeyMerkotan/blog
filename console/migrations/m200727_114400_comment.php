<?php

use yii\db\Migration;
use backend\library\DbTableName;
use common\components\Status;

/**
 * Class m200727_114400_comment
 */
class m200727_114400_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(DbTableName::TABLE_COMMENT, [
            '[[id]]' => $this->primaryKey(),
            '[[article_id]]' => $this->integer(),
            '[[parent_id]]' => $this->integer()->null(),
            '[[description]]' => $this->string(),
            '[[owner_id]]' => $this->integer()->null(),
            '[[visible]]' => $this->integer()->defaultValue(Status::NO),
            '[[active]]' => $this->integer()->defaultValue(Status::NO),
            '[[created_at]]' => $this->integer(),
            '[[updated_at]]' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk_comment_article',
            DbTableName::TABLE_COMMENT,
            '[[article_id]]',
            DbTableName::TABLE_ARTICLE,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_comment_parent',
            DbTableName::TABLE_COMMENT,
            '[[parent_id]]',
            DbTableName::TABLE_COMMENT,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_comment_user',
            DbTableName::TABLE_COMMENT,
            '[[owner_id]]',
            DbTableName::TABLE_USER,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comment_user', DbTableName::TABLE_COMMENT);
        $this->dropForeignKey('fk_comment_parent', DbTableName::TABLE_COMMENT);
        $this->dropForeignKey('fk_comment_article', DbTableName::TABLE_COMMENT);
        $this->dropTable(DbTableName::TABLE_COMMENT);
    }
}
