<?php
namespace backend\controllers;
use yii\web\Controller;
use Yii;
use common\helps\wechattool;
use EasyWeChat\Payment\Order;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Signusers;
/**
 *@FILENAME:InfoController;
 *@AUTHOR:dudongjiang;
 *@DATE:2016年11月2日;
 *@EFFORT:微信支付;
 **/
class RechargeController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['wechatpay'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                     
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     *@FUNCNAME:actionWechatpay;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:处理支付;
     **/
    public function actionWechatpay(){
        if(Yii::$app->request->isPost){
            $trade_type = Yii::$app->request->post("trade_type");
            $out_trade_no = Yii::$app->request->post("out_trade_no");
            $total_fee = Yii::$app->request->post("total_fee");
            if(!$trade_type || !$out_trade_no || !$total_fee){
                $data = [
                    'code' => -1,
                    'message' => '数据有误',
                ];
                return Json::encode($data);
            }
            $product = [
                'trade_type'       => $trade_type, // 微信公众号支付填JSAPI
                'body'             => '红迷会报名预约',
                'detail'           => '红迷会报名预约',
                'out_trade_no'     => $out_trade_no, // 这是自己ERP系统里的订单ID，不重复就行。
                'total_fee'        => $total_fee, // 金额，这里的8888分人民币。单位只能是分。
                'notify_url'       => 'http://localhost/yii2/backend/web/recharge/order_notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                // ...  基本上这些参数就够了，或者参考微信文档自行添加删除。
            ];
            $order = new Order($product);
            $res = wechattool::wechat();
            $payment = $res->payment;
            $result = $payment->getAPI()->prepare($order);
            if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                $data['prepayId'] = $result->prepay_id;
                $data['out_trade_no'] = $out_trade_no;
                //修改数据
                Signusers::saveprepayId($out_trade_no,$data);
                $data = [
                    'code' => 1,
                    'message' => '订单支付成功',
                    'data' => $data
                ];
                return Json::encode($data);
            }else{
                $data = [
                    'code' => -1,
                    'message' => '订单支付失败！原因：'.$result->return_msg,
                ];
                return Json::encode($data);
            }
        }else{
            $data = [
                'code' => -1,
                'message' => '数据提交方式有误',
            ];
            return Json::encode($data);
        }
    }
    /**
     *@FUNCNAME:actionOrder_notify;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:订单异步通知;
     **/
    public function actionOrder_notify(){
        $res = wechattool::wechat();
        //$notify 为封装了通知信息的 EasyWeChat\Support\Collection 对象，前面已经讲过这里就不赘述了，你可以以对象或者数组形式来读取通知内容，比如：$notify->total_fee 或者 $notify['total_fee']。
        $response = $res->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = self::actionOrderquery($notify->out_trade_no);
            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->add_time) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                //$order->paid_at = time(); // 更新支付时间为当前时间
                //订单状态
                $order->status = '已支付';
                //微信的订单号
                $order->wx_order = $notify->transaction_id;
            } else { // 用户支付失败
                $order->status = '支付失败';
            }
            $order->save(); // 保存订单
            return true; // 返回处理完成
        });
        return $response;
    }
    /**
     *@FUNCNAME:actionOrderquery;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:订单查询;
     **/
    public function actionOrderquery($trade_out_no){
        $res = Signusers::findByOrder();
        if($res){
            return true;
        }else{
            return false;
        }
    }
}