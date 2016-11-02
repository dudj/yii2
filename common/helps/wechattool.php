<?php
namespace common\helps;
use EasyWeChat\Foundation\Application;
use Yii;
class wechattool{
    public function wechat(){
        $options = [
            // 前面的appid什么的也得保留哦
            'app_id' => 'wxa1ef57725e6a43a9',
            // payment
            'payment' => [
                'merchant_id'        => '1237177102',
                'key'                => 'Asdf147Qwer258Zxcv369GhjkTyuiBnm',
                'cert_path'          => Yii::$app->basePath.'/../common/wechatcert/apiclient_cert.pem', // XXX: 绝对路径！！！！
                'key_path'           => Yii::$app->basePath.'/../common/wechatcert/apiclient_key.pem',      // XXX: 绝对路径！！！！
                'notify_url'         => '默认的订单回调地址',       // 你也可以在下单时单独设置来想覆盖它
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
                // ...
            ],
        ];
        $app = new Application($options);
        return $app;
    }
}