#Installation

PHP 5.4+ , and Composer are required.

To get the latest version of Laravel Exceptions, simply add the following line to the require block of your composer.json file:
```
"lichv/laravel-ueditor": "^0.1"
```

You'll then need to run composer install or composer update to download it and have the autoloader updated.

Once Laravel Exceptions is installed, you need to register the service provider. Open up config/app.php and add the following to the providers key.
```
'Lichv\UEditor\UEditorServiceProvider'
```
then run
```
php artisan vendor:publish
```
#配置

若以上安装没问题,自定义项目配置文件会在 config/laravel-u-editor.php (会自动生成)
```
    'core' => [
        'route' => [
            'middleware' => 'auth',
        ],
    ],
```
middleware 相当重要,请根据自己的项目设置,比如如果在后台使用,请设置为后台的auth middleware. 如果是单纯本机测试,请将 // 'middleware' => 'auth', 直接注释掉,如果留 'middleware'=>''空值,会产生bug,原因不详.

所有UEditor 的官方资源,会放在 public/laravel-u-editor/ ,可以根据自己的需求,更改.

Usage

in your <head> block just put
```
@include('UEditor::head');
```
it will require assets.

if need,u can change the resources\views\vendor\UEditor\head.blade.php to fit your customization .

ok,all done.just use the UEditor.
```
<!-- 加载编辑器的容器 -->
<script id="container" name="content" type="text/plain">
    这里写你的初始化内容
</script>

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
        ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.    
    });
</script>
```
