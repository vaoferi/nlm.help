<?php

use yii\db\Schema;
use common\models\User;
use common\rbac\Migration;

class m190328_162415_add_roles extends Migration
{
    public function up()
    {
        $manager = $this->auth->getRole(User::ROLE_MANAGER);
        $author = $this->auth->createRole(User::ROLE_AUTHOR);
        $this->auth->add($author);

        $editor = $this->auth->createRole(User::ROLE_EDITOR);
        $this->auth->add($editor);

        $translator = $this->auth->createRole(User::ROLE_TRANSLATOR);
        $this->auth->add($translator);

        $this->auth->addChild($manager, $editor);
        $this->auth->addChild($manager, $translator);
        $this->auth->addChild($manager, $author);
        $loginToBackend = $this->auth->getPermission('loginToBackend');
        $this->auth->addChild($author, $loginToBackend);
        $this->auth->addChild($editor, $loginToBackend);
        $this->auth->addChild($translator, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getRole(User::ROLE_AUTHOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_EDITOR));
        $this->auth->remove($this->auth->getRole(User::ROLE_TRANSLATOR));
    }
}
