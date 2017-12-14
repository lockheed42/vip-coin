<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/10
 * Time: 下午8:27
 */

namespace Home\Controller;

use Home\Common\CommonController;
use Think\Exception;

class SmsController extends CommonController
{
    protected $dev_id;
    protected $key;
    protected $url;

    /**
     * 发送成功装填码
     */
    const CODE_SUCCESS = 25010;

    public function __construct()
    {
        /**
         * 信信客短信 http://www.xinxinke.com/api
         */
        $this->dev_id = '049bf89d262a4d1db176fd7d1a8b6c58';
        $this->key = 'a2999ddff1d748cbbd838824541624f1';
        $this->url = 'http://www.xinxinke.com/api/send';
    }

    /**
     * 发送短信
     *
     * @param int    $mobile  手机号
     * @param string $tmpCode 模板代码。用于区分短信模板，具体设置见 http://www.xinxinke.com/api
     * @param array  $param   模板参数
     *
     * @throws Exception
     */
    public function send($mobile, $tmpCode, $param)
    {
        $sign = md5($this->dev_id . $this->key . $mobile);
        $param = json_encode($param);

        $para = "dev_id={$this->dev_id}";
        $para .= "&sign={$sign}";
        $para .= "&sms_template_code={$tmpCode}";
        $para .= "&rec_num={$mobile}";
        $para .= "&sms_param={$param}";

        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $para);
        $res = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($res, true);
        if (!isset($res['code']) || $res['code'] != self::CODE_SUCCESS) {
            throw new Exception($res['code']);
        }
    }
}