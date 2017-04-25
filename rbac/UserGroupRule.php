<?php
/**
 * Created by PhpStorm.
 * User: sancho
 * Date: 24.04.17
 * Time: 16:51
 */

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest):
            //$group = Yii::$app->user->identity->group;
            if ($item->name === 'admin'):
                return $item->name == 'admin';
            elseif ($item->name === 'admin2'):
                return $item->name == 'admin' || $item->name == 'admin2';
            endif;
        endif;
        return false;
    }
}