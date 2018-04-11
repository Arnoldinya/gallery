<?php

use yii\db\Migration;

/**
 * Class m180410_181758_init
 */
class m180410_181758_init extends Migration
{
    public function up()
    {
        //пользователи
        $this->createTable('{{%user}}', [
            'id'       => $this->primaryKey(),
            'email'    => $this->string()->notNull(),
            'authKey'  => $this->string(32)->notNull(),
            'password' => $this->string()->notNull(),
            'name'     => $this->string()->notNull(),
            'created'  => $this->integer(),
            'updated'  => $this->integer(),
        ]);

        //галереи
        $this->createTable('{{%gallery}}', [
            'id'      => $this->primaryKey(),
            'userId'  => $this->integer()->notNull(),
            'name'    => $this->string()->notNull(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
        ]);

        $this->createIndex('gallery_userId', '{{%gallery}}', 'userId', true);
        $this->addForeignKey('gallery_userId', '{{%gallery}}', 'userId', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        //фотографии
        $this->createTable('{{%photo}}', [
            'id'          => $this->primaryKey(),
            'galleryId'   => $this->integer()->notNull(),
            'name'        => $this->string()->notNull(),
            'description' => $this->text(),
            'filePath'    => $this->string(400)->notNull(),
            'created'     => $this->integer(),
            'updated'     => $this->integer(),
        ]);

        $this->createIndex('photo_galleryId', '{{%photo}}', 'galleryId');
        $this->addForeignKey('photo_galleryId', '{{%photo}}', 'galleryId', '{{%gallery}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('photo_galleryId', '{{%photo}}');
        $this->dropForeignKey('gallery_userId', '{{%gallery}}');

        $this->dropTable('{{%photo}}');
        $this->dropTable('{{%gallery}}');
        $this->dropTable('{{%user}}');
    }
}
