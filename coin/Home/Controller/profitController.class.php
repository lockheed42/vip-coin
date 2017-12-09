<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/9
 * Time: 下午4:54
 */

namespace Home\Controller;

use Home\Common\CommonController;

class ProfitController extends CommonController
{
    /**
     * @api            {get} /?c=profit&a=index [收益首页]
     * @apiDescription 收益首页
     * @apiName        index
     * @apiGroup       profit
     *
     * @apiSuccess {string} profit 昨日收益额度
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"profit":"1234"}}
     *
     * @apiVersion     1.0.0
     */
    public function index()
    {
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                'profit' => '1234',
            ],
        ];
        echo json_encode($a);
    }

    /**
     * @api            {get} /?c=profit&a=log [收益明细]
     * @apiDescription 收益明细
     * @apiName        log
     * @apiGroup       profit
     *
     * @apiSuccess {string} date 日期
     * @apiSuccess {string} profit 收益额
     * @apiSuccess {string} status 状态。1=已兑现，0=未兑现
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"date":"2017-10-14","profit":"1020","status":"0"},{"date":"2017-10-13","profit":"1020","status":"1"},{"date":"2017-10-12","profit":"1020","status":"1"}]}
     *
     * @apiVersion     1.0.0
     */
    public function log()
    {
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                [
                    'date'   => '2017-10-14',
                    'profit' => '1020',
                    'status' => '0',
                ],
                [
                    'date'   => '2017-10-13',
                    'profit' => '1020',
                    'status' => '1',
                ],
                [
                    'date'   => '2017-10-12',
                    'profit' => '1020',
                    'status' => '1',
                ],
            ],
        ];
        echo json_encode($a);
    }
}