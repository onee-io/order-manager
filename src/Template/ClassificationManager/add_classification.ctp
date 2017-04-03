<div class="panel panel-default">
    <div class="panel-heading">新建分类</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="/classification-manager/add-classification/3">
            <div class="form-group">
                <label for="classification_name" class="col-sm-2 control-label">分类名称</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="classification_name" name="classification_name" placeholder="请输入分类名称" required>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>