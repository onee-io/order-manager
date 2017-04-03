<div class="panel panel-default">
    <div class="panel-heading">修改分类信息</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="/classification-manager/edit-classification/3/<?= $classificationInfo['id'] ?>">
            <div class="form-group">
                <label for="classification_name" class="col-sm-2 control-label">分类名称</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="classification_name" name="classification_name" placeholder="请输入分类名称" required value="<?= $classificationInfo['classification_name'] ?>">
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">确认修改</button>
                </div>
            </div>
        </form>
    </div>
</div>