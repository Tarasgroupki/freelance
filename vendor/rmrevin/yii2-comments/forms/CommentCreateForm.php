<?php
/**
 * CommentCreateForm.php
 * @author Revin Roman
 * @link https://rmrevin.ru
 */

namespace rmrevin\yii\module\Comments\forms;

use rmrevin\yii\module\Comments;

/**
 * Class CommentCreateForm
 * @package rmrevin\yii\module\Comments\forms
 */
class CommentCreateForm extends \yii\base\Model
{

    public $id;
    public $entity;
	public $item_id;
	public $type_id;
	public $user_id;
	public $price;
    public $from;
    public $text;

    /** @var Comments\models\Comment */
    public $Comment;

    public function init()
    {
        $Comment = $this->Comment;
        if (false === $this->Comment->isNewRecord) {
            $this->id = $Comment->id;
            $this->entity = $Comment->entity;
			$this->item_id = $Comment->item_id;
            $this->type_id = $Comment->type_id;
			$this->user_id = $Comment->user_id;
			$this->price = $Comment->price;
			$this->from = $Comment->from;
            $this->text = $Comment->text;
        } elseif (!\Yii::$app->getUser()->getIsGuest()) {
            $User = \Yii::$app->getUser()->getIdentity();

            $this->from = $User instanceof Comments\interfaces\CommentatorInterface
                ? $User->getCommentatorName()
                : null;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $CommentModelClassName = Comments\Module::instance()->model('comment');

        return [
            [['entity', 'text'], 'required'],
            [['entity','price','from', 'text'], 'string'],
            [['id','user_id','item_id','type_id'], 'integer'],
            [['id'], 'exist', 'targetClass' => $CommentModelClassName, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity' => \Yii::t('app', 'Entity'),
            'from' => \Yii::t('app', 'Your name'),
            'text' => \Yii::t('app', 'Text'),
        ];
    }

    /**
     * @return bool
     * @throws \yii\web\NotFoundHttpException
     */
    public function save()
    {
        $Comment = $this->Comment;

        $CommentModelClassName = Comments\Module::instance()->model('comment');

        if (empty($this->id)) {
            $Comment = \Yii::createObject($CommentModelClassName);
        } elseif ($this->id > 0 && $Comment->id !== $this->id) {
            /** @var Comments\models\Comment $CommentModel */
            $CommentModel = \Yii::createObject($CommentModelClassName);
            $Comment = $CommentModel::find()
                ->byId($this->id)
                ->one();

            if (!($Comment instanceof Comments\models\Comment)) {
                throw new \yii\web\NotFoundHttpException;
            }
        }

        $Comment->entity = $this->entity;
		$Comment->item_id = $this->item_id;
		$Comment->type_id = $this->type_id;
		$Comment->price = $this->price;
        $Comment->from = $this->from;
        $Comment->text = $this->text;

        $result = $Comment->save();

        if ($Comment->hasErrors()) {
            foreach ($Comment->getErrors() as $attribute => $messages) {
                foreach ($messages as $mes) {
                    $this->addError($attribute, $mes);
                }
            }
        }

        $this->Comment = $Comment;

        return $result;
    }
}
