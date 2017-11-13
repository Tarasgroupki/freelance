<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;  
use \rmrevin\yii\module\Comments\Permission;
use \rmrevin\yii\module\Comments\rbac\ItsMyComment; 
//use rmrevin\yii\module\Comments\Permission;
//use rmrevin\yii\module\Comments\rbac\ItsMyComment;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {

$AuthManager = \Yii::$app->getAuthManager();
$ItsMyCommentRule = new ItsMyComment();

$AuthManager->add($ItsMyCommentRule);

$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::CREATE,
    'description' => 'Can create own comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::UPDATE,
    'description' => 'Can update all comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::UPDATE_OWN,
    'ruleName' => $ItsMyCommentRule->name,
    'description' => 'Can update own comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::DELETE,
    'description' => 'Can delete all comments',
]));
$AuthManager->add(new \yii\rbac\Permission([
    'name' => Permission::DELETE_OWN,
    'ruleName' => $ItsMyCommentRule->name,
    'description' => 'Can delete own comments',
]));
    }
}