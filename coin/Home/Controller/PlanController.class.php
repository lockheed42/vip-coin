<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/9
 * Time: 下午3:54
 */

namespace Home\Controller;

use Home\Common\CommonController;

class PlanController extends CommonController
{
    /**
     * @api            {get} /?c=plan&a=all [发行计划列表]
     * @apiDescription 发行计划列表
     * @apiName        all
     * @apiGroup       plan
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} profit 预计总收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} total 总算力
     * @apiSuccess {string} sell 已售部分
     * @apiSuccess {string} status 状态。1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"name":"\u53d1\u7535\u7ad9","profit":"2300000","begin":"2017-07-23","end":"2018-03-23","total":"80000","sell":"34985","status":"1"},{"name":"\u5927\u578b\u8ba1\u5212","profit":"3230000","begin":"2017-07-23","end":"2018-03-23","total":"880000","sell":"34985","status":"2"},{"name":"\u5b63\u5b63\u53d1","profit":"80000","begin":"2017-07-23","end":"2018-03-23","total":"380000","sell":"34985","status":"3"}]}
     *
     * @apiVersion     1.0.0
     */
    public function all()
    {
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                [
                    'plan_id' => 1,
                    'name'    => '发电站',
                    'profit'  => '2300000',
                    'begin'   => '2017-07-23',
                    'end'     => '2018-03-23',
                    'total'   => '80000',
                    'sell'    => '34985',
                    'status'  => '1',
                ],
                [
                    'plan_id' => 2,
                    'name'    => '大型计划',
                    'profit'  => '3230000',
                    'begin'   => '2017-07-23',
                    'end'     => '2018-03-23',
                    'total'   => '880000',
                    'sell'    => '34985',
                    'status'  => '2',
                ],
                [
                    'plan_id' => 3,
                    'name'    => '季季发',
                    'profit'  => '80000',
                    'begin'   => '2017-07-23',
                    'end'     => '2018-03-23',
                    'total'   => '380000',
                    'sell'    => '34985',
                    'status'  => '3',
                ],
            ]
        ];
        echo json_encode($a);
    }

    /**
     * @api            {get} /?c=plan&a=detail [发行计划详情]
     * @apiDescription 详情
     * @apiName        detail
     * @apiGroup       plan
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} desc 计划详情
     * @apiSuccess {string} profit 预计总收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} total 总算力
     * @apiSuccess {string} sell 已售部分
     * @apiSuccess {string} status 状态。1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"name":"\u53d1\u7535\u7ad9","desc":"\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5\u8fd9\u662f\u8ba1\u5212\u8be6\u60c5","profit":"2300000","begin":"2017-07-23","end":"2018-03-23","total":"80000","sell":"34985","status":"1"}}
     *
     * @apiVersion     1.0.0
     */
    public function detail()
    {
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                'plan_id' => 1,
                'name'    => '发电站',
                'desc'    => '这是计划详情这是计划详情这是计划详情这是计划详情这是计划详情这是计划详情这是计划详情这是计划详情',
                'profit'  => '2300000',
                'begin'   => '2017-07-23',
                'end'     => '2018-03-23',
                'total'   => '80000',
                'sell'    => '34985',
                'status'  => '1',
            ],
        ];
        echo json_encode($a);
    }

    /**
     * @api            {get} /?c=plan&a=contract [查看合同]
     * @apiDescription 查看合同
     * @apiName        contract
     * @apiGroup       plan
     *
     * @apiParam {string} plan_id 计划id
     *
     * @apiSuccess {string} url 合同地址列表
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":{"url":["http:xxxx.com\/aaa.jpg","http:xxxx.com\/b.jpg"]}}
     *
     * @apiVersion     1.0.0
     */
    public function contract()
    {
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                'url' => [
                    'http:xxxx.com/aaa.jpg',
                    'http:xxxx.com/b.jpg',
                ],
            ],
        ];
        echo json_encode($a);
    }

    /**
     * @api            {post} /?c=plan&a=buy [提交购买单]
     * @apiDescription 提交购买单
     * @apiName        buy
     * @apiGroup       plan
     *
     * @apiParam {string} plan_id 计划id
     * @apiParam {string} count 购买数量
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":true}
     *
     * @apiVersion     1.0.0
     */
    public function buy()
    {

    }
}