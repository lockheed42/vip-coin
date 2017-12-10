<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/3
 * Time: 下午3:11
 */

namespace Home\Common;

use Think\Controller;

class CommonController extends Controller
{
    protected $_is_need_login = true;

    public function __construct()
    {
        parent::__construct();
        if ($this->_is_need_login === true) {
            $this->getLoginInfo();
        }


    }

    /**
     * 验证用户信息，获取uid
     */
    public function getLoginInfo()
    {

    }

    /**
     * 成功的ajax响应
     *
     * @param string $data
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
    public function fail($message = '')
    {
        $response = [
            'status' => '1',
            'error'  => $message,
            'data'   => '',
        ];
        $this->ajaxReturn(json_encode($response));
    }
}