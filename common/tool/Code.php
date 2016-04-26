<?php
/**
 * @Desc    Code.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-10 9:39
 * @Todo
 *
 *
 */
namespace common\tool;

class Code{

    const SUCCESS = 0;
    const FAIL = 1;
    const LOGIN_ERROR = 2;
    const LOGIN_FIRST = 2005;
    const BIND_PHONE_FIRST = 2006;
    const FORBID = 403;
    const NOT_FOUND = 404;
    const DB_EXCEPTION = 600;

    const USERNAME_NULL = 700;
    const USERNAME_EXISTS = 701;
    const SEND_VERIFYCODE_ERROR = 702;
    const VERIFYCODE_TIMEOUT = 703;
    const VERIFYCODE_ERROR = 704;
    const MOBILE_REGISTERED = 705;
    const MOBILE_WRONG = 706;
    const VERIVYCODE_EMPTY = 707;
    const USER_NOT_EXISTS = 708;

    const POST_NEW_THREAD_FAIL = 800;
    const REPLY_THREAD_FAIL = 801;
    const COLLECT_FORUM_ERROR = 802;
    const FORUM_NOT_EXISTS = 803;
    const COLLECT_THREAD_ERROR = 804;
    const PING_THREAD_ERROR = 805;
    const GET_USER_THREAD_ERROR = 806;
    const GET_USER_REPLIES_ERROR = 807;
    const SEND_SMS_FAIL = 808;
    const BIND_MOBILE_FAIL = 809;
    const NOT_ALLOW_POST = 810;
    const AUTHCODE_FAIL = 811;

    const ILLEGAL_TOKEN = 9001;

    //第三方账户尚未绑定用户
    const WEIBO_NOT_BIND = 1008;

    const IOS = 1;
    const ANDROID = 2;

}