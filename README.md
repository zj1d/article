# 基于文件数据库的文章管理系统 
具有文件数据库的单入口文章管理系统，主要联系验证码类，同时
还有文章管理系统的各项功能。

## 总体思路 
通过使用不同的get参数inde.php入口文件实现文章的各个功能。

## 文件简介 

```
·
│
├── controller                        // 控制器文件，存放控制文章功能的类
|	└── ArticleController.class.php   // 控制文章系统的增删改查
|	└── AuthCode.class.php            // 验证码类 
|—— database                          // 数据库文件夹
|	└── article.php                   // 文章数据库
|	└── nav.php                       // 导航条数据库
|	└── user.php                      // 用户数据库
|—— lib                               // 核心库文件夹，存放函数存文件和数据库文件
|	└──  functions.php                // 函数库文件，主要使用自动加载类函数
|—— resource                          // 存放模板的样式文件夹
|	├── css                    		 // css样式
|	├── font                          // 字体库
|	├── images                 		 // 图片文件键
|	├── js						    // js文件夹
|—— umeditor                          // 百度编辑器
|—— view                              // 模板文件夹 
|—— public
|	├── index.php                  	 // 首页模板
|	├── editor.php                   // 编辑模板
|	├── store.php                    // 添加模板
|	├── del.php                      // 删除功能 
|	├── lists.php                    // 文章列表模板
|	├── login.php                    // 登录页面
|	├── register.php                 // 注册页面
|—— README.md                        // 简介
└─ index.php                         // 文章系统的入口



```

