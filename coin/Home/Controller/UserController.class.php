<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午2:58
 */

namespace Home\Controller;

use Home\Common\CommonController;

class UserController extends CommonController
{
    public function register()
    {
        $mobile = I('post.mobile');
        $verify = I('post.verify');
        $pwd = I('post.pwd');

        $mobile = I('get.mobile');
        $verify = I('get.verify');
        $pwd = I('get.pwd');

        $verifyCtl = new VerifyController();
        $rs = $verifyCtl->check($mobile, $verify);
        if ($rs === false) {
            $this->error('注册失败');
        } else {
            M('user')->add(
                [
                    'account' => $mobile,
                    'verify'  => $verify,
                    'pwd'     => md5($pwd),
                ]
            );

            $this->success('注册成功', 'Index/index');
        }
    }

    public function login($mobile, $pwd)
    {
        $mobile = I('post.mobile');
        $pwd = I('post.pwd');

        $info = M('user')->where(
            [
                'account' => $mobile,
                'pwd'     => md5($pwd),
            ]
        )->select();
    }

    public function forget($verify, $pwd)
    {

    }

    public function get()
    {
    }
}