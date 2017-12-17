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
     * @apiSuccess {string} project_id 标的id
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} total_profit 预计总收益
     * @apiSuccess {string} get_profit 已收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} count 拥有算力
     * @apiSuccess {string} status 发行计划状态。1=预售中，2=进行中，3=已关闭
     * @apiSuccess {string} project_status 我的标的状态。1=已作废，2=未生效，3=已生效
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"project_id":1,"name":"\u53d1\u7535\u7ad9","total_profit":"22300","get_profit":"2000","begin":"2017-07-23","end":"2018-03-23","total":"80000","count":"34985","status":"1"},{"project_id":2,"name":"\u5927\u578b\u8ba1\u5212","total_profit":"32300","get_profit":"23000","begin":"2017-07-23","end":"2018-03-23","total":"880000","count":"34985","status":"2"},{"project_id":3,"name":"\u5b63\u5b63\u53d1","total_profit":"8000","get_profit":"3000","begin":"2017-07-23","end":"2018-03-23","total":"380000","own":"34985","status":"3"}]}
     *
     * @apiVersion     1.0.0
     */
    public function all()
    {
        try {
            $this->checkLogin();

            $list = M('project')
                ->join('t_plan as p ON p.plan_id = t_project.plan_id')
                ->where(['user_id' => $this->_user_id])->select();

            //TODO get_profit，获取收益列表。下面为临时代码
            if (!empty($list)) {
                foreach ($list as $k => $v) {
                    $list[$k]['total_profit'] = 1;
                    $list[$k]['get_profit'] = 1;
                }
            }

            $this->success(
                $this->filterApiReturnList(
                    $list, [
                        'project_id', 'name', 'total_profit', 'get_profit', 'begin', 'end', 'count', 'status', 'project_status'
                    ]
                )
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {get} /?c=project&a=detail [标的详情]
     * @apiDescription 详情
     * @apiName        detail
     * @apiGroup       project
     *
     * @apiParam {string} project_id 标的id
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} content 计划详情
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} total_profit 预计总收益
     * @apiSuccess {string} get_profit 已收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} count 拥有算力
     * @apiSuccess {string} project_status 我的标的状态。1=已作废，2=未生效，3=已生效
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"project_id":1,"content":"\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9\u8ba1\u5212\u5185\u5bb9","name":"\u53d1\u7535\u7ad9","total_profit":"22300","get_profit":"2000","begin":"2017-07-23","end":"2018-03-23","total":"80000","count":"34985","project_status":"1"}]}
     *
     * @apiVersion     1.0.0
     */
    public function detail()
    {
        $projectId = I('get.project_id');

        try {
            $this->checkLogin();

            $detail = M('project')
                ->join('t_plan as p ON p.plan_id = t_project.plan_id')
                ->where(['user_id' => $this->_user_id, 'project_id' => $projectId])->find();

            if (!empty($detail)) {
                $detail['total_profit'] = 1;
                $detail['get_profit'] = 1;
            }

            //TODO get_profit，获取收益总和
            $this->success(
                $this->filterApiReturn(
                    $detail, [
                        'plan_id', 'content', 'name', 'total_profit', 'get_profit', 'begin', 'end', 'count', 'project_status'
                    ]
                )
            );
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
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
        $projectId = I('get.project_id');

        try {
            $this->checkLogin();

            $contract = M('project_contract')->where(['user_id' => $this->_user_id, 'project_id' => $projectId])->find();
            if (!empty($contract) && !empty($contract['preview_url'])) {
                $contract = json_decode($contract['preview_url'], true);
            }

            $this->success(['url' => $contract]);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}