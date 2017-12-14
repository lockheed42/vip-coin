<?php
/**
 * Created by PhpStorm.
 * User: Lockheed Hong
 * Date: 17/12/10
 * Time: 下午8:41
 */

namespace Home\Controller;


use Home\Common\CommonController;

class RandController extends CommonController
{
    private static $result;
    private static $tempCode;
    private static $_instance;

    //单例方法
    public static function instance()
    {
        !self::$_instance && self::$_instance = new self();
        return self::$_instance;
    }

    /**
     *   函数名称:   createSnCode
     *   函数功能:   设置种子
     *   输入参数:   $size -------------- 要生成的数量
     *              $length ----------- 长度
     *              $mode ------------- 模式
     *   函数返回值: 返回值说明
     *   其它说明:   说明
     */
    public static function createCode($size, $length, $mode = 7)
    {
        $code_array = [];
        $offset = 1.5;// 为避免递归，采用取子集的办法
        $offsize = $size * $offset;
        for ($count = 0; $count < $offsize; $count++) {
            self::seed($length, $mode);
            $code_array[] = self::$tempCode;
        }
        $unique_array = array_unique($code_array);
        self::$result = array_slice($unique_array, 0, $size);
        return self::$result;
    }

    /**
     * 生成一条随机码
     *
     * @param int $length 长度
     * @param int $mode   模式
     *
     * @return mixed
     */
    public static function createOneCode($length, $mode = 7)
    {
        $rs = self::createCode(1, $length, $mode);
        return reset($rs);
    }

    /**
     *   函数名称:   seed
     *   函数功能:   设置种子
     *   输入参数:   $length ----------- 长度
     *              $mode ----------- 模式
     *   函数返回值: 返回值说明
     *   其它说明:   说明
     */
    private static function seed($length = 7, $mode = 5)
    {
        switch ($mode) {
            case '1':
                $str = '1234567890';
                break;
            case '2':
                $str = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case '3':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case '4':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case '5':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                break;
            case '6':
                $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
                break;
            case '7':
                $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
                break;
            default:
                $str = 'impossible';
                break;
        }

        $resultArr = '';
        $seedlength = strlen($str) - 1;
        for ($i = 0; $i <= $length - 1; $i++) {
            $num = mt_rand(0, $seedlength);
            $resultArr .= $str[$num];
        }
        self::$tempCode = $resultArr;
        return self::$tempCode;
    }
}