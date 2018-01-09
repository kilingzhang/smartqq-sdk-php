# smartqq-sdk-php
smartqq-sdk-php

retcode = 103 
登录 http://w.qq.com/
从设置中退出登录状态

retcode = 1202
参数错误

## SmartQQ(WebQQ)

    WebQQ腾讯公司推出的使用网页方式上QQ的服务，特点是无需下载和安装QQ软件，只要能打开WebQQ的网站就可以登录QQ与好友保持联系。官网首页 : http://w.qq.com/
 
 
## SmartQQ 

```
require_once '../Autoloader.php';

use CoolQSDK\CoolQSDK;

$CoolQ = new  CoolQSDK('127.0.0.1',5700,'token');

echo $CoolQ->getLoginInfo();
    
```

#log

