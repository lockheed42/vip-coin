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

class UserController extends CommonController
{
    /**
     * @api            {post} /?c=user&a=logout [用户退出]
     * @apiDescription 用户推出
     * @apiName        logout
     * @apiGroup       user
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function logout()
    {
        try {
            $this->checkLogin();

            M('user')->where(['user_id' => $this->_user_id])->save(['api_security' => '']);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {get} /?c=user&a=info [个人信息]
     * @apiDescription 登录
     * @apiName        info
     * @apiGroup       user
     *
     * @apiSuccess {string} name 姓名
     * @apiSuccess {string} sex 性别
     * @apiSuccess {string} id_card 身份证
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"name":"\u8def\u4eba\u7532","sex":"\u7537","id_card":"310104197704240051"}}
     *
     * @apiVersion     1.0.0
     */
    public function info()
    {
        try {
            $this->checkLogin();

            $user = M('user')->where(['user_id' => $this->_user_id])->find();

            $data = [
                'name'    => $user['name'],
                'sex'     => $user['sex'] == 1 ? '男' : '女',
                'id_card' => '***************' . substr($user['idcard'], -4),
            ];

            $this->success($data);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }

    }

    /**
     * @api            {post} /?c=user&a=saveName [保存姓名]
     * @apiDescription 登录
     * @apiName        saveName
     * @apiGroup       user
     *
     * @apiParam {string} name 姓名
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function saveName()
    {
        $name = I('post.name');

        try {
            $this->checkLogin();

            M('user')->where(['user_id' => $this->_user_id])->save(['name' => $name]);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {post} /?c=user&a=saveSex [保存性别]
     * @apiDescription 登录
     * @apiName        saveSex
     * @apiGroup       user
     *
     * @apiParam {string} sex 性别。男=1，女=2
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function saveSex()
    {
        $sex = I('post.sex');

        try {
            $this->checkLogin();

            M('user')->where(['user_id' => $this->_user_id])->save(['sex' => $sex]);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {post} /?c=user&a=saveIdCard [保存身份证]
     * @apiDescription 登录
     * @apiName        saveIdCard
     * @apiGroup       user
     *
     * @apiParam {string} id_card 身份证号
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function saveIdCard()
    {
        $idCard = I('post.id_card');

        try {
            $this->checkLogin();

            M('user')->where(['user_id' => $this->_user_id])->save(['idcard' => $idCard]);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {post} /?c=user&a=changePwd [修改密码]
     * @apiDescription 修改密码
     * @apiName        changePwd
     * @apiGroup       user
     *
     * @apiParam {string} pwd 新密码
     * @apiParam {string} verify 验证码
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function changePwd()
    {
        $pwd = I('post.pwd');
        $verify = I('post.verify');

        try {
            $this->checkLogin();

            if (empty($pwd)) {
                throw new Exception('密码不能为空');
            }

            $user = M('user')->where(['user_id' => $this->_user_id])->find();

            $verifyCtl = new VerifyController();
            $verifyCtl->check($user['account'], $verify);

            M('user')->where(['user_id' => $this->_user_id])->save(['pwd' => md5($pwd)]);

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {post} /?c=user&a=bindCard [绑定银行卡]
     * @apiDescription 绑定银行卡
     * @apiName        bindCard
     * @apiGroup       user
     *
     * @apiParam {string} name 姓名
     * @apiParam {string} code 银行卡号
     * @apiParam {string} bank 银行名称
     * @apiParam {string} mobile 银行预留手机号
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function bindCard()
    {
        $name = I('post.name');
        $code = I('post.code');
        $bank = I('post.bank');
        $mobile = I('post.mobile');

        try {
            $this->checkLogin();

            if (empty($name)) {
                throw new Exception('请填写银行卡上的姓名');
            }
            if (empty($code)) {
                throw new Exception('请填写银行卡号');
            }
            if (empty($bank)) {
                throw new Exception('请填写所属银行');
            }
            if (empty($mobile)) {
                throw new Exception('请填写银行预留手机号码');
            }

            $bankInfo = M('bank_account')->where(['user_id' => $this->_user_id])->find();
            if (!empty($bankInfo)) {
                throw new Exception('已绑定银行卡');
            }

            M('bank_account')->add(
                [
                    'user_id'   => $this->_user_id,
                    'bank_name' => $bank,
                    'user_name' => $name,
                    'code'      => $code,
                    "mobile"    => $mobile,
                    'cdate'     => date('Y-m-d H:i:s', time()),
                ]
            );

            $this->success(true);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {get} /?c=user&a=getCard [获取银行卡信息]
     * @apiDescription 获取银行卡信息
     * @apiName        getCard
     * @apiGroup       user
     *
     * @apiSuccess {string} bank 银行名称
     * @apiSuccess {string} code 卡号
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"bank":"\u5149\u5927\u94f6\u884c","code":"345349402342308"}}
     *
     * @apiVersion     1.0.0
     */
    public function getCard()
    {
        try {
            $this->checkLogin();

            $bankInfo = M('bank_account')->where(['user_id' => $this->_user_id])->find();

            $this->success(
                [
                    'bank' => $bankInfo['bank_name'],
                    'code' => $bankInfo['code'],
                ]
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * 检测用户是否有参与标的的权限。
     *
     * @param $userId
     *
     * @throws Exception
     */
    public function checkUserAuth($userId)
    {
        $userInfo = M('user')->where(['user_id' => $userId])->find();
        if ($userInfo['name'] == '') {
            throw new Exception('未填写真实姓名');
        }
        if ($userInfo['idcard'] == '') {
            throw new Exception('未填写身份证号码');
        }

        $bankAccount = M('bank_account')->where(['user_id' => $userId])->find();
        if (empty($bankAccount)) {
            throw new Exception('未绑定银行卡');
        }
    }
}