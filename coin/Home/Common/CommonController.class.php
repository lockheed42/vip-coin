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
            $this->check();
        }


    }

    public function check()
    {
    }

    public function getUserInfo()
    {

    }
}