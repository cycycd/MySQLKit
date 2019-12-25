# MySQLKit
对PHP连接MySQL进行简单封装
## 初始化
MySQLKitCore是MySQLKit中的核心组件，在使用其他组件之前都需要引入
```php
require_once "src/MySQLKitCore.php";
```
引入主要组件以及命名空间
```php
require_once "src/MySQLKit.php";
require_once "src/Table.php";
use cycycd\MySQLKit\{MySQLKit,Table};
```
注意！不要使用如下初始化方式
```php
$sql=new MySQLKit();
```
MySQLKit中已经默认实现了单例模式
```php
$sql=MySQLKit::getInstance();
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
## MySQLKit常用方法
### `execute($sql_code)`
直接执行SQL语句，并返回直接执行结果。
### `createDB($name,$setThis)`
创建简单数据库，$name为数据库名，$setThis是可选参数，默认为true；$setThis的值表示创建数据库是否选择到此数据库。
### `search($sql_code)`
搜索函数，参数为进行搜索操作的SQL语句，返回一个包含搜索结果的二维数组。
### `searchSingle($sql_code)`
单次搜索函数，参数为进行搜索操作的SQL语句，与`search()`函数不同的是，无论期望的搜索结果是一条还是多条，此函数只会返回单条结果（理论搜索结果有多个时，返回首条结果）。
### `searchExist($sql_code)`
存在搜索函数，参数为进行搜索操作的SQL语句，当搜索结果为一条或多条时，返回true，当结果是0条时，返回false。
### `setDB($DBname)`
选择数据库函数，参数为数据库名称，返回值为操作结果

一个连接及创建数据库的完整例子
```php
$sql=MySQLKit::getInstance();
if(!$sql->getConnectStatus())
{
    $sql->setHUP("localhost","root","")->connect();
    $sql->createDB("testDB");
    $sql->execute("create table if not exists test_table(
        id int primary key auto_increment,
        name char(20) not null,
        card_id int(8) zerofill
        )");
}
```
## Table类
在MySQLKit中创建数据表，除了使用原生的`execute`方法之外，还可以使用封装的`createTable`方法，`createTable`方法需要借助Table类来实现，你需要确认在代码头部引入了Table类以及相关环境变量。
例子
```php
$table=new Table();
$table->setTableName("test_table");
$table->append("id int primary key");
$table->append("name char(10) not null");
$sql=MySQLKit::getInstance();
$sql->createTable($table);
```
注意，如果在创建数据表之前如果没有选择到数据库，创建操作并不会报错或者抛出异常。需要用方法返回值来确定创建是否成功。

MySQLKit亦提供`getTable`方法

```php
$table=$sql->getTable("test_table");
```
可以根据表名获取到一个Table实例，在通过该方法获取到的Table实例中，一些方法并不可用（例如`setTableName()`和`append()`）因为获取到的实例相对于主类来说是只读的。

使用`getValue()`方法实现查找：
```php
$res1=$table->getValue();
$res2=$table->getValue("user_id","user_pass");
```

