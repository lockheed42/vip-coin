<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午3:11
 */

namespace Home\Common;

use Think\Controller;
use Think\Exception;

class CommonController extends Controller
{
    /**
     * @var string 登录的用户id
     */
    protected $_user_id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 检查登录
     *
     * @throws Exception
     */
    protected function checkLogin()
    {
        $info = $this->getLoginInfo();
        if (empty($info)) {
            throw new Exception('用户未登录');
        }

        $this->_user_id = $info['user_id'];
    }

    /**
     * 根据key 和 security 获取用户信息
     */
    public function getLoginInfo()
    {
        $apiKey = I('get.api_key');
        $apiSecurity = I('get.api_security');

        return M('user')->where(['api_key' => $apiKey, 'api_security' => $apiSecurity])->find();
    }

    /**
     * 成功的ajax响应
     *
     * @param string|array $data
     */
    protected function success($data)
    {
        $response = [
            'status' => '0',
            'error'  => '',
            'data'   => $data,
        ];
        $this->ajaxReturn(json_encode($response));
    }

    /**
     * 失败的ajax响应
     *
     * @param string $message
     */
    protected function fail($message = '')
    {
        $response = [
            'status' => '1',
            'error'  => $message,
            'data'   => '',
        ];
        $this->ajaxReturn(json_encode($response));
    }

    /**
     * 过滤api接口需要返回的数据。二维数组
     *
     * @param array $list
     * @param array $filterList
     * @return array
     */
    protected function filterApiReturnList($list, array $filterList)
    {
        $return = [];
        foreach ($list as $listKey => $data) {
            $return[$listKey] = $this->filterApiReturn($data, $filterList);
        }

        return $return;
    }

    /**
     * 过滤api接口需要返回的数据
     *
     * @param array $data
     * @param array $filterList
     * @return array
     */
    protected function filterApiReturn($data, array $filterList)
    {
        if (!is_array($data) || empty($data)) {
            return [];
        }

        $return = [];
        foreach ($data as $k => $v) {
            if (in_array($k, $filterList)) {
                $return[$k] = $v;
            }
        }

        return $return;
    }
}