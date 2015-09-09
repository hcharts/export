# 基于 Phantomjs 实现的导出服务器

## 优点

* 导出图片可以做到无损（不会出现中文文字大小不一）
* 灵活，支持服务端直接导出，同时也可以作为 Web 服务的形式（待详细说明）


## 原理

原理说明见这里：[http://bbs.hcharts.cn/thread-989-1-1.html](http://bbs.hcharts.cn/thread-989-1-1.html)
### 使用方法

### 1、安装环境

#### Phantomjs

安装方法见[这里](http://phantomjs.org/download.html)

#### php 运行环境（apache 或 nginx + php-fpm）

### 2、部署

修改 index.php 的

```
// Phantomjs 路径
define ('Phantom_HOME', '/usr/local/bin/');   // 这里修改为自己运行环境
```

将整个目录部署到服务器即可。

### 3、调用方法

设置

```
exporting: {
  url: 'http://{你的服务器地址}/index.php'
}

```