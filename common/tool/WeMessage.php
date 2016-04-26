<?php
/**
 * @Desc    WeMessage.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-16 14:27
 * @Desc    微信接口Message处理
 */

namespace common\tool;

abstract class WeMessage{

    //文本事件
    public static function text($data = ''){}

    //图片事件
    public static function image($data = ''){}

    //语音消息
    public static function voice($data = ''){}

    //视频消息
    public static function video($data = ''){}

    //小视频消息
    public static function shortvideo($data = ''){}

    //地理位置消息
    public static function location($data = ''){}

    //链接消息
    public static function link($data = ''){}

}