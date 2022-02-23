<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post_category}}`.
 */
class m220223_050350_add_slug_column_to_post_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%post_category}}', 'slug', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%post_category}}', 'slug');
    }
}
