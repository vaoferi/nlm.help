<?php

use yii\db\Schema;
use common\rbac\Migration;
use common\models\User;

class m190403_100237_revoke_manager_user extends Migration
{
    public function up()
    {
        $managerIds = $this->auth->getUserIdsByRole(User::ROLE_MANAGER);
        $admin = $this->auth->getRole(User::ROLE_ADMINISTRATOR);
        $author = $this->auth->getRole(User::ROLE_AUTHOR);
        $editor = $this->auth->getRole(User::ROLE_EDITOR);
        $translator = $this->auth->getRole(User::ROLE_TRANSLATOR);
        $this->auth->addChild($admin, $author);
        $this->auth->addChild($admin, $editor);
        $this->auth->addChild($admin, $translator);

        $manager = $this->auth->getRole(User::ROLE_MANAGER);
        $login = $this->auth->getPermission('loginToBackend');
        $user = $this->auth->getRole(User::ROLE_USER);
        $this->auth->removeChild($manager, $author);
        $this->auth->removeChild($manager, $editor);
        $this->auth->removeChild($manager, $login);
        $this->auth->removeChild($manager, $translator);
        $this->auth->removeChild($manager, $user);
        $this->auth->removeChild($admin, $manager);

        if (!empty($managerIds))  {
            foreach ($managerIds as $managerId) {
                 $this->auth->assign($admin, $managerId);
                 $this->auth->revoke($manager, $managerId);
            }
        }

        $this->auth->remove($manager);
        $usersId = $this->auth->getUserIdsByRole(User::ROLE_USER);

        if (!empty($usersId)) {
            $userObjects = User::findAll(['id' => $usersId]);
            foreach ($userObjects as $userObject) {
                $userObject->delete();
            }
        }
        $this->auth->remove($user);
    }

    public function down()
    {
        $manager = $this->auth->createRole(User::ROLE_MANAGER);
        $this->auth->add($manager);
        $user = $this->auth->createRole(User::ROLE_USER);
        $this->auth->add($user);
        $this->auth->addChild($manager, $user);

        $admin = $this->auth->getRole(User::ROLE_ADMINISTRATOR);
        $this->auth->addChild($admin, $manager);
        $this->auth->addChild($admin, $user);
        $login = $this->auth->getPermission('loginToBackend');
        $this->auth->addChild($manager, $login);
    }
}
