<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午2:58
 */

namespace Home\Controller;

use Home\Common\CommonController;

class LoginController extends CommonController
{
    /**
     * @api            {post} /?c=login&a=register [注册]
     * @apiDescription 注册
     * @apiName        register
     * @apiGroup       login
     *
     * @apiParam {mobile} mobile 手机号码
     * @apiParam {string} verify 验证码
     * @apiParam {string} pwd 密码
     * @apiParam {string} pwd_sec 第二次密码
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function register()
    {
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
    }

    /**
     * @api            {post} /?c=login&a=login [登录]
     * @apiDescription 登录
     * @apiName        login
     * @apiGroup       login
     *
     * @apiParam {mobile} mobile 手机号码
     * @apiParam {string} pwd 密码
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function login()
    {
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
    }

    /**
     * @api            {post} /?c=login&a=forget [忘记密码]
     * @apiDescription 登录
     * @apiName        forget
     * @apiGroup       login
     *
     * @apiParam {mobile} mobile 手机号码
     * @apiParam {string} verify 验证码
     * @apiParam {string} pwd 密码
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function forget()
    {
        $mobile = I('post.mobile');
        $verify = I('post.verify');
        $pwd = I('post.pwd');
    }
}