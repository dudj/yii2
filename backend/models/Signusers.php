<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "signusers".
 *
 * @property integer $id
 * @property integer $sign_id
 * @property string $name
 * @property string $iphone
 * @property integer $session_userid
 * @property string $add_time
 * @property string $ziduan1
 * @property string $ziduan1_value
 * @property string $ziduan2
 * @property string $ziduan2_value
 * @property string $ziduan3
 * @property string $ziduan3_value
 * @property string $session_username
 * @property string $session_useriphone
 * @property string $is_jiaofei
 * @property double $jiaofei
 * @property string $order_number
 * @property integer $status
 * @property integer $result
 * @property string $wx_order
 * @property double $pay_jine
 * @property string $tuiding_time
 * @property string $shenhe_time
 */
class Signusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signusers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sign_id', 'name', 'iphone', 'session_userid', 'add_time', 'session_username', 'session_useriphone', 'is_jiaofei', 'order_number'], 'required'],
            [['sign_id', 'session_userid', 'status', 'result'], 'integer'],
            [['jiaofei', 'pay_jine'], 'number'],
            [['name', 'iphone', 'add_time', 'tuiding_time', 'shenhe_time'], 'string', 'max' => 20],
            [['ziduan1', 'ziduan1_value', 'ziduan2', 'ziduan2_value', 'ziduan3', 'ziduan3_value', 'wx_order'], 'string', 'max' => 200],
            [['session_username', 'session_useriphone', 'order_number'], 'string', 'max' => 100],
            [['is_jiaofei'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sign_id' => 'Sign ID',
            'name' => 'Name',
            'iphone' => 'Iphone',
            'session_userid' => 'Session Userid',
            'add_time' => 'Add Time',
            'ziduan1' => 'Ziduan1',
            'ziduan1_value' => 'Ziduan1 Value',
            'ziduan2' => 'Ziduan2',
            'ziduan2_value' => 'Ziduan2 Value',
            'ziduan3' => 'Ziduan3',
            'ziduan3_value' => 'Ziduan3 Value',
            'session_username' => 'Session Username',
            'session_useriphone' => 'Session Useriphone',
            'is_jiaofei' => 'Is Jiaofei',
            'jiaofei' => 'Jiaofei',
            'order_number' => 'Order Number',
            'status' => 'Status',
            'result' => 'Result',
            'wx_order' => 'Wx Order',
            'pay_jine' => 'Pay Jine',
            'tuiding_time' => 'Tuiding Time',
            'shenhe_time' => 'Shenhe Time',
        ];
    }
    /**
     *@FUNCNAME:findByOrder;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:根据订单查询订单号;
     **/
    public function findByOrder($order_numnber){
        $signusers = new Signusers();
        $res = $signusers->find()->where(["order_number"=>$order_numnber])->one();
        return $res;
    }
    /**
     *@FUNCNAME:saveprepayId;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月3日;
     *@EFFORT:保存微信唯一标识;
     **/
    public function saveprepayId($order_number,$data){
        $signusers = new Signusers();
        $res = $signusers->where(["order_number"=>$order_number])->save($data);
        return $res;
    }
}
