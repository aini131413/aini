# Day1

# 搭架子

## 1.下载框架
     composer create-project --prefer-dist laravel/laravel ele "5.5.*" -vvv

## 2. 设置虚拟主机 三个域名
```php
 
<VirtualHost *:80>
    DocumentRoot "D:/ele/public"
    ServerName www.ele.com
    ServerAlias admin.ele.com shop.ele.com
</VirtualHost>
<Directory "D:/ele/public">
      Options Indexes FollowSymLinks ExecCGI
      AllowOverride All
      Order allow,deny
      Allow from all
      Require all granted
</Directory>



127.0.0.1 www.ele.com admin.ele.com shop.ele.com

```


## 3. 建立数据库ele
小黄人 建库，字符集 utf8

## 4. 配置.env文件 数据库配好

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ele
DB_USERNAME=root
DB_PASSWORD=root

## 5. 配置语言包

将 resource/lang/zh-CN 文件复制出来或者按下面三步行动

1、composer require caouecs/laravel-lang:~3.0 -vvv

2、复制vendor\caouecs\laravel-lang\src\zh-CN 目录到 resources\lang\zh-CN

3、设置config\app.php 81行为 'locale' => 'zh-CN',

==如果表单验证中有不能转换的英文提示，需要在 
resources\lang\zh-CN\validation.php
里面的RETURN 和 attribute 两处分别添加翻译信息==

## 6. 数据迁移
==运行前的建表==
    php assphp artisan make:model Models/User -m


1》、运行：php artisan migrate

2》、报错时SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes

手动配置迁移命令migrate生成的默认字符串长度，在App/Providers/AppServiceProvider中调用Schema::defaultStringLength方法来实现配置：

    use Illuminate\Support\Facades\Schema;
    
    public function boot()
    {
       Schema::defaultStringLength(191);
    }
3》、手动在小黄人中删除数据表同时在
        database\migrations
    
    中对应的表中添加相关的字段
    ```php
     public function up()
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->comment("菜品分类名称");
            $table->string("type_accumulation")->comment("菜品分类编号");
            $table->integer("shop_id")->comment("所属商家");
            $table->string("description")->comment("描述");
            $table->string("is_selected")->comment("是否默认分类");
            $table->timestamps();
        });
    }
    
    ```

4》、再运行：php artisan migrate

## 7. PHPSTROM 安装提示信息
```php
1》、composer require barryvdh/laravel-ide-helper -vvv

2》、composer require "doctrine/dbal: ~2.3"  -vvv

php artisan vendor:publish--provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config

3》、php artisan ide-helper:generate

4》、php artisan ide-helper:models

5》、在config\ide-helper.php下

include_fluent' => false 修改为 'include_fluent' => true

6》、运行php artisan ide-helper:generate

7》、重启PHPSTROM
```
# 安装网页显示调试包
composer require barryvdh/laravel-debugbar
## 8. 安装验证码步骤：

使用 Composer 安装：(需要打开php.ini 中的 fileinfo扩展)

composer require mews/captcha -vvv

修改config/app.php,在providers添加

Mews\Captcha\CaptchaServiceProvider::class,

在aliases添加

'Captcha' =>Mews\Captcha\Facades\Captcha::class,

运行以下命令生成配置文件 config/captcha.php：

php artisan vendor:publish

然后选择8

我们可以打开配置文件，查看其内容：

config/captcha.php


前端展示验证码
```php
<input id="captcha" class="form-control" name="captcha" >

<img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">’
```
## 9. 文件上传到ALIOSS 实现
实现步骤

1.阿里云OSS

    进入阿里云官方网站，登录后充值1块，然后开通OSS对象存储新建OSS对象存储空间，设置公共读类型右键用户图像 创建 AccessKey 得到AccessKey ID，Access Key Secret备用
2.代码实现

    composer 安装 composer require jacobcyl/ali-oss-storage

添加如下配置到app/filesystems.php

    'disks'=>[
    ...
    'oss' => [
            'driver'        => 'oss',
            'access_id'     => 'LTAI9wKqh1AFaUA9',
            'access_key'    => 'Ksy8pW3RlZtsOwZctnOCt5sk4rBaCp',
            'bucket'        => 'zhilipeng',
            'endpoint'      => 'oss-cn-shenzhen.aliyuncs.com', // OSS 外网节点或自定义外部域名
            'debug'         => false
    ],
    ...
    ]
可以选择配置.env文件，提升体验

    ALIYUN_OSS_URL=http://php0325ele.oss-cn-shenzhen.aliyuncs.com/
    ACCESS_ID=LTAICkzbQn0fTiHc
    ACCESS_KEY=xRoz5ISd0e8GMo2YnStxneXRbAF5P5
    BUCKET=php0325ele
    ENDPOINT=oss-cn-shenzhen.aliyuncs.com
​

在控制器方法中上传处 使用如下代码实现上传实现

    $data=$request->all(); //接收到前端页面传来的所有数据
    
    $file=$request->file('img');// $data["img"]
     if ($file!==null){
               //上传文件
               $fileName= $file->store("上传到OSS的文件夹路径","oss");
    
          $data["img"] = env("ALIYUN_OSS_URL").$fileName
    
            }

掉用方法时后面要对应添加的‘oss’
$request->file('img')->store('ele',"oss");

## 10. 用户登录

==模型必需要继承== 

 use Illuminate\Foundation\Auth\User as Authenticatable;

E:\web\laravel\config\auth.php 第70行 设置提供数据的模型

'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class,//验证用户的模型
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
==密码必需bcrypt()函数加密==

验证

 //登录
        1、默认
        2、其他平台
        ```php
        
       2 
       Auth::guard("admin")->attempt(["name" => $request->name, "password" =>$request->password])
       1   
            if (Auth::attempt(['name'=>$request->post('name'),'password'=>$request->post('password')])) {
    
                //提示
                $request->session()->flash("success","登录成功");
                //echo "登录成功";
                //跳转
                return redirect()->route('user.index');
    
            }else{
                //提示
                $request->session()->flash("danger","账号或密码错误");
                //跳转
                return redirect()->back()->withInput();
            }

==前端权限判断==


@auth
    // 用户已经通过身份认证...
@endauth

@guest
    // 用户没有通过身份认证...
@endguest
得到当前用户

Auth::user();//当前用户对象
\Illuminate\Support\Facades\Auth::user()->name;//取到当前用户名称



## 12. 准备好基础模板

## 13. 创建 控制器
php artisan make:controller Admin/ShopCategoryController

## 14. 创建视图 视图也要分模块

## 15. 路由需要分组

    ```php
    Route::get('/', function () {
        return view('welcome');
    });
    //平台
    Route::domain('admin.ele.com')->namespace('Admin')->group(function () {
        //店铺分类
        Route::get('shop_category/index',"ShopCategoryController@index");



    });
    
    //商户
    Route::domain('shop.ele.com')->namespace('Shop')->group(function () {
        Route::get('user/reg',"UserController@reg");
        Route::get('user/index',"UserController@index");
    });
    ```




# Day 2

### 平台的登录


1. 平台的登录，模型中必需继承 Authenticatable
```php
use Illuminate\Foundation\Auth\User as Authenticatable
```

2. 设置配置文件config/auth.php 

   ```php
    'guards' => [
           //添加一个guards
           'admin' => [
               'driver' => 'session',
               'provider' => 'admins',//数据提示者
           ],

          
       ],
    'providers' => [
        //提供商户登录
           'users' => [
               'driver' => 'eloquent',
               'model' => \App\Models\User::class,
           ],
        //提供平台登录
           'admins' => [
               'driver' => 'eloquent',
               'model' => \App\Models\Admin::class,
           ],
       ],
   ```

3. 平台登录的时候

   ```php
   Auth::guard('admin')->attempt(['name'=>$request->post('name'),'password'=>$request->password])
   ```

4. 平台AUTH权限判断 设置中间件

   ```php
   public function __construct()
       {
           $this->middleware('auth:admin')->except("login");
       }

   ```

5. 设置认证失败后回跳地址 在Exceptions/Handler.php后面添加

   ```php
   /**
        * 重写实现未认证用户跳转至相应登陆页
        * @param \Illuminate\Http\Request $request
        * @param AuthenticationException $exception
        * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
        */
       protected function unauthenticated($request, AuthenticationException $exception)
       {

           //return $request->expectsJson()
           //            ? response()->json(['message' => $exception->getMessage()], 401)
           //            : redirect()->guest(route('login'));
           if ($request->expectsJson()) {
               return response()->json(['message' => $exception->getMessage()], 401);
           } else {
               return in_array('admin', $exception->guards()) ? redirect()->guest('/admin/login') : redirect()->guest(route('user.login'));
           }
       }
   ```
   ## 修改密码前的验证原密码功能
   - 修改个人密码需要用到验证密码功能,[参考文档](https://laravel-china.org/docs/laravel/5.5/hashing)
   
   # Day 3
   
   # Laravel-UEditor
   
   UEditor integration for Laravel 5.
   
   # 使用
   
   > 视频教程：https://www.laravist.com/series/awesome-laravel-packages/episodes/7
   
   ## 安装
   
   ```shell
   $ composer require "overtrue/laravel-ueditor:~1.0"
   ```
   
   ## 配置
   
   1. 添加下面一行到 `config/app.php` 中 `providers` 部分：
   
      ```php
      Overtrue\LaravelUEditor\UEditorServiceProvider::class,
      ```
   
   2. 发布配置文件与资源
   
      ```php
      $ php artisan vendor:publish --provider='Overtrue\LaravelUEditor\UEditorServiceProvider'
      ```
   
   3. 运行 
    ```php
       php artisan vendor:publish
    ```
   4. 模板引入编辑器
   
      这行的作用是引入编辑器需要的 css,js 等文件，所以你不需要再手动去引入它们。
   
      ```php
      @include('vendor.ueditor.assets')
      ```
   
   4. 编辑器的初始化
   
      ```html
      <!-- 实例化编辑器 -->
      <script type="text/javascript">
          var ue = UE.getEditor('container');
          ue.ready(function() {
              ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
          });
      </script>
      
      <!-- 编辑器容器 -->
      <script id="container" name="content" type="text/plain"></script>
      ```
   
   # 说明
   
   1. 5.4+ 请不要忘记 `php artisan storage:link`
   
   2. 如果你使用的是 laravel 5.3 以下版本，请先创建软链接：
   
      ```shell
      # 请在项目根目录执行以下命令
      $ ln -s `pwd`/storage/app/public `pwd`/public/storage
      ```
   
   3. 在 `config/ueditor.php` 配置 `disk` 为 `'public'` 情况下，上传路径在：`public/uploads/` 下，确认该目录存在并可写。
   
   4. 如果要修改上传路径，请在 `config/ueditor.php` 里各种类型的上传路径，但是都在 public 下。
   
   5. 请在 `.env` 中正确配置 `APP_URL` 为你的当前域名，否则可能上传成功了，但是无法正确显示。
   
   ## 七牛支持
   
   如果你想使用七牛云储存，需要进行下面几个简单的操作：
   
   1.安装和配置 [laravel-filesystem-qiniu](https://github.com/overtrue/laravel-filesystem-qiniu)
   
   2.配置 `config/ueditor.php` 的 `disk` 为 `qiniu`:
   
   ```php
   'disk' => 'qiniu' //如果是传到ali oss ,就修改为 oss
   ```
   
   
   > 七牛的 `access_key` 和 `secret_key` 可以在这里找到：https://portal.qiniu.com/user/key ,在创建 `bucket` （空间）的时候，推荐大家都使用公开的空间。
   
   ## 事件
   
   你肯定有一些朋友肯定会有一些比较特殊的场景，那么你可以使用本插件提供的事件来支持：
   
   > 请按照 Laravel 事件的文档来使用：
   > https://laravel.com/docs/5.4/events#registering-events-and-listeners
   
   ### 上传中事件
   
   > Overtrue\LaravelUEditor\Events\Uploading
   
   在保存文件之前，你可以拿到一些信息：
   
   - `$event->file` 这是请求的已经上传的文件对象，`Symfony\Component\HttpFoundation\File\UploadedFile` 实例。
   - `$event->filename` 这是即将存储时用的新文件名
   - `$event->config` 上传配置，数组。
   
   你可以在本事件监听器返回值，返回值将替换 `$filename` 作为存储文件名。
   
   ### 上传完成事件
   
   > Overtrue\LaravelUEditor\Events\Uploaded
   
   它有两个属性：
   
   - `$event->file` 与 Uploading 一样，上传的文件
   
   - `$event->result` 上传结构，数组，包含以下信息：
   
     ```php
     'state' => 'SUCCESS',
     'url' => 'http://xxxxxx.qiniucdn.com/xxx/xxx.jpg',
     'title' => '文件名.jpg',
     'original' => '上传时的源文件名.jpg',
     'type' => 'jpg',
     'size' => 17283,
     ```
   
   你可以监听此事件用于一些后续处理任务，比如记录到数据库。
   
# Day 4

### 1.阿里云OSS

1. 进入阿里云官方网站，然后开通OSS对象存储
2. 新建OSS对象存储空间，设置公共读类型
3. 右键用户图像 创建 AccessKey 得到AccessKey ID，Access Key Secret备用

#### 2.代码实现

1. composer 安装 composer require jacobcyl/ali-oss-storage

2. 添加如下配置到app/filesystems.php

   ```php
   'disks'=>[
       ...
       'oss' => [
               'driver'        => 'oss',
               'access_id'     => '<Your Aliyun OSS AccessKeyId>',
               'access_key'    => '<Your Aliyun OSS AccessKeySecret>',
               'bucket'        => '<OSS bucket name 空间名称>',
               'endpoint'      => '<the endpoint of OSS, E.g: oss-cn-hangzhou.aliyuncs.com | custom domain, E.g:img.abc.com>', // OSS 外网节点或自定义外部域名
               'debug'         => false
       ],
       ...
   ]
   ```

3. 可以选择配置.env文件，提升体验

   ```php
   ALIYUN_OSS_URL=http://php0325ele.oss-cn-shenzhen.aliyuncs.com/
   ACCESS_ID=LTAICkzbQn0fTiHc
   ACCESS_KEY=xRoz5ISd0e8GMo2YnStxneXRbAF5P5
   BUCKET=php0325ele
   ENDPOINT=oss-cn-shenzhen.aliyuncs.com
   ```

   ​

4. 上传实现

   ```php
    $file=$request->file('img');
    if ($file!==null){
                  //上传文件
      $fileName= $file->store("上传到OSS中的文件夹","oss");

      $data["img"]=env("ALIYUN_OSS_URL").$fileName;

               }
            
         然后再添加到数据库就OK了
   ```

# Day 5

## 第一步

先将 images static 文件夹 和 index.html ,api.js 文件复制到 项目的根目录中

## 第二步

创建控制器

```php
php artisan make:controller Api/ShopController;
```



## 第三步

写路由

Route::get("shop/index","Api\ShopController@index");

Route::get("shop/list","Api\ShopController@list");

## 第四步

打开网页输入网址，F12 调试模式中 查看network 中的404 报错

![1532672944170](C:\Users\sasen\AppData\Local\Temp\1532672944170.png)

说明businessList.php 在路由中未找到

## 第五步

打开api.js 找到

```php
 // 获得商家列表接口
  businessList: '/businessList.php',//将/businessList.php字体部分改为 /api/shop/list 即写入的路由地址
```

深度刷新网页 F12调试network中 出现

![1532673394985](C:\Users\sasen\AppData\Local\Temp\1532673394985.png)

单击list

![1532673484564](C:\Users\sasen\AppData\Local\Temp\1532673484564.png)

说明 方法list 不存在，在此时打开 原包中的businessList.php 文件 查看内容

![1532673723919](C:\Users\sasen\AppData\Local\Temp\1532673723919.png)

从数据库中查找与红框内有相同的字段的数据表，因此 在控制器的中写方法时，要从此表中取出数据

```php
    /**
     * 商铺列表
     * @return \Illuminate\Support\Collection
     */
    public function list(Request $request)
    {
        $shops=Shop::where("status",1)->get();
        if($request->keyword !==null){
            $shops=Shop::where("shop_name","like","%{$request->keyword}%")->where("status",1)->get();
        }
        return $shops;
    }

```
# Day6

## laravel 安装Predis

    composer require predis/predis -vvv

## 配置 config/database.php 

    'redis' => [
    
        'client' => 'predis',
    
        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],
    
    ],

## 启用redis服务 
在我的电脑里面  D:\redisbin64\redis-server.exe 

    //生成验证码
        $m=rand(1000,9999);
    //        存验证码并设置过期时间 Redis::setex("tel_".$tel,300,$m); $tel 是前端传的参数
    //        Redis::setex(名字,过期时间秒,验证码);
    Redis::setex("tel_".$tel,300,$m)
    
    
# 将生成的验证码存缓存中 
```php
catch(["key"=>" time",]过期时间分钟数);
 //取缓存
catch(["key"=>" time",]过期时间分钟数);
```


# Api中的注册健壮性要手动验证
```php
 $validator = Validator::make($request->all(), [
            'username' => 'required|unique:vips',
            'tel'=>'required|unique:vips'
        ]);
        if ($validator->fails()) {
            return [
                "status" => "false",
                "message" => "用户名或者手机号已被注册"
            ];
        }
```

# Api 中登录原理
    1-》 用接收的用户名 到数据库中查找数据
    2-》 如果存在，再进行密码手动对比
```php
  /**
       * 登录
       * @param Request $request
       */
      public function login(Request $request)
      {
          $username = $request->input("name");
          $password = $request->input("password");
          $vip= Vip::where("username",$username)->first();
          if ($vip) {
              if (Hash::check($password, $vip->password)) {
                  return [
                      "status"=>"true",
                      "message"=>"登录成功",
                      "user_id"=>$vip->id,
                      "username"=>$username
                  ];
              }else{
                  return [
                      "status"=>"false",
                      "message"=>"用户名或密码错误"];
              }
          }
          return [
              "status"=>"false",
              "message"=>"用户名或密码错误",
  
          ];
  
      }  
```


# Day 7
没学到什么东西
# Day 8
## models：Order 里的方法
```php
public function getOrderStatusAttribute()
{
    $arr=[0=>"代支付",-1=>"已取消",1=>"待发货",2=>"待确认",3=>"完成"];
    return $arr[$this->status];
}
调用上面的方法：
$order->order_status;
```
## 事务 
### 自动事务
```php
DB::transaction(function () {
  //要执行得东西
});
```
### 手动事务
```php
  DB::beginTransaction();
        try {
            Order::create($data);
            $order_id = DB::getPdo()->lastInsertId();
            $data2["order_id"] = $order_id;
            foreach ($carts as $cart) {
                $data2["goods_id"] = $cart->menu_id;
                $data2["amount"] = $menu_count;
                $data2["goods_name"] = Menu::find($cart->menu_id)->goods_name;
                $data2["goods_img"] = Menu::find($cart->menu_id)->goods_img;
                $data2["goods_price"] = $price;
                OrderGood::create($data2);
            }
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return ['status' => 'false', 'message' => $e->getMessage()];
        }
        return [
            "status" => "true",
            "message" => "添加成功",
            "order_id" => $order_id
        ];


```
# Day9 


# 按日期分组进行统计数据

## 数据库中查找

```

SELECT

	DATE_FORMAT(created_at, "%Y-%m-%d") AS date,

	SUM(total) AS money,

	count(*) AS count

FROM

	orders

WHERE

	shop_id = 19

GROUP BY

	date;

```

##   在方法中调用

```php
//在方法中调用

$shop_id=Auth::user()->shop_id;

$datas=  Order::where("shop_id",$shop_id)

 ->Select(DB::raw("sum(total) as money,count(*) as count,DATE_FORMAT(created_at, '%Y-%m-%d') as date"))->groupBy("date")

 ->orderBy("date","desc")

 ->limit(30)

 ->get();

```

# 按日期 和 商品id 进行统计数据

## 在数据库中查找

```php
SELECT

	DATE_FORMAT(created_at, "%Y-%m-%d") AS date,

	goods_id,

	goods_name,

	sum(amount) as nums

FROM

	order_goods

WHERE

	order_id IN (26, 31, 32)

GROUP BY date,goods_id;

```

## 在方法中调用

```php
 public function stat()

    {

        $order_id = [];

        //通过user_id 找到shopID

        $shop_id = Auth::user()->shop_id;

        //通过shopID找到所有的已付款的订单id

        datas = Order::where("shop_id", $shop_id)

            ->where("status", ">=", 1)

            ->get();

//        var_dump($datas->toArray());exit;

        foreach ($datas as $data) {

            order_id[] = $data->id;

        }

        goods=  OrderGood::whereIn("order_id", $order_id)

            ->Select(DB::raw("goods_id,goods_name,sum(amount) as nums ,DATE_FORMAT(created_at, '%Y-%m-%d') as date"))

            ->groupBy("date","goods_id")

            ->orderBy("date")

            ->get();

       return view("shop.order.goodstat",compact("goods"));

    }

```




# Day10 


# RABC实现
### 文档
```php
https://laravel-china.org/articles/9842/user-role-permission-control-package-laravel-permission-usage-description
```
1. 安装 composer require spatie/laravel-permission -vvv

2. 创建数据迁移 php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"

3. 执行数据迁移 php artisan migrate

4. 生成配置文件 php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"

5. 在Admin模型中 use HasRoles
 
   protected $guard_name = 'admin';

   ```
   <?php
   
   namespace App\Models;
   
   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Foundation\Auth\User as Authenticatable;
   use Spatie\Permission\Traits\HasRoles;
   
   class Admin extends Authenticatable
   {
       //引入
       use HasRoles;
       protected $guard_name = 'admin';
   }
   ```

6. 添加权限

   ```
   php artisan make:controller Admin/PermissionController;
   
    public function add()
    {

        if (\request()->isMethod("post")) {
            //        接收参数
       $data=\request()->all(); // 给接收的数据中添加 guard_name = admin 以写进数据库
          
            $data["guard_name"]="admin";
            //添加一个权限   权限名称必需是路由的名称  后面做权限判
       
           $per=Permission::create($data);
            if($per){
                return back()->with("success","添加成功");
            }
        }
        return view("admin.per.add");
    }
   ```

7. 角色添加 同时给该角色同步权限

   ```
   
   php artisan make:controller Admin/RoleController
      public function add(Request $request){
   
   
           if ($request->isMethod('post')){
   
   
              // dd($request->post('per'));
               //接收参数
               $data['name']=$request->post('name');
               $data['guard_name']="admin";
   
   
               //创建角色
               $role=Role::create($data);
   
               //还给给角色添加权限
               $role->syncPermissions($request->post('per'));
   
               //跳转并提示
               return redirect()->route('admin.role.index')->with('success','创建'.$role->name."成功");
   
   
           }
   
           //得到所有权限
           $pers=Permission::all();
   
           return view('admin.role.add',compact('pers'));
   
       }
   }
   ```

8. 用户指定角色

   ```
    /**
        * 添加用户
        */
       public function add(Request $request)
       {
           if ($request->isMethod('post')){
   
   
               // dd($request->post('per'));
               //接收参数
               $data=$request->post();
               $data['password']=bcrypt($data['password']);
   
   
               //创建用户
               $admin=Admin::create($data);
   
   
               //给用户对象添加角色 同步角色
               $admin->syncRoles($request->post('role'));
   
               //通过用户找出所有角色
              // $admin->roles();
   
               //跳转并提示
               return redirect()->route('admin.index')->with('success','创建'.$admin->name."成功");
   
   
           }
           //得到所有权限
           $roles=Role::all();
   
           return view('admin.admin.add',compact('roles'));
       }
   ```

9. 判断权限 在E:\web\ele\app\Http\Controllers\Admin\BaseController.php 添加如下代码

   ```
   <?php
   
   namespace App\Http\Controllers\Admin;
   
   use Illuminate\Http\Request;
   use App\Http\Controllers\Controller;
   use Illuminate\Support\Facades\Auth;
   use Closure;
   use Illuminate\Support\Facades\Route;
   
   class BaseController extends Controller
   {
   
       public function __construct()
       {
           $this->middleware('auth:admin')->except("login");
   
           //在这里判断用户有没有权限
           //dump(Auth::guard('admin')->user());
           $this->middleware(function ($request, Closure $next) {
   
               $admin = Auth::guard('admin')->user();
   
               //判断当前路由在不在这个数组里，不在的话才验证权限，在的话不验证，还可以根据排除用户ID为1
               if (!in_array(Route::currentRouteName(), ['admin.login', 'admin.logout']) && $admin->id !== 1) {
                   //判断当前用户有没有权限访问 路由名称就是权限名称
                   if ($admin->can(Route::currentRouteName()) === false) {
   
                       /* echo view('admin.fuck');
                         exit;*/
                       //显示视图 不能用return 只能exit
                       exit(view('admin.fuck'));
   
                   }
   
               }
   
   
               return $next($request);
   
           });
       }
   }
   ```

10. 创建admin.fuck视图

    ```
    @extends("layouts.admin.default")
    
    @section("content")
       没有权限
    @endsection
    ```
11.获取角色权限：

    ```php
    <td>{{ str_replace(['[',']','"'],'', $role->permissions()->pluck('name')) }}</td>
    ```
    
12. 得到所有路径

```php
//得到所有路由
$routes=Route::getRoutes();
//定义数组
$urls=[];
foreach ($routes as $k=>$value){

    //dd($value->action);
    if ($value->action['namespace']==="App\Http\Controllers\Admin"){
        $urls[]=$value->action['as'];
    }
}

```

13. 判断是否有权限
```php
$role->hasPerminssionTo($role->name)
```
14.获取用户的角色信息
```php
{{str_replace(['[',']','"'],'',json_encode($admin->getRoleNames(),JSON_UNESCAPED_UNICODE))}}
```

# Day11

# 邮件发送

1. 配置.env

   ```
   MAIL_DRIVER=smtp
   MAIL_HOST=smtp.qq.com
   MAIL_PORT=25
   MAIL_USERNAME=kang6728@163.com
   MAIL_PASSWORD=php0325
   MAIL_ENCRYPTION=null
   ```

2. php artisan make:mail OrderShipped

3. 打开E:\web\ele\app\Mail\OrderShipped.php

   ```
   <?php
   
   namespace App\Mail;
   
   use App\Models\Order;
   use Illuminate\Bus\Queueable;
   use Illuminate\Mail\Mailable;
   use Illuminate\Queue\SerializesModels;
   use Illuminate\Contracts\Queue\ShouldQueue;
   
   class OrderShipped extends Mailable
   {
       use Queueable, SerializesModels;
   
       //声明一个仅供的属性用来存订单模型对象
       public $order;
       /**
        * Create a new message instance.
        *
        * @return void
        */
       public function __construct(Order $order)
       {
           //从外部传入订单实例
           $this->order=$order;
       }
   
       /**
        * Build the message.
        *
        * @return $this
        */
       public function build()
       {
           return $this
               ->from("kang6728@163.com")
               ->view('mail.order',['order'=>$this->order]);
       }
   }
   ```

4. 邮件预览 在路由中

   ```
     //测试
       Route::get('/mail', function () {
           $order =\App\Models\Order::find(26);
   
           return new \App\Mail\OrderShipped($order);
       });
   ```

5. 发送邮件

   ```
           $order =\App\Models\Order::find(26);
   
           $user=User::where('shop_id',$id)->first();
           //通过审核发送邮件
           Mail::to($user)->send(new OrderShipped($order));
           
          
           
   ```

# 发邮件总结

```php 
        //流程是：将$order 通过 new OrderShipped($order) 对象时传到 OrderShipped这个类中的 

        public function __construct(Order $order)
    	{
        $this->order=$order;  } 
  		
     
       // 再进入到视图文件mail.order
        public function build()
    
     		 {
    
            return $this
    
                ->from("36054222@qq.com")
    
                ->view('mail.order',["order"=>$this->order]);
    
      		  }

```
# 导航管理
```php
        //控制中获取所有的路径
        $routes = Route::getRoutes();
        $urls = [];
        foreach ($routes as $k => $route) {
            set_time_limit(0);
//            dump($route);
            if (isset($route->action["namespace"]) && $route->action["namespace"] == "App\Http\Controllers\Admin") {
            $urls[] = $route->action["as"];
            }
        }
```
```php
//前端显示
      {{--循环显示首层导航--}}
        @foreach(\App\Models\Nav::where('pid',0)->get() as $v1)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$v1->name}} </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route($v1->url)  }}">{{$v1->name}}</a></li>
                    @foreach(\App\Models\Nav::where("pid",$v1->id)->get() as $v2)
                        {{--判断是否有can（）中的权限，--}}
             @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->can($v2->url))
{{--有权限才显示二级导航--}}
               <li><a href="{{ route($v2->url) }}">{{$v2->name}}</a></li>

                        @endif
                    @endforeach
                </ul>
            </li>
        @endforeach
                        <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
               欢迎您{{\Illuminate\Support\Facades\Auth::guard("admin")->user()->name}}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route("admin.index")}}">管理员列表</a></li>
                                <li><a href="{{route("per.index")}}">权限管理</a></li>
                                <li><a href="{{route("role.index")}}">角色管理</a></li>
                                <li><a href="{{route("admin.logout")}}">退出登录</a></li>
                            </ul>
                        </li>
```