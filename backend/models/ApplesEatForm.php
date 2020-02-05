<?php

namespace backend\models;

use yii\base\Model;

class ApplesEatForm extends Model
{
    public $percent;

    public function rules()
    {
        return [
            [['percent'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'percent' => 'Сколько процентов съесть',
        ];
    }
}

