# MySQLKit
对PHP连接MySQL进行简单封装
## 初始化
使用`getInstance()`进行单例模式初始化

如果是第一次初始化，获取到的实例可能并未进行任何连接，还需要在设置连接参数后进行连接
```php
//获取实例
$sql=MySQLKit::getInstance();
//设置连接参数
$sql->setUDP("localhost","root","");
//进行连接
$sql->connect();
```
还可以通过`setHost()`,`setUser()`,`setPass()`分别进行设置（会覆盖旧的参数），设置后需要使用`connect()`进行重新连接，此时如果存在旧的连接，会断开旧的连接启用新参数的连接。

