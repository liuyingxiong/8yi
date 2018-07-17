<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 返回JSON数据
 * @param $ret int 返回状态  -1 错误  1 正确
 * @param $code
 * @param $msg
 */
function msgJson($ret,$code="",$msg)
{
    return json_encode(['ret'=>$ret,'code'=>$code,'msg'=>$msg]);
}

/**
* 返回数组
* @param $ret int 返回状态  -1 错误  1 正确
* @param $code
* @param $msg
*/
function ret($ret,$code="",$msg)
{
    return ['ret'=>$ret,'code'=>$code,'msg'=>$msg];
}

/**
 * 判断是不是移动端访问
 * @return bool
 */
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA'])){
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])){
        $clientkeywords = array (
            'nokia', 'oppo', 'xiaomi', 'miui', 'huawei', 'coolpad', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh',
            'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu',
            'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave',
            'nexusone', 'cldc', 'midp', 'wap', 'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])){
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
            return true;
        }
    }
    return false;
}

/**
 * 判断是不是微信浏览器
 * @return bool
 */
function isWeiXin()
{
    if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
        return true;
    }
    return false;
}

/**
 * 打印
 * @param $data array
 */
function dd($data)
{
    dump($data);
    exit;
}

/**
 * curl 请求
 * @param $type 1:get  2:post
 * $param $url
 */
function retCurl($type=1,$url,$params="")
{
    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // https请求 不验证证书和hosts
    if(strpos($url,'https') !== false) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    // 请求方式
    switch ($type)
    {
        case 1:
            break;
        case 2:
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            break;
        default:
            return json_encode(['ret'=>0,'err'=>'接口错误']);
    }
    //执行命令
    $data = curl_exec($curl);
    //打印错误
    $err = curl_errno($curl);
    curl_close($curl);
    if ($err) {
        return json_encode($err);
    } else {
        return $data;
    }
}

/**
 * 加密方式
 * @param $pass
 */
function encry($value)
{
    return md5($value);
}

/**
 * 加密方式二
 * @param $pass
 */
function encryTwo($value)
{
    return md5(md5($value));
}

/**
 * 电话隐藏中间4位
 * @param $string int
 */
function hidePhone($string)
{
    return substr_replace($string,'****',3,4);
}

/**
 * 字符串转大写
 * @param @value
 */
function large($value)
{
    return strtoupper($value);
}

/**
 * 字符串转小写
 * @param $value
 */
function small($value)
{
    return strtolower($value);
}

/**
 * Author: 码农
 * Date: 2018-03-24
 * 中文字符串截取拼接
 * @param $str ：中文字符串
 * @param $length ：字符串字符长度   中文 1：3
 * @param $number ：截取字符长度
 * @param int $start
 * @return $str
 */
function get_sub($str, $length, $number, $start=0){
    if(strlen($str) > $length){
        $str = mb_substr($str, $start, $number, 'utf-8') . "...";
    }
    return $str;
}

/**
 * [将Base64图片转换为本地图片并保存]
 * @TIME   2017-04-07
 * @param  [Base64] $base64_image_content [要保存的Base64]
 * @param  [目录] $path [要保存的路径]
 * @param  $fileName string 文件名称
 */
function base64_image_content($base64_image_content,$path,$fileName=""){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        if(empty($fileName)){
            $new_file = $new_file.time().".{$type}";
        }else{
            $new_file = $new_file.$fileName.".{$type}";
        }
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return '/'.$new_file;
        }
    }
    return false;
}

/**
 * 生成订单编号
 * @param $uid int
 */
function order_sn($uid){
    $order_sn = "";
    $arr = [
        1  => "A",
        2  => "B",
        3  => "C",
        4  => "D",
        5  => "E",
        6  => "F",
        7  => "G",
        8  => "H",
        9  => "I",
        10 => "J",
        11 => "K",
        12 => "L",
    ];
    // 获取时间  ABCDEFGHIJKL 对应 1到12月
    $time = time();
    $t = date("n",$time);
    $order_sn .= $arr[$t].date("YmdHis",$time).$uid;
    return $order_sn;
}

/**
 * 生成随机数
 * @param $length string
 */
function getRandChar($length = 4){
    $str = null;
    $strPol = "QWERTYUIOPASDFGHJKLZXCVBNM0123456789";
    $max = strlen($strPol)-1;
    for($i=0;$i<$length;$i++){
        $str .= $strPol[rand(0,$max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }
    return $str;
}
