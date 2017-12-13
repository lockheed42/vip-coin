<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午2:58
 */

namespace Home\Controller;

use Home\Common\CommonController;
use Think\Exception;

class LoginController extends CommonController
{
    /**
     * api key长度
     */
    const KEY_LENGTH = 15;
    /**
     * security长度
     */
    const SECURITY_LENGTH = 25;
    /**
     * 用户登录
     */
    const IS_LOGIN = 0;
    /**
     * 用户注册
     */
    const IS_REG = 1;

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
     * @apiSuccess {string} api_key key
     * @apiSuccess {string} api_security security
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"api_key":"42gs8sdfds","api_security":"dsadn3roisdf"}}
     *
     * @apiVersion     1.0.0
     */
    public function register()
    {
        $mobile = I('post.mobile');
        $verify = I('post.verify');
        $pwd = I('post.pwd');

        try {
            $verifyCtl = new VerifyController();
            $verifyCtl->check($mobile, $verify);

            $user = M('user')->where('account = %s', $mobile)->find();
            if (!empty($user)) {
                throw new Exception('该手机号已经注册');
            }

            $rand = new RandController();
            $key = $rand->createOneCode(self::KEY_LENGTH);
            $connectWord = $rand->createOneCode(1, 1);
            $timeString = $this->_numToWord(time());
            $apiKey = $key . $connectWord . $timeString;
            $apiSecurity = $rand->createOneCode(self::SECURITY_LENGTH);

            M('user')->add(
                [
                    'account'      => $mobile,
                    'verify'       => $verify,
                    'pwd'          => md5($pwd),
                    'api_key'      => $apiKey,
                    'api_security' => $apiSecurity,
                    'cdate'        => date('Y-m-d H:i:s'),
                ]
            );

            $this->success(
                [
                    'api_key'      => $apiKey,
                    'api_security' => $apiSecurity,
                ]
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
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
     * @apiSuccess {string} api_key key
     * @apiSuccess {string} api_security security
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"api_key":"42gs8sdfds","api_security":"dsadn3roisdf"}}
     *
     * @apiVersion     1.0.0
     */
    public function login()
    {
        $mobile = I('post.mobile');
        $pwd = I('post.pwd');

        try {
            $info = M('user')->where(
                [
                    'account' => $mobile,
                    'pwd'     => md5($pwd),
                ]
            )->find();

            if (empty($info)) {
                throw new Exception('账号或者密码错误');
            }

            $rand = new RandController();
            $apiSecurity = $rand->createOneCode(self::SECURITY_LENGTH);
            M('user')
                ->where(['user_id' => $info['user_id']])
                ->save(['api_security' => $apiSecurity, 'udate' => date('Y-m-d H:i:s', time())]);

            $this->success(
                [
                    'api_key'      => $info['api_key'],
                    'api_security' => $apiSecurity,
                ]
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
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

        try {
            $verifyCtl = new VerifyController();
            $verifyCtl->check($mobile, $verify);

            $info = M('user')->where(['account' => $mobile])->find();
            if (empty($info)) {
                throw new Exception('用户不存在');
            }

            M('user')->where(['user_id' => $info['user_id']])->save(['pwd' => md5($pwd)]);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * 将时间戳修改成字符。
     *
     * @param int $timestamp 时间戳
     *
     * @return string
     */
    private function _numToWord($timestamp)
    {
        $example = 'cEIklNorTs';

        $len = strlen($timestamp);
        $return = '';
        for ($i = 0; $i < $len; $i++) {
            $return .= substr($example, substr($timestamp, $i, 1), 1);
        }

        return $return;
    }
}