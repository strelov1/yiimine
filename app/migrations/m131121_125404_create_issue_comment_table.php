<?php

class m131121_125404_create_issue_comment_table extends CDbMigration {

    public function up() {
        $this->createTable('issue_comment', array(
            'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
            'issue_id' => 'INT(11) UNSIGNED NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'text' => 'text NOT NULL',
            'created_date' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'PRIMARY KEY (`id`)',
            'CONSTRAINT `fk_issue_id1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON UPDATE CASCADE ON DELETE CASCADE',
            'CONSTRAINT `fk_user_id2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE'
        ));
    }

    public function down() {
        $this->dropTable('issue_comment');
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
