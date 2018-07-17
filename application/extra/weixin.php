<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
// | WeiXin设置
// +----------------------------------------------------------------------
return [
    "appid"     => "wx6643c82cfc8e140e",                        // 微信公众号AppID
    "appsecret" => "b94a7f2d8a72ff01422f0ff8e2a00fc2",          // 微信公众号AppSecret

    // +----------------------------------------------------------------------
    // | 微信公众号 支付设置
    // +----------------------------------------------------------------------
    "mch_id"      => "1508773651",     // 微信支付分配的商户号
    "device_info" => "WEB",            // 可不带参数  终端设备号，PC网页或者公众号填写 "WEB"
    "sign_type"   => "MD5",            // 可不带参数  签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
    "body"        => "重庆俊石科技有限公司-商品购买",     // 商品描述  商家名称-销售商品类目
    "trade_type"  => "JSAPI",           // APP--app支付     MWEB--H5支付     JSAPI--公众号支付   NATIVE--扫码支付
    "key"         => "514CFDCFA7A3DA5ECD303F915BFE34A1",
];
