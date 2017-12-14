<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午3:29
 */

namespace Home\Controller;


use Home\Common\CommonController;
use Think\Exception;

class VerifyController extends CommonController
{
    protected $_is_need_login = false;

    /**
     * 发送验证码的模板
     */
    const TEMP_CODE = 'cf9as46j9r9ggsdkg';

    /**
     * @api            {post} /?c=verify&a=send [发送短信]
     * @apiDescription 发送短信
     * @apiName        send
     * @apiGroup       verify
     *
     * @apiParam {mobile} mobile 手机号码
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function send()
    {
        $mobile = I('post.mobile');

        try {
            $code = $this->_generateVerifyCode();

            $param = ['code' => $code];
            $sms = new SmsController();
            $sms->send($mobile, self::TEMP_CODE, $param);

            M('message_verify')->add(
                [
                    'mobile' => $mobile,
                    'verify' => $code,
                    'cdate'  => date('Y-m-d H:i:s', time()),
                ]
            );
            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * 验证短信验证码是否有效。有效返回true。
     * 有效时间为10分钟
     *
     * @param $mobile
     * @param $verify
     *
     * @throws Exception
     */
    public function check($mobile, $verify)
    {
        $where = [
            'mobile' => $mobile,
            'verify' => $verify,
            'status' => 1,
        ];
        $info = M('message_verify')->where($where)->order(['id'=>'desc'])->find();
        if (empty($info)) {
            throw new Exception('验证码错误');
        }

        M('message_verify')->where(['id' => $info['id']])->save(['status' => 0]);
        if (strtotime($info['cdate']) < (time() - 600)) {
            throw new Exception('验证码超时');
        }
    }

    /**
     * 生成随机验证码
     *
     * @param int $length 验证码长度
     *
     * @return string
     */
    private function _generateVerifyCode($length = 6)
    {
        if ($length <= 0) {
            $length = 6;
        }

        $arr = range(0, 9);
        $return = '';
        for ($i = 0; $i < $length - 1; $i++) {
            $return .= array_rand($arr);
        }

        return mt_rand(1, 9) . $return;
    }
}