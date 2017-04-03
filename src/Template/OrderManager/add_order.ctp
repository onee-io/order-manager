
<div class="panel panel-default">
    <div class="panel-heading">新建工单</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="/order-manager/add-order">
            <div class="form-group">
                <label for="classification" class="col-sm-2 control-label">工单分类</label>
                <div class="col-sm-8">
                    <select id="classification" name="classification" class="form-control input-sm" required>
                        <option value="">--请选择--</option>
                        <?php
                            $classificationInfoList = $this->request->session()->read('classification_info');
                            foreach ($classificationInfoList as $classificationInfo) {
                                if ($classificationInfo['query_type'] == 3) {
                                    echo '<option value="'.$classificationInfo['id'].'">'.$classificationInfo['name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">标题</label>
                <div class="col-sm-8">
                    <input type="text" name="title" class="form-control input-sm" id="title" placeholder="请输入工单标题" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="content" class="col-sm-2 control-label">内容</label>
                <div class="col-sm-8">
                    <!-- <div id="odiv" style="display:none;position:absolute;z-index:100;">
                        <img src="/assets/pic/sx.png" title="缩小" border="0" alt="缩小" onclick="sub(-1);"/>
                        <img src="/assets/pic/fd.png" title="放大" border="0" alt="放大" onclick="sub(1)"/>
                        <img src="/assets/pic/cz.png" title="重置" border="0" alt="重置" onclick="sub(0)"/>
                        <img src="/assets/pic/sc.png" title="删除" border="0" alt="删除" onclick="del();odiv.style.display='none';"/>
                    </div> -->
                    <div onmousedown="show_element(event)" style="clear:both" id="customized-buttonpane" class="editor"></div>
                </div>
            </div>
            
            <!-- <div class="form-group">
                <label for="content" class="col-sm-2 control-label">内容3</label>
                <div class="col-sm-8">
                    <textarea name="content" id="content" rows="10" class="form-control input-sm" placeholder="请输入内容" style="resize:none" required></textarea>
                </div>
            </div> -->
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary" onclick="check_fields();">提交工单</button>
                    <!-- <button type="button" class="btn btn-sm btn-default">重置</button> -->
                </div>
            </div>
        </form>
    </div>
</div>
<div style="height: 60px;"></div>