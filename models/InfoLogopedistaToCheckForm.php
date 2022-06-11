<?php

namespace app\models;

use Yii;
use yii\base\Model;


class InfoLogopedistaToCheckForm extends Model
{
    public $motivo;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [
                'motivo', 
                'required',
                'message' => '{attribute} non può essere vuoto'
            ],
            //check motivo length
            [
              'motivo', 
              'string', 
              'max' => 255,
              'tooLong' => '{attribute} è troppo lungo'
            ],
        ];
    }

    
}
