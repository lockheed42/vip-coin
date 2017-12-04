<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午3:29
 */

namespace Home\Controller;


use Home\Common\CommonController;

class VerifyController extends CommonController
{
    protected $_is_need_login = false;

    public function send()
    {
        $mobile = I('post.mobile');
        $verify = I('post.verify');

        //#TODO 调用发送

        M('message_verify')->add(
            [
                'mobile' => $mobile,
                'verify' => $verify,
                'cdate'  => date('Y-m-d H:i:s', time()),
            ]
        );
    }

    /**
     * 验证短信验证码是否有效。有效返回true。
     * 有效时间为10分钟
     *
     * @param $mobile
     * @param $verify
     *
     * @return bool
     */
    public function check($mobile, $verify)
    {
        $where = [
            'mobile' => $mobile,
            'verify' => $verify,
            'status' => 1,
        ];
        $info = M('message_verify')->where($where)->select();
        if (empty($info)) {
            return false;
        }

        M('message_verify')->where(['id' => $info[0]['id']])->save(['status' => 0]);
        if (strtotime($info[0]['cdate']) < (time() - 600)) {
            return false;
        }

        return true;
    }
}