<?php

use yii\db\Migration;

/**
 * Class m200512_094217_files
 */
class m200512_094217_files extends Migration
{
    public function up()
    {
        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey(),
            'uuid' => $this->char(36)->comment('UUID'),
            'name' => $this->text()->comment('File name'),
            'path' => $this->text()->comment('Path to the file'),
            //'mime' => $this->text()->comment('Mime type of the file'),
            //'size' => $this->text()->comment('File size'),
            'metadata' => $this->text()->comment('Metadata file'),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
        ]);
        //$this->addPrimaryKey('pk_code', 'country', 'code');
    }

    public function down()
    {
        $this->dropTable('{{%files}}');

        return false;
    }
}
