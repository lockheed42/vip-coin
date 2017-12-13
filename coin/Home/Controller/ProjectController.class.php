<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/9
 * Time: 下午3:54
 */

namespace Home\Controller;

use Home\Common\CommonController;

class ProjectController extends CommonController
{
    /**
     * @api            {get} /?c=project&a=all [我的标的列表]
     * @apiDescription 发行计划列表
     * @apiName        all
     * @apiGroup       project
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} total_profit 预计总收益
     * @apiSuccess {string} get_profit 已收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} own 拥有算力
     * @apiSuccess {string} status 状态。1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"project_id":1,"name":"\u53d1\u7535\u7ad9","total_profit":"22300","get_profit":"2000","begin":"2017-07-23","end":"2018-03-23","total":"80000","own":"34985","status":"1"},{"project_id":2,"name":"\u5927\u578b\u8ba1\u5212","total_profit":"32300","get_profit":"23000","begin":"2017-07-23","end":"2018-03-23","total":"880000","own":"34985","status":"2"},{"project_id":3,"name":"\u5b63\u5b63\u53d1","total_profit":"8000","get_profit":"3000","begin":"2017-07-23","end":"2018-03-23","total":"380000","own":"34985","status":"3"}]}
     *
     * @apiVersion     1.0.0
     */
    public function all()
    {
        try {
            $this->checkLogin();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                [
                    'project_id'   => 1,
                    'name'         => '发电站',
                    'total_profit' => '22300',
                    'get_profit'   => '2000',
                    'begin'        => '2017-07-23',
                    'end'          => '2018-03-23',
                    'total'        => '80000',
                    'own'          => '34985',
                    'status'       => '1',
                ],
                [
                    'project_id'   => 2,
                    'name'         => '大型计划',
                    'total_profit' => '32300',
                    'get_profit'   => '23000',
                    'begin'        => '2017-07-23',
                    'end'          => '2018-03-23',
                    'total'        => '880000',
                    'own'          => '34985',
                    'status'       => '2',
                ],
                [
                    'project_id'   => 3,
                    'name'         => '季季发',
                    'total_profit' => '8000',
                    'get_profit'   => '3000',
                    'begin'        => '2017-07-23',
                    'end'          => '2018-03-23',
                    'total'        => '380000',
                    'own'          => '34985',
                    'status'       => '3',
                ],
            ]
        ];
        echo json_encode($a);
    }

    /**
     * @api            {get} /?c=project&a=detail [发行计划详情]
     * @apiDescription 详情
     * @apiName        detail
     * @apiGroup       project
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} desc 计划详情
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} total_profit 预计总收益
     * @apiSuccess {string} get_profit 已收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} own 拥有算力
     * @apiSuccess {string} status 状态。1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"project_id":1,"desc":"\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9","name":"\u53d1\u7535\u7ad9","total_profit":"22300","get_profit":"2000","begin":"2017-07-23","end":"2018-03-23","total":"80000","own":"34985","status":"1"}]}
     *
     * @apiVersion     1.0.0
     */
    public function detail()
    {
        try {
            $this->checkLogin();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        $a = [
            'status' => 0,
            'error'  => '',
            'data'   => [
                [
                    'project_id'   => 1,
                    'desc'         => '计划内容计划内容计划内容计划内容计划内容计划内容',
                    'name'         => '发电站',
                    'total_profit' => '22300',
                    'get_profit'   => '2000',
                    'begin'        => '2017-07-23',
                    'end'          => '2018-03-23',
                    'total'        => '80000',
                    'own'          => '34985',
                    'status'       => '1',
                ],
            ],
        ];
        echo json_encode($a);
    }

    /**
     * @api            {get} /?c=project&a=contract [查看标的合同]
     * @apiDescription 查看
     * @apiName        contract
     * @apiGroup       project
     *
     * @apiParam {string} project_id 标的id
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
        try {
            $this->checkLogin();
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
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
}