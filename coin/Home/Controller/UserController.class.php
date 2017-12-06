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
}