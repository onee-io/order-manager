<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>工单系统</title>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('bootstrap-datetimepicker.min.css') ?>
    <?= $this->Html->css('trumbowyg.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top" role="navigation" >
    <div class="container">
        <div class="navbar-header">
            <?= $this->Html->link(__('工单系统'), ['controller' => 'OrderManager', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if ($this->request->session()->check('user_info')) {
                        echo '<li><a>'.$this->request->session()->read('role_info')['role_name'].':&nbsp&nbsp&nbsp'
                              .$this->request->session()->read('user_info')['realname'].'</a></li>';
                    }
                ?>
                <li><?= $this->Html->link(__('注销'), ['controller' => 'Login' , 'action' => 'logout']) ?></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <!-- 侧边栏 -->
        <div class="col-md-2">
            <?php
                // 管理
                if ($this->request->session()->check('manager_info')) {
                    $manager_info = $this->request->session()->read('manager_info');
                    echo '<div class="panel panel-default"><div class="panel-heading">'.$manager_info[0]['type'].'</div><div class="list-group">';
                    foreach ($manager_info as $manager) {
                        if (isset($highLight)) {
                            $itemClass = $manager['controller'] == $highLight?'list-group-item active':'list-group-item';
                        } else {
                            $itemClass = 'list-group-item';
                        }
                        echo $this->Html->link(__($manager['name']),['controller' => $manager['controller'], 'action' => $manager['action'], $manager['id']],['class' => $itemClass]);
                    }
                    echo '</div></div>';
                }
                // 操作
                if ($this->request->session()->check('operate_info')) {
                    $operate_info = $this->request->session()->read('operate_info');
                    echo '<div class="panel panel-default"><div class="panel-heading">'.$operate_info[0]['type'].'</div><div class="list-group">';
                    foreach ($operate_info as $operate) {
                        if (isset($highLight)) {
                            $itemClass = $operate['action'] == $highLight?'list-group-item active':'list-group-item';
                        } else {
                            $itemClass = 'list-group-item';
                        }
                        echo $this->Html->link(__($operate['name']),['controller' => $operate['controller'], 'action' => $operate['action']],['class' => $itemClass]);
                    }
                    echo '</div></div>';
                }
                // 分类
                if ($this->request->session()->check('classification_info')) {
                    $classification_info = $this->request->session()->read('classification_info');
                    echo '<div class="panel panel-default"><div class="panel-heading">'.$classification_info[0]['type'].'</div><div class="list-group">';
                    foreach ($classification_info as $classification) {
                        $queryType = $classification['query_type'];
                        $highCode = $classification['id'];
                        echo $this->Html->link(__($classification['name']),['controller' => $classification['controller'], 'action' => $classification['action'], $queryType, $highCode],['id' => $highCode,'class' => 'list-group-item']);
                    }
                    echo '</div></div>';
                }
            ?>
        </div>
        <!-- 内容区域 -->
        <div class="col-md-10">
            <?= $this->fetch('content'); ?>
        </div>
    </div>
</div>
<div class="panel-footer" style="position:fixed;bottom:0px;right:0px;left:0px;z-index:100;">
    <div class="container">
        <p class="text-muted">Copyright ©️ 五彩点点(北京)信息技术有限公司</p>
    </div>
</div>

<?= $this->Html->script('jquery-2.2.0.min.js'); ?>
<?= $this->Html->script('bootstrap.min.js'); ?>
<?= $this->Html->script('bootstrap-datetimepicker.min.js') ?>
<?= $this->Html->script('bootstrap-wysiwyg.js') ?>
<?= $this->Html->script('trumbowyg.js') ?>
<?= $this->Html->script('trumbowyg.base64.min.js') ?>

</body>
</html>
<script>
    $(function(){
        <?php if(isset($highStr)){ ?>
            $('#<?php echo $highStr ?>').get(0).className = 'list-group-item active';
        <?php } ?>
    })
</script>