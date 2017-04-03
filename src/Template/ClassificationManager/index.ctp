<div class="panel panel-default">
    <div class="panel-heading">
        分类列表
        <?php
            if (isset($operateInfo)) {
                foreach ($operateInfo as $operate) {
                    if ($operate['name'] == '新建分类') {
                        echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr], ['class' => 'pull-right btn btn-xs btn-primary']);
                    }
                }
            }
        ?>
    </div>
    <table class="table table-responsive">
        <thead>
        <tr>
            <th width="100"></th>
            <th>分类名称</th>
            <th width="170">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($classificationInfo->count()) {
                //debug($classificationInfo);exit;
                foreach ($classificationInfo as $classification) {
                    echo '<tr>';
                    echo '<td></td>';
                    echo '<td>'.h($classification->classification_name).'</td>';
                    echo '<td>';
                    if (isset($operateInfo)) {
                        foreach ($operateInfo as $operate) {
                            if ($operate['name'] == '编辑分类') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $classification['id']]);
                            }
                            if ($operate['name'] == '删除分类') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $classification['id']]);
                            }
                        }
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="10" class="text-center">暂无记录</td></tr>';
            }
        ?>
        </tbody>
    </table>
</div>
<!-- 分页 -->
<div>
    <?php
        if ($classificationInfo->count()) {
            if ($this->Paginator->numbers()) {
                echo '<ul class="pagination pull-right">';
                echo $this->Paginator->prev('< '.('上一页'));
                echo $this->Paginator->numbers(['modulus' => 3]);
                echo $this->Paginator->next('下一页'.' >');
                echo '</ul>';
            }
        }
    ?>
</div>