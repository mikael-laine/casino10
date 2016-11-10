<?php

use yii\db\Migration;

/**
 * Handles the creation of table `theme`.
 */
class m161110_175240_create_theme_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%theme}}', [
            'id' => $this->primaryKey(11),
            'category_id' => $this->string(255)->notNull(),
            'banner_image' => $this->string(255),
            'banner_heading' => $this->text(),
            'banner_subheading' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ],$tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%theme}}');
    }
}
