# MySQLKit
对PHP连接MySQL进行简单封装
## 初始化
命名空间&实例获取
```php
use MySQLKit\MySQLKit;
$sql=MySQLKit::getInstance()
```
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

注：所有用于设置参数的函数均返回this对象
## 函数
### `execute($sql_code)`
直接执行SQL语句，并返回直接执行结果。
### `createDB($name,$setThis)`
创建简单数据库，$name为数据库名，$setThis是可选参数，默认为true；$setThis的值表示创建数据库是否选择此数据库。
### `search($sql_code)`
搜索函数，参数为进行搜索操作的SQL语句，返回一个包含搜索结果的二维数组。
### `searchSingle($sql_code)`
单次搜索函数，参数为进行搜索操作的SQL语句，与`search()`函数不同的是，无论期望的搜索结果是一条还是多条，此函数只会返回单条结果（理论搜索结果有多个时，返回首条结果）。
### `searchExist($sql_code)`
存在搜索函数，参数为进行搜索操作的SQL语句，当搜索结果为一条或多条时，返回true，当结果是0条时，返回false。
### `setDB($DBname)`
选择数据库函数，参数为数据库名称，返回值为操作结果
### 例子
```php
$sql=MySQLKit::getInstance();
$sql->setHUP("localhost","root","")->connect();
$sql->createDB("testDB");
$sql->execute("create table if not exists test_table(
    id int primary key auto_increment,
    name char(20) not null,
    card_id int(8) zerofill
)");
```
## Table类
```php
use MySQLKit\Table;
$table=new Table();
```