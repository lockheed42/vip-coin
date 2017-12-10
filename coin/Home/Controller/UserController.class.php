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
        M('user')->where('')->find();

        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                'name'    => '路人甲',
                'sex'     => '男',
                'id_card' => '310104197704240051',
            ],
        ];

        echo json_encode($a);
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
    }

    /**
     * @api            {post} /?c=user&a=saveSex [保存性别]
     * @apiDescription 登录
     * @apiName        saveSex
     * @apiGroup       user
     *
     * @apiParam {string} sex 性别
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function saveSex()
    {
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
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                'bank' => '光大银行',
                'code' => '345349402342308',
            ],
        ];

        echo json_encode($a);
    }
}