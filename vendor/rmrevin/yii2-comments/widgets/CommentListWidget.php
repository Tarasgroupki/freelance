<?php
/**
 * CommentListWidget.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\widgets;

use Yii;
use rmrevin\yii\module\Comments;
use yii\helpers\Html;

/**
 * Class CommentListWidget
 * @package rmrevin\yii\module\Comments\widgets
 */
class CommentListWidget extends \yii\base\Widget
{

    /** @var string|null */
    public $theme;

    /** @var string */
    public $viewFile = 'comment-list';

    /** @var array */
    public $viewParams = [];

    /** @var array */
    public $options = ['class' => 'comments-widget'];

    /** @var string */
    public $entity;

	/**@var int */
	public $item_id;
	
	/**@var int */
	public $user_id;
	
	/**@var int */
	public $price;
	
	/** @var string */
	public $type_id;
	
    /** @var string */
    public $anchorAfterUpdate = '#comment-%d';

    /** @var array */
    public $pagination = [
        'pageParam' => 'page',
        'pageSizeParam' => 'per-page',
        'pageSize' => 20,
        'pageSizeLimit' => [1, 50],
    ];

    /** @var array */
    public $sort = [
        'defaultOrder' => [
            'id' => SORT_ASC,
        ],
    ];

    /** @var bool */
    public $showDeleted = true;

    /** @var bool */
    public $showCreateForm = true;

    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * Register asset bundle
     */
    protected function registerAssets()
    {
        CommentListAsset::register($this->getView());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();

        $this->processDelete();

		$this->proccessChange();
        /** @var Comments\models\Comment $CommentModel */
        $CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));
        if($this->type_id == 1):
		$CommentsQuery = $CommentModel::find()
            ->byEntity($this->entity)->where(['item_id' => $this->item_id])->andWhere(['type_id' => $this->type_id]);
        //print_r($CommentsQuery);die;
		else:
		$CommentsQuery = $CommentModel::find()->select('*')->RightJoin('rating', 'comment.created_by = rating.target_id && comment.item_id = rating.model_id')
            ->byEntity($this->entity)->where(['comment.item_id' => $this->user_id])->andWhere(['>','comment.type_id',1]);
		//print_r($CommentsQuery);die;
		endif;
		if (false === $this->showDeleted) {
            $CommentsQuery->withoutDeleted();
        }

        $CommentsDataProvider = \Yii::createObject([
            'class' => \yii\data\ActiveDataProvider::className(),
            'query' => $CommentsQuery->with(['author', 'lastUpdateAuthor']),
            'pagination' => $this->pagination,
            //'sort' => $this->sort,
        ]);
//print_r($CommentsDataProvider);die;
        $params = $this->viewParams;
        $params['CommentsDataProvider'] = $CommentsDataProvider;

        $content = $this->render($this->viewFile, $params);

        return Html::tag('div', $content, $this->options);
    }

    private function processDelete()
    {
        $delete = (int)\Yii::$app->getRequest()->get('delete-comment');
        if ($delete > 0) {

            /** @var Comments\models\Comment $CommentModel */
            $CommentModel = \Yii::createObject(Comments\Module::instance()->model('comment'));

            /** @var Comments\models\Comment $Comment */
            $Comment = $CommentModel::find()
                ->byId($delete)
                ->one();

            if ($Comment->isDeleted()) {
                return;
            }

            if (!($Comment instanceof Comments\models\Comment)) {
                throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'Comment not found.'));
            }

            if (!$Comment->canDelete()) {
                throw new \yii\web\ForbiddenHttpException(\Yii::t('app', 'Access Denied.'));
            }

            $Comment->deleted = $CommentModel::DELETED;
            $Comment->update();
        }
    }
	private function proccessChange()
	{
		$change = (string)\Yii::$app->getRequest()->get('change-performer');
		
		if($change != null)
		{
			Yii::$app->db->createCommand()
			->update('orders', ['from' => $change], 'order_id ='.(int)\Yii::$app->getRequest()->get('item-id').'')
			->execute();
		}
	}

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        return empty($this->theme)
            ? parent::getViewPath()
            : (\Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme);
    }
}
