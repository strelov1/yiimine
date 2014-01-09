<?php

class m140109_034747_alter_wiki_page extends CDbMigration
{
    public function up()
    {
        $this->addColumn('wiki_page', 'project_id', 'INT(11) UNSIGNED NOT NULL');
        $this->addForeignKey('fk_project_id6', 'wiki_page', 'project_id', 'project', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropColumn('wiki_page', 'project_id');
    }
}