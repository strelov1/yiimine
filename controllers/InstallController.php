<?php
namespace app\controllers;
use yii\web\Controller;
use app\models\form\SettingsForm;
use app\models\Settings;
use app\models\User;
use app\rbac\ViewProjectRule;
use Yii;

class InstallController extends Controller
{

    public $layout = false;

    public function actionIndex()
    {
        if (Yii::$app->db->schema->getTableSchema('settings') !== null) {
            Yii::$app->response->redirect(['/site/index']);
        }
        $db = \Yii::$app->db;
        $db->createCommand(
            "CREATE TABLE `user` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `username` varchar(45) NOT NULL,
              `first_name` varchar(255) NOT NULL,
              `last_name` varchar(255) NOT NULL,
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `password_reset_token` varchar(255) DEFAULT NULL,
              `auth_key` varchar(255) NOT NULL,
              `status_id` tinyint(1) NOT NULL DEFAULT '1',
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `last_visit_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
        )->execute();
        echo "user table created...<br />";
        $user = $this->userInit();
        echo "admin user created...<br />";
        $db->createCommand(
            "CREATE TABLE `project` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `title` varchar(255) NOT NULL,
              `description` text,
              `is_public` tinyint(4) NOT NULL DEFAULT '0',
              `status_id` tinyint(4) NOT NULL DEFAULT '1',
              `creator_id` int(10) unsigned DEFAULT NULL,
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `project_ibfk_1` (`creator_id`),
              CONSTRAINT `project_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "project table created...<br />";
        $db->createCommand(
            "CREATE TABLE `project_member` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `project_id` int(10) unsigned NOT NULL,
              `user_id` int(10) unsigned NOT NULL,
              `roles` text,
              PRIMARY KEY (`id`),
              KEY `project_member_ibfk_1` (`project_id`),
              KEY `project_member_ibfk_2` (`user_id`),
              CONSTRAINT `project_member_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `project_member_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "project_member table created...<br />";
        $db->createCommand(
            "CREATE TABLE `settings` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `key` varchar(255) NOT NULL,
              `value` text NOT NULL,
              `user_id` int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `key_user_id_index` (`key`,`user_id`),
              KEY `user_id` (`user_id`),
              CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "settings table created...<br />";
        $this->settingsInit($user->id);
        echo "temporary settings saved...<br />";
        $db->createCommand(
            "CREATE TABLE `milestone` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `project_id` INT(10) UNSIGNED NOT NULL,
                `title` VARCHAR(255) NOT NULL,
                `start_date` DATE NULL DEFAULT '0000-00-00',
                `end_date` DATE NULL DEFAULT '0000-00-00',
                `user_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_date` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
                PRIMARY KEY (`id`),
                INDEX `fk_milestone_1_project_idx` (`project_id`),
                INDEX `fk_milestone_1_user_idx` (`user_id`),
                CONSTRAINT `fk_milestone_1_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
                CONSTRAINT `fk_milestone_1_project` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            ) COLLATE='utf8_general_ci' ENGINE=InnoDB;"
        )->execute();
        $db->createCommand(
            "CREATE TABLE `issue` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `tracker_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
                `subject` VARCHAR(255) NOT NULL,
                `description` TEXT NULL,
                `status_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1',
                `priority_id` TINYINT(3) UNSIGNED NOT NULL DEFAULT '3',
                `assignee_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `deadline` DATE NULL DEFAULT NULL,
                `readiness_id` TINYINT(3) UNSIGNED NULL DEFAULT NULL,
                `project_id` INT(10) UNSIGNED NOT NULL,
                `creator_id` INT(11) UNSIGNED NULL DEFAULT NULL,
                `milestone_id` INT(10) UNSIGNED NULL DEFAULT NULL,
                `created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_date` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
                PRIMARY KEY (`id`),
                INDEX `assignee_id` (`assignee_id`),
                INDEX `creator_id` (`creator_id`),
                INDEX `issue_ibfk_1` (`project_id`),
                INDEX `fk_issue_1_milestone_idx` (`milestone_id`),
                CONSTRAINT `fk_issue_1_milestone` FOREIGN KEY (`milestone_id`) REFERENCES `milestone` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
                CONSTRAINT `issue_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT `issue_ibfk_2` FOREIGN KEY (`assignee_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL,
                CONSTRAINT `issue_ibfk_3` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
            ) COLLATE='utf8_general_ci' ENGINE=InnoDB;"
        )->execute();
        echo "issue table created...<br />";
        $db->createCommand(
            "CREATE TABLE `issue_comment` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `issue_id` int(10) unsigned NOT NULL,
              `user_id` int(10) unsigned NOT NULL,
              `text` text NOT NULL,
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `status_id` tinyint(1) unsigned NOT NULL DEFAULT '1',
              PRIMARY KEY (`id`),
              KEY `issue_comment_ibfk_1` (`issue_id`),
              KEY `issue_comment_ibfk_2` (`user_id`),
              CONSTRAINT `issue_comment_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `issue_comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "issue_comment table created...<br />";
        $db->createCommand(
            "CREATE TABLE `issue_photo` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `file` varchar(255) NOT NULL,
              `issue_id` int(10) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              KEY `fk_issue_photo_1_idx` (`issue_id`),
              CONSTRAINT `fk_issue_photo_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "issue_photo table created...<br />";
        $db->createCommand(
            "CREATE TABLE `issue_checklist` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `issue_id` int(10) unsigned NOT NULL,
              `item` varchar(255) NOT NULL,
              `status_id` tinyint(3) unsigned NOT NULL DEFAULT '1',
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `issue_id` (`issue_id`),
              CONSTRAINT `issue_checklist_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `issue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        )->execute();
        echo "issue_checklist table created...<br />";
        $db->createCommand(
            'CREATE TABLE `files` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `project_id` int(10) unsigned NOT NULL,
              `user_id` int(10) unsigned DEFAULT NULL,
              `file` varchar(255) NOT NULL,
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `files_ibfk_1` (`project_id`),
              KEY `files_ibfk_2` (`user_id`),
              CONSTRAINT `files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `files_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        )->execute();
        echo "files table created...<br />";
        $db->createCommand(
            "CREATE TABLE `wiki` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `project_id` int(10) unsigned NOT NULL,
              `user_id` int(10) unsigned DEFAULT NULL,
              `title` varchar(255) NOT NULL,
              `text` text NOT NULL,
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`),
              KEY `wiki_ibfk_1` (`project_id`),
              KEY `wiki_ibfk_2` (`user_id`),
              CONSTRAINT `wiki_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `wiki_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "wiki table created...<br />";
        $db->createCommand(
            "CREATE TABLE `log` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `model` varchar(32) DEFAULT NULL,
              `model_id` int(11) unsigned DEFAULT NULL,
              `status_id` int(11) DEFAULT NULL,
              `user_id` int(11) unsigned DEFAULT NULL,
              `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `model_index` (`model`),
              KEY `status_id_index` (`status_id`),
              KEY `model_id_index` (`model_id`),
              KEY `user_id_index` (`user_id`),
              KEY `model_model_id_index` (`model`,`model_id`),
              KEY `model_model_id_status_id_index` (`model`,`model_id`,`status_id`),
              KEY `model_model_id_status_id_user_id_index` (`model`,`model_id`,`status_id`,`user_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
        )->execute();
        echo "log table created...<br />";
        $db->createCommand(
            "CREATE TABLE `note` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `for_date` date DEFAULT NULL,
              `description` text,
              `user_id` int(11) unsigned NOT NULL,
              `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        )->execute();
        echo "note table created...<br />";
        $db->createCommand(
            "CREATE TABLE `tag` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NOT NULL,
                `project_id` INT(11) UNSIGNED NOT NULL,
                PRIMARY KEY (`id`),
                INDEX `project_id` (`project_id`)
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;"
        )->execute();
        echo "tag table created...<br />";
        $db->createCommand(
            "CREATE TABLE `tag_model` (
                `model_name` VARCHAR(255) NOT NULL,
                `model_id` INT(10) UNSIGNED NOT NULL,
                `tag_id` INT(10) UNSIGNED NOT NULL,
                PRIMARY KEY (`model_name`, `model_id`, `tag_id`),
                INDEX `fk_tag_id` (`tag_id`),
                CONSTRAINT `fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB;"
        )->execute();
        echo "tag_model table created...<br />";
        Yii::$app->response->redirect(['/site/index']);
    }

    private function rbacInit($adminId)
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();
        // Доступ к админке
        $adminDashboard = $auth->getPermission('adminDashboard');
        if (!$adminDashboard) {
            $adminDashboard = $auth->createPermission('adminDashboard');
        }
        $auth->add($adminDashboard);

        // Просмотр проекта
        $viewProjectRule = new ViewProjectRule();
        $auth->add($viewProjectRule);

        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'View project';
        $viewProject->ruleName = $viewProjectRule->name;
        $auth->add($viewProject);

        // Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);

        $reporter = $auth->createRole('reporter');
        $reporter->description = 'Репортер';
        $auth->add($reporter);

        $developer = $auth->createRole('developer');
        $developer->description = 'Программист';
        $auth->add($developer);

        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $auth->add($manager);

        $admin = $auth->createRole('admin');
        $admin->description = 'Админ';
        $auth->add($admin);

        // Связываем роли
        $auth->addChild($reporter, $user);
        $auth->addChild($developer, $reporter);
        $auth->addChild($manager, $developer);
        $auth->addChild($admin, $manager);

        // Назначаем доступы
        $auth->addChild($user, $viewProject);
        $auth->addChild($admin, $adminDashboard);

        $role = $auth->getRole(User::ROLE_ADMIN);
        $auth->assign($role, $adminId);
    }

    private function settingsInit($userId)
    {
        $settingsArray = [
            'app_name' => 'YiiMine',
            'app_description' => 'Project Management System YiiMine welcomes you!',
            'app_logo' => 'default_logo.png',
        ];

        foreach ($settingsArray as $key => $value) {
            \Yii::$app->db->createCommand('INSERT INTO settings(`key`, `value`, user_id) VALUES (:k, :v, :uId)', [
                ':k' => $key,
                ':v' => $value,
                ':uId' => (int)$userId,
            ])->execute();
        }
    }

    /**
     * @return User
     */
    private function userInit()
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->setPassword('admin');
        $user->first_name = 'admin';
        $user->last_name = 'admin';
        $user->generateAuthKey();
        if ($user->save()) {
            $this->rbacInit($user->id);
            return $user;
        } else {
            die(var_dump($user->getErrors()));
        }
    }
}