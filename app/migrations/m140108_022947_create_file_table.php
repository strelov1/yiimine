<?php

class m140108_022947_create_file_table extends CDbMigration
{
    public function up()
    {
        $transaction = $this->getDbConnection()->beginTransaction();
        try {
            $this->createTable('file', array(
                'id' => 'pk',
                'user_id' => 'INT(11) NOT NULL',
                'project_id' => 'INT(11) UNSIGNED NOT NULL',
                'name' => 'string NOT NULL',
                'description' => 'string',
                'created_date' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            ));

            $this->addForeignKey('fk_user_id4', 'file', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fk_project_id4', 'file', 'project_id', 'project', 'id', 'CASCADE', 'CASCADE');

            $transaction->commit();
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage() . "\n";
            $transaction->rollback();
            return false;
        }
    }

    public function down()
    {
        $this->dropTable('file');
    }
}