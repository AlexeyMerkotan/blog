<?php

use yii\db\Migration;
use backend\library\DbTableName;

/**
 * Class m200727_181710_article_category
 */
class m200727_181710_article_category extends Migration
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

        $this->createTable(DbTableName::TABLE_CATEGORY, [
            '[[id]]' => $this->primaryKey(),
            '[[name]]' => $this->string(50),
        ], $tableOptions);

        $this->createTable(DbTableName::TABLE_ARTICLE_CATEGORY, [
            '[[id]]' => $this->primaryKey(),
            '[[article_id]]' => $this->integer()->null(),
            '[[category_id]]' => $this->integer()->null()
        ], $tableOptions);
        $this->addForeignKey('fk_category_article',
            DbTableName::TABLE_ARTICLE_CATEGORY,
            '[[article_id]]',
            DbTableName::TABLE_ARTICLE,
            '[[id]]',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey('fk_category_category',
            DbTableName::TABLE_ARTICLE_CATEGORY,
            '[[category_id]]',
            DbTableName::TABLE_CATEGORY,
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
        $this->dropForeignKey('fk_category_category', DbTableName::TABLE_ARTICLE_CATEGORY);
        $this->dropForeignKey('fk_category_article', DbTableName::TABLE_ARTICLE_CATEGORY);
        $this->dropTable(DbTableName::TABLE_ARTICLE_CATEGORY);

        $this->dropTable(DbTableName::TABLE_CATEGORY);
    }
}
