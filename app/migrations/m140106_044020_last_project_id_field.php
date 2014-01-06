<?php

class m140106_044020_last_project_id_field extends CDbMigration
{
    public function up()
    {
        $this->addColumn('users', 'last_project_id', 'INT(11) UNSIGNED');
    }

    public function down()
    {
        $this->dropColumn('users', 'last_project_id');
    }
}