<?php

use yii\db\Migration;
use Yii;

class m170319_140138_init extends Migration
{

    private $tableOptions = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

    public function up()
    {
        // files
        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey()->unsigned(),
            'project_id' => $this->integer(10)->unsigned()->notNull(),
            'user_id' => $this->integer(10)->unsigned()->null(),
            'file' => $this->string(255)->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // issue
        $this->createTable('{{%issue}}', [
            'id' => $this->primaryKey()->unsigned(),
            'tracker_id' => $this->smallInteger(3)->unsigned()->notNull()->defaultValue(1),
            'subject' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'status_id' => $this->smallInteger(3)->unsigned()->notNull()->defaultValue(1),
            'priority_id' => $this->smallInteger(3)->unsigned()->notNull()->defaultValue(3),
            'assignee_id' => $this->integer(10)->unsigned()->null(),
            'deadline' => $this->date()->null(),
            'readiness_id' => $this->smallInteger(3)->unsigned()->null(),
            'project_id' => $this->integer(10)->unsigned()->notNull(),
            'creator_id' => $this->integer(11)->unsigned()->null(),
            'milestone_id' => $this->integer(10)->unsigned()->null(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // issue_checklist
        $this->createTable('{{%issue_checklist}}', [
            'id' => $this->primaryKey()->unsigned(),
            'issue_id' => $this->integer(10)->unsigned()->notNull(),
            'item' => $this->string(255)->notNull(),
            'status_id' => $this->smallInteger(3)->unsigned()->notNull()->defaultValue(1),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // issue_comment
        $this->createTable('{{%issue_comment}}', [
            'id' => $this->primaryKey()->unsigned(),
            'issue_id' => $this->integer(10)->unsigned()->notNull(),
            'user_id' => $this->integer(10)->unsigned()->notNull(),
            'text' => $this->text()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'status_id' => $this->smallInteger(1)->unsigned()->notNull()->defaultValue(1),
        ], $this->tableOptions);

        // issue_photo
        $this->createTable('{{%issue_photo}}', [
            'id' => $this->primaryKey()->unsigned(),
            'file' => $this->string(255)->notNull(),
            'issue_id' => $this->integer(10)->unsigned()->notNull(),
        ], $this->tableOptions);

        // log
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey()->unsigned(),
            'model' => $this->string(32)->null(),
            'model_id' => $this->integer(11)->unsigned()->null(),
            'status_id' => $this->integer(11)->null(),
            'user_id' => $this->integer(11)->unsigned()->null(),
            'ts' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // milestone
        $this->createTable('{{%milestone}}', [
            'id' => $this->primaryKey()->unsigned(),
            'project_id' => $this->integer(10)->unsigned()->notNull(),
            'title' => $this->string(255)->notNull(),
            'start_date' => $this->date()->null(),
            'end_date' => $this->date()->null(),
            'user_id' => $this->integer(10)->unsigned()->null(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // note
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey()->unsigned(),
            'for_date' => $this->date()->null(),
            'description' => $this->text()->null(),
            'user_id' => $this->integer(11)->unsigned()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // project
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'is_public' => $this->smallInteger(4)->notNull()->defaultValue(0),
            'status_id' => $this->smallInteger(4)->notNull()->defaultValue(1),
            'creator_id' => $this->integer(10)->unsigned()->null(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // project_member
        $this->createTable('{{%project_member}}', [
            'id' => $this->primaryKey()->unsigned(),
            'project_id' => $this->integer(10)->unsigned()->notNull(),
            'user_id' => $this->integer(10)->unsigned()->notNull(),
            'roles' => $this->text()->null(),
        ], $this->tableOptions);

        // settings
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey()->unsigned(),
            'key' => $this->string(255)->notNull()->unique(),
            'value' => $this->text()->notNull(),
            'user_id' => $this->integer(11)->unsigned()->null(),
        ], $this->tableOptions);

        // tag
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'project_id' => $this->integer(11)->unsigned()->notNull(),
        ], $this->tableOptions);

        // tag_model
        $this->createTable('{{%tag_model}}', [
            'model_name' => $this->string(255)->notNull(),
            'model_id' => $this->integer(10)->unsigned()->notNull(),
            'tag_id' => $this->integer(10)->unsigned()->notNull(),
            'PRIMARY KEY (model_name, model_id, tag_id)',
        ], $this->tableOptions);

        // user
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string(45)->notNull(),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->null(),
            'auth_key' => $this->string(255)->notNull(),
            'status_id' => $this->boolean()->notNull()->defaultValue(1),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_visit_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),], $this->tableOptions);

        // wiki
        $this->createTable('{{%wiki}}', [
            'id' => $this->primaryKey()->unsigned(),
            'project_id' => $this->integer(10)->unsigned()->notNull(),
            'user_id' => $this->integer(10)->unsigned()->null(),
            'title' => $this->string(255)->notNull(),
            'text' => $this->text()->notNull(),
            'created_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ], $this->tableOptions);

        // fk: files
        $this->addForeignKey('fk_files_project_id', '{{%files}}', 'project_id', '{{%project}}', 'id');
        $this->addForeignKey('fk_files_user_id', '{{%files}}', 'user_id', '{{%user}}', 'id');

        // fk: issue
        $this->addForeignKey('fk_issue_milestone_id', '{{%issue}}', 'milestone_id', '{{%milestone}}', 'id');
        $this->addForeignKey('fk_issue_project_id', '{{%issue}}', 'project_id', '{{%project}}', 'id');
        $this->addForeignKey('fk_issue_assignee_id', '{{%issue}}', 'assignee_id', '{{%user}}', 'id');
        $this->addForeignKey('fk_issue_creator_id', '{{%issue}}', 'creator_id', '{{%user}}', 'id');

        // fk: issue_checklist
        $this->addForeignKey('fk_issue_checklist_issue_id', '{{%issue_checklist}}', 'issue_id', '{{%issue}}', 'id');

        // fk: issue_comment
        $this->addForeignKey('fk_issue_comment_issue_id', '{{%issue_comment}}', 'issue_id', '{{%issue}}', 'id');
        $this->addForeignKey('fk_issue_comment_user_id', '{{%issue_comment}}', 'user_id', '{{%user}}', 'id');

        // fk: issue_photo
        $this->addForeignKey('fk_issue_photo_issue_id', '{{%issue_photo}}', 'issue_id', '{{%issue}}', 'id');

        // fk: milestone
        $this->addForeignKey('fk_milestone_project_id', '{{%milestone}}', 'project_id', '{{%project}}', 'id');
        $this->addForeignKey('fk_milestone_user_id', '{{%milestone}}', 'user_id', '{{%user}}', 'id');

        // fk: project
        $this->addForeignKey('fk_project_creator_id', '{{%project}}', 'creator_id', '{{%user}}', 'id');

        // fk: project_member
        $this->addForeignKey('fk_project_member_project_id', '{{%project_member}}', 'project_id', '{{%project}}', 'id');
        $this->addForeignKey('fk_project_member_user_id', '{{%project_member}}', 'user_id', '{{%user}}', 'id');

        // fk: settings
        $this->addForeignKey('fk_settings_user_id', '{{%settings}}', 'user_id', '{{%user}}', 'id');

        // fk: tag_model
        $this->addForeignKey('fk_tag_model_tag_id', '{{%tag_model}}', 'tag_id', '{{%tag}}', 'id');

        // fk: wiki
        $this->addForeignKey('fk_wiki_project_id', '{{%wiki}}', 'project_id', '{{%project}}', 'id');
        $this->addForeignKey('fk_wiki_user_id', '{{%wiki}}', 'user_id', '{{%user}}', 'id');


        // create admin
        Yii::$app->db->createCommand()->insert('user', [
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'password' => Yii::$app->security->generatePasswordHash('admin'),
        ])->execute();

        // init setting
        Yii::$app->db->createCommand()->batchInsert('settings', ['key', 'value', 'user_id'], [
            ['app_name', 'YiiMine', 1],
            ['app_description', 'Project Management System YiiMine welcomes you!', 1],
            ['app_logo', 'default_logo.png', 1],
        ])->execute();


//        $this->execute(
//          "
//          CREATE TABLE `user` (
//              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//              `username` varchar(45) NOT NULL,
//              `first_name` varchar(255) NOT NULL,
//              `last_name` varchar(255) NOT NULL,
//              `email` varchar(255) NOT NULL,
//              `password` varchar(255) NOT NULL,
//              `password_reset_token` varchar(255) DEFAULT NULL,
//              `auth_key` varchar(255) NOT NULL,
//              `status_id` tinyint(1) NOT NULL DEFAULT '1',
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `last_visit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `project` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `title` varchar(255) NOT NULL,
//              `description` text,
//              `is_public` tinyint(4) NOT NULL DEFAULT '0',
//              `status_id` tinyint(4) NOT NULL DEFAULT '1',
//              `creator_id` int(10) unsigned DEFAULT NULL,
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` timestamp NOT NULL,
//              PRIMARY KEY (`id`),
//              KEY `project_ibfk_1` (`creator_id`),
//              CONSTRAINT `project_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//
//            CREATE TABLE `project_member` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `project_id` int(10) unsigned NOT NULL,
//              `user_id` int(10) unsigned NOT NULL,
//              `roles` text,
//              PRIMARY KEY (`id`),
//              KEY `project_member_ibfk_1` (`project_id`),
//              KEY `project_member_ibfk_2` (`user_id`),
//              CONSTRAINT `project_member_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//              CONSTRAINT `project_member_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//
//            CREATE TABLE `settings` (
//              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//              `key` varchar(255) NOT NULL,
//              `value` text NOT NULL,
//              `user_id` int(11) unsigned DEFAULT NULL,
//              PRIMARY KEY (`id`),
//              UNIQUE KEY `key_user_id_index` (`key`,`user_id`),
//              KEY `user_id` (`user_id`),
//              CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `milestone` (
//              `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//              `project_id` INT(10) UNSIGNED NOT NULL,
//              `title` VARCHAR(255) NOT NULL,
//              `start_date` DATE NULL DEFAULT '0000-00-00',
//              `end_date` DATE NULL DEFAULT '0000-00-00',
//              `user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//              `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` TIMESTAMP NOT NULL,
//              PRIMARY KEY (`id`),
//              INDEX `fk_milestone_1_project_idx` (`project_id`),
//              INDEX `fk_milestone_1_user_idx` (`user_id`),
//              CONSTRAINT `fk_milestone_1_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
//              CONSTRAINT `fk_milestone_1_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//            ) COLLATE='utf8_general_ci' ENGINE=InnoDB;
//
//            CREATE TABLE `issue` (
//              `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
//              `tracker_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
//              `subject` VARCHAR(255) NOT NULL,
//              `description` TEXT NULL,
//              `status_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
//              `priority_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '3',
//              `assignee_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//              `deadline` DATE NULL DEFAULT NULL,
//              `readiness_id` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
//              `project_id` INT(10) UNSIGNED NOT NULL,
//              `creator_id` INT(11) UNSIGNED NULL DEFAULT NULL,
//              `milestone_id` INT(10) UNSIGNED NULL DEFAULT NULL,
//              `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` TIMESTAMP NOT NULL,
//              PRIMARY KEY (`id`),
//              INDEX `assignee_id` (`assignee_id`),
//              INDEX `creator_id` (`creator_id`),
//              INDEX `issue_ibfk_1` (`project_id`),
//              INDEX `fk_issue_1_milestone_idx` (`milestone_id`),
//              CONSTRAINT `fk_issue_1_milestone` FOREIGN KEY (`milestone_id`) REFERENCES `milestone` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
//              CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
//              CONSTRAINT `issue_ibfk_2` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
//              CONSTRAINT `issue_ibfk_3` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
//            ) COLLATE='utf8_general_ci' ENGINE=InnoDB;
//
//            CREATE TABLE `issue_comment` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `issue_id` int(10) unsigned NOT NULL,
//              `user_id` int(10) unsigned NOT NULL,
//              `text` text NOT NULL,
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` timestamp NOT NULL,
//              `status_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
//              PRIMARY KEY (`id`),
//              KEY `issue_comment_ibfk_1` (`issue_id`),
//              KEY `issue_comment_ibfk_2` (`user_id`),
//              CONSTRAINT `issue_comment_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//              CONSTRAINT `issue_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `issue_photo` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `file` varchar(255) NOT NULL,
//              `issue_id` int(10) unsigned NOT NULL,
//              PRIMARY KEY (`id`),
//              KEY `fk_issue_photo_1_idx` (`issue_id`),
//              CONSTRAINT `fk_issue_photo_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `issue_checklist` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `issue_id` int(10) unsigned NOT NULL,
//              `item` varchar(255) NOT NULL,
//              `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` timestamp NOT NULL,
//              PRIMARY KEY (`id`),
//              KEY `issue_id` (`issue_id`),
//              CONSTRAINT `issue_checklist_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `files` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `project_id` int(10) unsigned NOT NULL,
//              `user_id` int(10) unsigned DEFAULT NULL,
//              `file` varchar(255) NOT NULL,
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              PRIMARY KEY (`id`),
//              KEY `files_ibfk_1` (`project_id`),
//              KEY `files_ibfk_2` (`user_id`),
//              CONSTRAINT `files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
//              CONSTRAINT `files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `wiki` (
//              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//              `project_id` int(10) unsigned NOT NULL,
//              `user_id` int(10) unsigned DEFAULT NULL,
//              `title` varchar(255) NOT NULL,
//              `text` text NOT NULL,
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` timestamp NOT NULL,
//              PRIMARY KEY (`id`),
//              KEY `wiki_ibfk_1` (`project_id`),
//              KEY `wiki_ibfk_2` (`user_id`),
//              CONSTRAINT `wiki_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
//              CONSTRAINT `wiki_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `log` (
//              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//              `model` varchar(32) DEFAULT NULL,
//              `model_id` int(11) unsigned DEFAULT NULL,
//              `status_id` int(11) DEFAULT NULL,
//              `user_id` int(11) unsigned DEFAULT NULL,
//              `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              PRIMARY KEY (`id`),
//              KEY `model_index` (`model`),
//              KEY `status_id_index` (`status_id`),
//              KEY `model_id_index` (`model_id`),
//              KEY `user_id_index` (`user_id`),
//              KEY `model_model_id_index` (`model`,`model_id`),
//              KEY `model_model_id_status_id_index` (`model`,`model_id`,`status_id`),
//              KEY `model_model_id_status_id_user_id_index` (`model`,`model_id`,`status_id`,`user_id`)
//            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `note` (
//              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//              `for_date` date DEFAULT NULL,
//              `description` text,
//              `user_id` int(11) unsigned NOT NULL,
//              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//              `updated_date` timestamp NOT NULL,
//              PRIMARY KEY (`id`)
//            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
//
//            CREATE TABLE `tag` (
//              `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
//              `name` VARCHAR(255) NOT NULL,
//              `project_id` INT(11) UNSIGNED NOT NULL,
//              PRIMARY KEY (`id`),
//              INDEX `project_id` (`project_id`)
//            )
//            COLLATE='utf8_general_ci' ENGINE=InnoDB;
//
//            CREATE TABLE `tag_model` (
//              `model_name` VARCHAR(255) NOT NULL,
//              `model_id` INT(10) UNSIGNED NOT NULL,
//              `tag_id` INT(10) UNSIGNED NOT NULL,
//              PRIMARY KEY (`model_name`, `model_id`, `tag_id`),
//              INDEX `fk_tag_id` (`tag_id`),
//              CONSTRAINT `fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
//            )
//            COLLATE='utf8_general_ci' ENGINE=InnoDB;"
//        );
    }

    public function down()
    {
        echo "m170319_140138_init cannot be reverted.\n";

        return false;
    }
}
