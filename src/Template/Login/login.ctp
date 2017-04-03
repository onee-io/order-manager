<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登陆</title>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <style type="text/css">
        .login-box {margin-top: 60%;}
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="login-box">
                <div class="panel panel-default">
                    <div class="panel-heading">工单系统登录</div>
                    <div class="panel-body">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <form class="form-horizontal" method="post"  action="/login/checkInfo">
                                <div class="form-group">
                                    <input type="text"  name="username" class="form-control" placeholder="请输入用户名..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="请输入密码..." required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">登录</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<?= $this->Html->script('jquery-2.2.0.min.js'); ?>
<?= $this->Html->script('bootstrap.min.js'); ?>
</body>
</html>