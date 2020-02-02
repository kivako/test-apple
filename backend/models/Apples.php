<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property string $date_create
 * @property string|null $color
 * @property int|null $body_percent
 * @property string|null $status
 * @property string $date_fall
 * @property string $date_up
 */
class Apples extends \yii\db\ActiveRecord
{
    const COLOR_RED = 'LightCoral';
    const COLOR_GREEN = 'LightGreen';
    const COLOR_BLUE = 'LightBlue';
    const COLOR_YELLOW = 'LightYellow';
    const COLOR_GRAY = 'LightGray';

    const COLORS = [
            self::COLOR_RED => 'Красный',
            self::COLOR_GREEN => 'Зеленый',
            self::COLOR_BLUE => 'Голубой',
            self::COLOR_YELLOW => 'Желтый',
            self::COLOR_GRAY => 'Серый'
        ];

    const STATUS_ON_TREE = 'ontree';
    const STATUS_ON_GROUND = 'onground';
    const STATUS_ON_UP = 'onup';
    const STATUS_ROTTEN = 'rotten';

    const STATUSES = [
            self::STATUS_ON_TREE => 'На дереве',
            self::STATUS_ON_GROUND => 'На земле',
            self::STATUS_ON_UP => 'Поднято',
            self::STATUS_ROTTEN => 'Гнилое'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apples';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'date_fall' ,'date_up','body_percent', 'color', 'status'], 'safe'],
            //[['body_percent'], 'integer'],
            //[['color', 'status'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_create' => 'Дата создания',
            'color' => 'Цвет',
            'body_percent' => 'Размер тела',
            'status' => 'Статус',
            'date_fall' => 'Дата падения',
            'date_up' => 'Дата поднятия'
        ];
    }

    public static function createByRandom() {


        $obj = new Apples();
        $obj->date_create = date('Y-m-d H:i:s', rand( strtotime("-1 day"), strtotime("now")));

        $color_keys = array_keys(self::COLORS);
        $obj->color = $color_keys[rand(0,count($color_keys)-1)];

        $status_keys = array_keys(self::STATUSES);
        $obj->status = $status_keys[rand(0,count($status_keys)-1)];

        if (!($obj->status == self::STATUS_ON_TREE))
            $obj->date_fall = date('Y-m-d H:i:s', rand( strtotime($obj->date_create), strtotime("now")));

        if ($obj->status == self::STATUS_ON_UP){
            $obj->body_percent = rand(1,100);
            $obj->date_up = date('Y-m-d H:i:s', rand( strtotime($obj->date_fall), strtotime("now")));
        }

        return $obj;
    }
}
