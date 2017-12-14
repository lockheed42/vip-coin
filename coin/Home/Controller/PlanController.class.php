<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/9
 * Time: 下午3:54
 */

namespace Home\Controller;

use Home\Common\CommonController;
use Think\Exception;

class PlanController extends CommonController
{
    //0=未开始，1=预售中，2=进行中，3=已关闭'
    const PLAN_NOT_BEGIN = 0;
    const PLAN_SELL = 1;
    const PLAN_RUNNING = 2;
    const PLAN_CLOSED = 3;

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
     * @apiSuccess {string} status 状态。0=未开始，1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":0,"error":"","data":[{"name":"\u53d1\u7535\u7ad9","profit":"2300000","begin":"2017-07-23","end":"2018-03-23","total":"80000","sell":"34985","status":"1"},{"name":"\u5927\u578b\u8ba1\u5212","profit":"3230000","begin":"2017-07-23","end":"2018-03-23","total":"880000","sell":"34985","status":"2"},{"name":"\u5b63\u5b63\u53d1","profit":"80000","begin":"2017-07-23","end":"2018-03-23","total":"380000","sell":"34985","status":"3"}]}
     *
     * @apiVersion     1.0.0
     */
    public function all()
    {
        try {
            $this->checkLogin();

            $planList = M('plan')->order()->select();

            $this->success($this->filterApiReturnList($planList, ['plan_id', 'name', 'profit', 'begin', 'end', 'total', 'sell', 'status']));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @api            {get} /?c=plan&a=detail [发行计划详情]
     * @apiDescription 详情
     * @apiName        detail
     * @apiGroup       plan
     *
     * @apiParam {string} plan_id 计划id
     *
     * @apiSuccess {string} plan_id 计划id
     * @apiSuccess {string} name 计划名称
     * @apiSuccess {string} content 计划详情
     * @apiSuccess {string} profit 预计总收益
     * @apiSuccess {string} begin 开始日期
     * @apiSuccess {string} end 结束日期
     * @apiSuccess {string} price 单价
     * @apiSuccess {string} total 总算力
     * @apiSuccess {string} sell 已售部分
     * @apiSuccess {string} status 状态。0=未开始，1=预售中，2=进行中，3=已关闭
     *
     * @apiSuccessExample {json} Success-Response:
     * {"status":"0","error":"","data":{"plan_id":"1","name":"name","content":"aaaaaaaaaa","total":"8000","sell":"2000","price":"30","profit":"230000","begin":"2017-10-20","end":"2018-03-14","status":"0"}}
     *
     * @apiVersion     1.0.0
     */
    public function detail()
    {
        $planId = I('get.plan_id');

        try {
            $this->checkLogin();

            $plan = M('plan')->where(['plan_id' => $planId])->find();

            $this->success($this->filterApiReturn($plan, ['plan_id', 'name', 'content', 'profit', 'begin', 'end', 'price', 'total', 'sell', 'status']));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
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
        $planId = I('get.plan_id');

        try {
            $this->checkLogin();

            $info = M('plan_contract')->where(['plan_id' => $planId])->find();
            if (!empty($info)) {
                $info = json_decode($info['preview_url'], true);
            }

            $this->success(['url' => $info]);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
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
        //#TODO 还需要定时任务来 定期清理过期标的，并恢复占用额度
        $planId = I('post.plan_id');
        $count = I('get.count');

        try {
            $this->checkLogin();

            $userCon = new UserController();
            $userCon->checkUserAuth($this->_user_id);

            $planInfo = M('plan')->where(['plan_id' => $planId])->find();
            if (empty($planInfo)) {
                throw new Exception('计划不存在');
            }

            if ($planInfo['status'] != self::PLAN_SELL) {
                throw new Exception('计划不在发售期内');
            }

            if (($planInfo['total'] - $planInfo['sell']) < $count) {
                throw new Exception('购买额度超过 未被冻结额度');
            }

            M()->startTrans();

            M('t_plan')->where(['plan_id' => $planId])->save(['sell' => ($planInfo['sell'] + $count)]);
            M('project')->add([
                'user_id'     => $this->_user_id,
                'plan_id'     => $planId,
                'count'       => $count,
                'price'       => $planInfo['price'],
                'total_price' => $planInfo['price'] * $count,
                'cdate'       => date('Y-m-d H:i:s', time()),
            ]);

            M()->commit();
        } catch (\Exception $e) {
            M()->rollback();
            $this->fail($e->getMessage());
        }
    }
}