<?php
/**
 * @Desc    WeEvent.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-16 14:06
 * @Desc    微信接口事件处理
 */
namespace common\tool;

abstract class WeEvent{

    /*
     * <xml>
        <ToUserName><![CDATA[toUser]]></ToUserName>
        <FromUserName><![CDATA[FromUser]]></FromUserName>
        <CreateTime>123456789</CreateTime>
        <MsgType><![CDATA[event]]></MsgType>
        <Event><![CDATA[subscribe]]></Event>
        </xml>
     */
    /*
     *  <xml>
            <ToUserName><![CDATA[toUser]]></ToUserName>
            <FromUserName><![CDATA[FromUser]]></FromUserName>
            <CreateTime>123456789</CreateTime>
            <MsgType><![CDATA[event]]></MsgType>
            <Event><![CDATA[subscribe]]></Event>
            <EventKey><![CDATA[qrscene_123123]]></EventKey>
            <Ticket><![CDATA[TICKET]]></Ticket>
        </xml>
     *
     */

    //关注事件
    public static function subscribe($data = ''){
        //分两种形式 1、直接关注 2、扫码关注//用户未关注时，进行关注后的事件推送
        //第二种形式多EventKey和Ticket两个参数

    }

    //取消关注事件
    public static function unsubscribe($data = ''){}

    //用户已关注时的扫码事件推送
    public static function scan($data = ''){}

    //上报地理位置事件
    public static function location($data = ''){}

    //点击菜单拉取消息时的事件推送
    public static function click($data = ''){}

    //点击菜单跳转链接时的事件推送
    public static function view($data = ''){}

}