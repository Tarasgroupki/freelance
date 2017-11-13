<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SearchLocation extends Model
{
    public $address;
    public $longitude;
    public $latitude;

	 public function rules()
    {
        return [
            ['address','string']			
        ];
    }
	
	public function GetAddress() 
	{
		return $this->address;
	}
}
