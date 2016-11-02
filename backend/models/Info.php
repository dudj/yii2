<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "info".
 *
 * @property integer $id
 * @property string $name
 * @property string $tel
 * @property integer $creattime
 * @property integer $provinceid
 * @property integer $cityid
 * @property integer $distinctid
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tel'], 'required'],
            [['creattime', 'provinceid', 'cityid', 'distinctid'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['tel'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '用户名',
            'tel' => '手机号',
            'creattime' => '创建时间',
            'provinceid' => '省份',
            'cityid' => '城市',
            'distinctid' => '地区',
        ];
    }
}
