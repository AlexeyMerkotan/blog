<?php

use yii\db\Migration;
use backend\library\DbTableName;
use common\components\Status;

/**
 * Class m200727_114315_article
 */
class m200727_114315_article extends Migration
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

        $this->createTable(DbTableName::TABLE_ARTICLE, [
            '[[id]]' => $this->primaryKey(),
            '[[title]]' => $this->string(255),
            '[[description]]' => $this->text(),
            '[[owner_id]]' => $this->integer()->null(),
            '[[visible]]' => $this->integer()->defaultValue(Status::NO),
            '[[active]]' => $this->integer()->defaultValue(Status::NO),
            '[[created_at]]' => $this->integer(),
            '[[updated_at]]' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk_article_user',
            DbTableName::TABLE_ARTICLE,
            '[[owner_id]]',
            DbTableName::TABLE_USER,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable(DbTableName::TABLE_ARTICLE_TAG, [
            '[[id]]' => $this->primaryKey(),
            '[[article_id]]' => $this->integer()->null(),
            '[[name]]' => $this->string(255)
        ], $tableOptions);
        $this->addForeignKey('fk_article_tags',
            DbTableName::TABLE_ARTICLE_TAG,
            '[[article_id]]',
            DbTableName::TABLE_ARTICLE,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable(DbTableName::TABLE_ARTICLE_STATISTIC, [
            '[[id]]' => $this->primaryKey(),
            '[[article_id]]' => $this->integer()->null(),
        ], $tableOptions);
        $this->addForeignKey('fk_article_statistic',
            DbTableName::TABLE_ARTICLE_STATISTIC,
            '[[article_id]]',
            DbTableName::TABLE_ARTICLE,
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
       $this->dropForeignKey('fk_article_statistic', DbTableName::TABLE_ARTICLE_STATISTIC);
       $this->dropTable(DbTableName::TABLE_ARTICLE_STATISTIC);

        $this->dropForeignKey('fk_article_tags', DbTableName::TABLE_ARTICLE_TAG);
        $this->dropTable(DbTableName::TABLE_ARTICLE_TAG);

        $this->dropForeignKey('fk_article_user', DbTableName::TABLE_ARTICLE);
        $this->dropTable(DbTableName::TABLE_ARTICLE);
    }
}
