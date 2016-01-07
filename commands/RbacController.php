<?php
namespace app\commands;

use app\rbac\ViewProjectRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        // Доступ к админке
        $adminDashboard = $auth->createPermission('adminDashboard');
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

        $auth->assign($admin, 1);
    }
}