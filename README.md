# smartqq-sdk-php
[![License](https://poser.pugx.org/kilingzhang/smartqq-sdk-php/license)](https://packagist.org/packages/kilingzhang/smartqq-sdk-php) [![Latest Stable Version](https://poser.pugx.org/kilingzhang/smartqq-sdk-php/version)](https://packagist.org/packages/kilingzhang/smartqq-sdk-php) [![Latest Unstable Version](https://poser.pugx.org/kilingzhang/smartqq-sdk-php/v/unstable)](//packagist.org/packages/kilingzhang/smartqq-sdk-php) [![Total Downloads](https://poser.pugx.org/kilingzhang/smartqq-sdk-php/downloads)](https://packagist.org/packages/kilingzhang/smartqq-sdk-php) [![composer.lock available](https://poser.pugx.org/kilingzhang/smartqq-sdk-php/composerlock)](https://packagist.org/packages/kilingzhang/smartqq-sdk-php)
## SmartQQ(WebQQ)
WebQQ腾讯公司推出的使用网页方式上QQ的服务，特点是无需下载和安装QQ软件，只要能打开WebQQ的网站就可以登录QQ与好友保持联系。官网首页 : http://w.qq.com/
## smartqq-sdk-php
`smartqq-sdk-php`是对smartqq接口的基础封装。只是把一些处理类分离出sdk的代码层。让用户去实现具体的操作接口。更利代码的解耦。原理其实很简单，就是跨站请求伪造(CSRF), 伪造请求头,调用[smartqq](http://w.qq.com/)官方API。

注：请善待smartqq协议。希望不要因为肆意发送的广告而让此协议突然在某一天不复存在。因为现在的它已经很脆弱了，还web协议一片净土。~~虽然现在没人用web的协议了，都去用PC，安卓协议。虽然我也在用 溜~~

## 功能
 - [x] 获取二维码 
 - [x] 获取二维码验证状态
 - [x] 获取vfwebqq
 - [x] 二次登录
 - [x] 接收消息事件
 - [x] 发送好友消息
 - [x] 发送群消息
 - [x] 获取讨论组消息
 - [x] 获取好友列表（uin）
 - [x] 获取好友在线状态
 - [x] 获取最近联系人列表
 - [x] 获取群列表（gid）
 - [x] 获取讨论组列表（did）
 - [x] 获取个人信息
 - [x] 获取好友详细信息
 - [x] 获取群详细信息（包括 群成员 群信息）
 - [x] 获取讨论组详细信息（包括 讨论组成员 讨论组信息）
 - [x] 获取讨论组详细信息
 - [x] 获取SingleLongNick

## 快速开始
### composer安装
	composer require kilingzhang/smartqq-sdk-php

### 部署
	<?php
    use kilingzhang\SmartQQ\QQClient;
    use kilingzhang\SmartQQ\Entity\ClientToken;

    include __DIR__ . '/vendor/autoload.php';
	//初始化QQClient,后续讲基于此会话调用各种方法
    $QQ = new QQClient();
    //设置二维码保存路径
    $QQ->setQRCodePath('./qrcode.png');
    //初始化用户登录令牌
    $clientToken = new ClientToken();
    //判断令牌是否为空（有无缓存登录状态）
    if ($clientToken->isEmpty()) {
    	//第一次登录
        $QQ->refreshQRCode();
        //验证二维码状态
        if ($QQ->QRlogin()) {
        	//二次登陆
            $QQ->Login();
            //讲用户登录状态信息转换为登录令牌
            $clientToken = $QQ->getClienToken();
            //保存登录令牌
            $clientToken->save();
        }
    } else {
    	//获取已缓存的用户登录令牌
        $clientToken = ClientToken::toClientToken($clientToken->getClientTokenJson());
        //根据令牌设置用户会话
        $QQ->setClienToken($clientToken);
    }
    //　专门作为测试使用　内置了一次的Poll事件
    $QQ->test();


## [文档]
[![文档](http://markdown-1252847423.file.myqcloud.com/%E6%B7%B1%E5%BA%A6%E6%88%AA%E5%9B%BE_%E9%80%89%E6%8B%A9%E5%8C%BA%E5%9F%9F_20180110093636.png)
](http://blog.kilingzhang.com/smartqq-sdk-php)
## [Demo]
基于smartqq-sdk-php 写的一个小[Demo](https://github.com/kilingzhang/smartqq-demo)。完成了samrtqq中的所有基本事件操作。算是个入门的demo。后续我会基于此sdk更新一个QQ机器人完整的项目。把之前的[SmartQQRobotByPHP](https://github.com/kilingzhang/SmartQQRobotByPHP)重写一遍。


## 教程
当初抱着对QQ机器人的热情，最先接触也是新手最有可能实现的就是Smartqq的协议。但是当时感觉无从下手，网上的资料又老又不详细还不是PHP。所以想着给后来的Phper一个入门的机会。节省很多宝贵的时间。不要像我自己一样兜兜转转的绕圈子。而且个人觉得如果把Smartqq从抓包到分析协议整个流程搞明白，基本大部分web的爬虫抓包分析就没有问题了，剩下的就是熟练。所以也可以当做是一个爬虫分析的入门教程。文章还在更新中。

[SmartQQ协议分析——登录(１)](https://zhuanlan.zhihu.com/p/32642239)

[SmartQQ协议分析——登录(2)]()

[SmartQQ协议分析——获取列表]()

[SmartQQ协议分析——获取详细信息]()

[SmartQQ协议分析——Poll轮训获取消息]()

[SmartQQ协议分析——发送信息]()

[SmartQQ协议分析——其他]()




## 其他

retcode = 103 
同一IP禁止多账号登录。 出现此状态码说明你的IP中存在多账号登录。此时只需要去官方地址的把账号注销掉就好了。
登录 http://w.qq.com/ 再从从设置中退出登录状态 

retcode = 1202


## 感谢
灵感来自[@ScienJus](https://github.com/ScienJus/smartqq)大大的文章。一年前我的入门就是从这位大大这里开始的。给了我进入QQ机器人大门的入场卷。当时大大还只有Ruby和java的版本。我就自己写了Python的版本。后来自己又写了PHP的版本，协议改变，到自己再更新协议。自此也有了这个项目和上文的教程，也算是尽自己的一点点贡献吧。~~不过最后因为太不稳定就转战去玩PC安卓协议的机器人了。溜~~

## log


## License
[The MIT License (MIT)](https://github.com/kilingzhang/smartqq-sdk-php/blob/master/LICENSE)

