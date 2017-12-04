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
    /**
     * 用户注册
     */
    public function register()
    {
        if (IS_POST) {
            $mobile = I('post.mobile');
            $verify = I('post.verify');
            $pwd = I('post.pwd');

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

                $this->setCookie($mobile, $pwd);

                $this->success('注册成功', 'Index/index');
            }
        } else {
            $this->display();
        }
    }

    public function login()
    {
        if (IS_AJAX) {
            $mobile = I('post.mobile');
            $pwd = I('post.pwd');

            $info = M('user')->where(
                [
                    'account' => $mobile,
                    'pwd'     => md5($pwd),
                ]
            )->select();

            if (!empty($info)) {
                $this->setCookie($mobile, $pwd);
            }
        } else {
            $this->display();
        }
    }

    public function forget($verify, $pwd)
    {
        $verify = I('post.verify');
        $pwd = I('post.pwd');
    }

    public function get()
    {
    }
}