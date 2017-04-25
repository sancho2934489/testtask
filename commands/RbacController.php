<?php
/**
 * Created by PhpStorm.
 * User: sancho
 * Date: 24.04.17
 * Time: 16:46
 */

namespace app\commands;

use app\rbac\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * Init rules for RBAC
     */
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        $authManager->removeAll();

        $guest = $authManager->createRole('guest');
        $admin = $authManager->createRole('admin');
        $admin2 = $authManager->createRole('admin2');

        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $error  = $authManager->createPermission('error');
        $update = $authManager->createPermission('update');
        $create = $authManager->createPermission('create');
        $delete = $authManager->createPermission('delete');
        $time = $authManager->createPermission('time');
        $active = $authManager->createPermission('active');

        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($error);
        $authManager->add($update);
        $authManager->add($create);
        $authManager->add($delete);
        $authManager->add($active);
        $authManager->add($time);

        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        $guest->ruleName  = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;
        $admin2->ruleName  = $userGroupRule->name;

        $authManager->add($guest);
        $authManager->add($admin);
        $authManager->add($admin2);

        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $view);

        $authManager->addChild($admin,$guest);
        $authManager->addChild($admin,$view);
        $authManager->addChild($admin,$update);
        $authManager->addChild($admin, $index);
        $authManager->addChild($admin, $create);
        $authManager->addChild($admin, $time);
        $authManager->addChild($admin, $active);

        $authManager->addChild($admin2,$admin);
        $authManager->addChild($admin2, $delete);

        $authManager->assign($admin,100);
        $authManager->assign($admin2,101);
    }
}