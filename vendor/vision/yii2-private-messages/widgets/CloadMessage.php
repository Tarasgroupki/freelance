<?php
/**
 * Created by PhpStorm.
 * User: VisioN
 * Date: 26.08.2015
 * Time: 10:43
 */

namespace vision\messages\widgets;

use Yii;
use vision\messages\assets\CloadAsset;
use yii\helpers\Html;
use common\models\User;


class CloadMessage extends PrivateMessageWidget {

    //const RULE_CUSTOMER = 'findCustomer';
	//const RULE_PERFOMER = 'findPerfomer';
    //public $order_id;
	//public $user_id;
	public $headLabel = 'Message';


    public function run(){
        $this->assetJS();
        $this->html = '<div id="' . $this->uniq_id . '" class="main-message-container message-layout clearfix">';
        $this->html .= '<div class="message-north right-column message">';
        $this->html .= $this->getHead();
        $this->html .= $this->getBoxMessages();
        $this->html .=  $this->getListUsers();
        $this->html .= '</div></div>';
        return $this->html;
    }


    protected function getListUsers() {
		if(Yii::$app->user->can('customer')):
		$users = Yii::$app->db->createCommand("SELECT `id` FROM `orders` INNER JOIN `user` ON `user`.`username` = `orders`.`from` WHERE `orders`.`user_id` = ".Yii::$app->user->id ."")->queryAll();
		elseif(Yii::$app->user->can('performer')):
		$users = Yii::$app->db->createCommand("SELECT `user_id` AS `id` FROM `orders` INNER JOIN `user` ON `user`.`username` = `orders`.`from` WHERE `orders`.`from` = '".Yii::$app->user->identity['username']."'")->queryAll();
		endif;
		//print_r($users);die;
		//$users = Yii::$app->db->createCommand("SELECT `from` FROM `orders` WHERE order_id = ".$this->order_id ."")->queryAll();
		foreach($users as $key => $id):
	    $users[$key] = $id['id'];	
		endforeach;
		$users = \Yii::$app->mymessages->getAllUsers($users);
		$html = '<div class="list_users message-user-list friends-message-layout">';
        $html .= '<div id="scrollbar3">
		 	<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
			<div class="viewport">
			<div class="overview">';

        foreach($users as $usr) {
            $username = trim($usr[\Yii::$app->mymessages->attributeNameUser]);
            $names = explode(' ', $username);
            $html .= '<div class="contact friends" data-name="' . $username . '" data-user="' . $usr['id'] . '">';

            $html .= '<button class="delete-friend">&times;</button>';

            $html .= '<span class="counter-message" style="display:' . ($usr['cnt_mess'] > 0 ? 'block' : 'none') . '">';
            if($usr['cnt_mess']){
                $html .=  $usr['cnt_mess'];
            }
            $html .= '</span>';
            $img = \Yii::$app->mymessages->createLogo($usr['id']);
            if($img) {
                $html .= '<div class="friends-block">';
                $html .=  $img;
                $html .= '</div>';
            }

            $html .= '<div class="friends-name">';

            $html .= array_reduce($names, function($pre, $val) {
                return $pre . "<div>$val</div>";
            });
            $html .= "</div></div>";
        }

        $html .= '</div></div></div></div>';
        return $html;
    }


    protected function getBoxMessages() {
        $html = '';
        $html .= '<div class="message-thread message-wrapper clearfix">';
        $html .= '<div id="scrollbar1">';
        $html .= '<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>';
        $html .= '<div class="viewport"><div class="overview message-container">';
        $html .= '</div></div></div>';
        $html .= $this->getFormInput();
        $html .= '</div>';
        return $html;
    }


    protected function getFormInput() {
        $html = '<div class="message-south create-message"><form action="#" class="message-form" method="POST">';
        $html .= '<textarea class="textarea-layout" disabled="true" name="input_message"></textarea>';
        $html .= '<input type="hidden" name="message_id_user" value="">';
        $html .= '<button class="send-message" type="submit">' . $this->buttonName . '</button>';
        $html .= '</form></div>';
        return $html;
    }


    protected function getHead() {
        $html = '<div class="right-layout">';
        $html .= '<div class="separate"></div>';
        $html .= '<div class="layout-background clearfix">';
        $html .= '<div class="dialogue">' . $this->headLabel . '</div>';
        $html .= '<div class="message-layout-search">';
        $html .= '<form><div class="search">';
        $html .= '<input type="search">';
        $html .= '<input type="submit" disabled="disabled" value="">';
        $html .= '</div></form></div></div></div>';
        return $html;
    }


    protected function assetJS() {
        CloadAsset::register($this->view);
        $this->addJs();
    }


}