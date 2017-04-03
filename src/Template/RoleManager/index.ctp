<?php
use Cake\ORM\TableRegistry;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        角色列表
        <?php
            if (isset($operateInfo)) {
                foreach ($operateInfo as $operate) {
                    if ($operate['name'] == '新建角色') {
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
            <th>角色名称</th>
            <th>角色类型</th>
            <th width="170">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($roleInfo->count()) {
                //debug($roleInfo);exit;
                $roleTable = TableRegistry::get('WoRoles');
                foreach ($roleInfo as $role) {
                    echo '<tr>';
                    echo '<td></td>';
                    echo '<td>'.h($role->role_name).'</td>';
                    echo '<td>'.h($roleTable->getRoleTypeByRoleId($role->id)).'</td>';
                    echo '<td>';
                    if (isset($operateInfo)) {
                        foreach ($operateInfo as $operate) {
                            if ($operate['name'] == '编辑角色') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $role['id']]);
                            }
                            if ($operate['name'] == '删除角色') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $role['id']]);
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
        if ($roleInfo->count()) {
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