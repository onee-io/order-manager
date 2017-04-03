# OrderManager

> 一个简单的工单管理系统，有基本的用户管理、权限管理以及工单的增删改查。

### 项目框架

基于CakePHP 3.1

### 开发环境

PHP + MySQL

### 部署方式

- 新建数据库名为“order_manager”

- 执行“order_manager.sql”文件导入表结构和基础数据

- 更改配置文件中数据库连接（config/app.php）

``` php
'default' => [
    'className' => 'Cake\Database\Connection',
    'driver' => 'Cake\Database\Driver\Mysql',
    'persistent' => false,
    'host' => '127.0.0.1',
    'port' => '3306',
    'username' => 'root',
    'password' => 'root',
    'database' => 'order_manager',
    'encoding' => 'utf8',
    'timezone' => 'UTC',
    'flags' => [],
    'cacheMetadata' => true,
    'log' => false
]
```

- 将项目部署到Apache服务中，在浏览器中正常访问即可