<?use rmrevin\yii\module\Comments;
use yii\helpers\Html;;
?>
<?
echo Html::img($avatar['avatar']);
echo '<h1>'.$likes['username'].'</h1><br />';
//if():
echo '<h1><b>Виконані проекти:</b></h1>';
foreach($items as $key => $item){
	echo '<a href=http://'.$item['link'].'><img style="width:200px;height:150px;" src='.$item['img_url'].'></a>';
}
echo Comments\widgets\CommentListWidget::widget([
    'entity' => (string) 'photo-15', // type and id
	'item_id' => (int)$id,
	'type_id' => (int)$type_id,
	'user_id' => (int)$id
]);
echo \chiliec\vote\widgets\Vote::widget([
    'model' => $likes,
    'showAggregateRating' => true
]);
//endif;?>