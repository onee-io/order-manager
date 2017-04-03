<?php
use Cake\ORM\TableRegistry;
?>
<style type="text/css">
    .my_checkbox_box{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 5px;
    }
    .my_checkbox{
        display:inline;
        margin-right:12px;
    }
    .my_checkbox_label{
        font-weight: normal;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">新建角色</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="/role-manager/add-role/2">
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label">角色类型</label>
                <div class="col-sm-8">
                    <select id="role" name="role_type" class="form-control input-sm" required>
                        <option value="">--请选择--</option>
                        <option value="1">发起者</option>
                        <option value="2">受理者</option>
                        <option value="3">管理员</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="role_name" class="col-sm-2 control-label">角色名称</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="role_name" name="role_name" placeholder="请输入角色名称" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">可查看分类</label>
                <div class="col-sm-8">
                    <div class="panel panel-default">
                        <div class="my_checkbox_box">
                            <?php
                                $classification = TableRegistry::get('WoClassifications');
                                $classificationInfos = $classification->getAllClassificationInfo();
                                foreach ($classificationInfos as $classificationInfo) {
                                    echo '<div class="my_checkbox">';
                                    echo '<input id="'.$classificationInfo['classification_name'].'"type="checkbox" class="checkbox-inline" name="classification[]" style="margin-right:5px;" value="'.$classificationInfo['id'].'">';
                                    echo '<label for="'.$classificationInfo['classification_name'].'" class="control-label my_checkbox_label">'.$classificationInfo['classification_name'].'</label>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">提交</button>
                    <!--<button type="button" class="btn btn-sm btn-default">重置</button>-->
                </div>
            </div>
        </form>
    </div>
</div>