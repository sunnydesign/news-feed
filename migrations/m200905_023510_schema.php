<?php

use yii\db\Migration;

/**
 * Class m200905_023510_schema
 */
class m200905_023510_schema extends Migration
{
    public function up()
    {
        // creates `categories` table
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->comment('Parent category id'),
            'title' => $this->char(255)->notNull()->comment('Category heading'),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);

        // creates index for `categories` table
        $this->createIndex(
            'idx-category-parent_id',
            '{{%categories}}',
            'parent_id'
        );

        // add foreign key for `categories` table
        $this->addForeignKey(
            'fk-category-parent_id',
            '{{%categories}}',
            'parent_id',
            '{{%categories}}',
            'id',
            'SET NULL'
        );

        // creates `articles` table
        $this->createTable('{{%articles}}', [
            'id' => $this->primaryKey(),
            'title' => $this->char(255)->notNull()->comment('Article heading'),
            'content' => $this->text()->notNull()->comment('Article content'),
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp(),
        ]);

        // creates `articleCategories` table
        $this->createTable('{{%articleCategories}}', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(11)->notNull()->comment('Article id'),
            'category_id' => $this->integer(11)->notNull()->comment('Category id'),
        ]);

        // creates indexes for `articleCategories` table
        $this->createIndex(
            'idx-articleCategories-article_id',
            '{{%articleCategories}}',
            'article_id'
        );
        $this->createIndex(
            'idx-articleCategories-category_id',
            '{{%articleCategories}}',
            'category_id'
        );

        // add foreign keys for `articleCategories` table
        $this->addForeignKey(
            'fk-articleCategories-article_id',
            '{{%articleCategories}}',
            'article_id',
            '{{%articles}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-articleCategories-category_id',
            '{{%articleCategories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // seeds data
        $this->execute("
            INSERT INTO `categories` (`id`, `parent_id`, `title`) VALUES
                (1, NULL, 'first'),
                (2, NULL, 'two'),
                (3, NULL, 'three'),
                (4, 1, 'four'),
                (5, 4, 'five');
                
            INSERT INTO `articles` (`id`, `title`, `content`) VALUES
                (1, 'one A', 'one A content'),
                (2, 'two A', 'two A content1');
            INSERT INTO `articleCategories` (`id`, `article_id`, `category_id`) VALUES
                (1, 1, 1),
                (2, 2, 3),
                (4, 2, 2);
        ");
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-category-parent_id',
            '{{%categories}}'
        );
        $this->dropForeignKey(
            'fk-articleCategories-article_id',
            '{{%articleCategories}}'
        );
        $this->dropForeignKey(
            'fk-articleCategories-category_id',
            '{{%articleCategories}}'
        );
        $this->dropTable('{{%articleCategories}}');

        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%articles}}');

        return true;
    }
}
