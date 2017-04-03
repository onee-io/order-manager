<?php
use Cake\ORM\TableRegistry;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        用户列表
        <?php
            if (isset($operateInfo)) {
                foreach ($operateInfo as $operate) {
                    if ($operate['name'] == '新建用户') {
                        echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr], ['class' => 'pull-right btn btn-xs btn-primary']);
                    }
                }
            }
        ?>
    </div>
    <table class="table table-responsive">
        <thead>
        <tr>
            <th>用户名</th>
            <th>真实姓名</th>
            <th>角色</th>
            <th>电子邮件</th>
            <th>手机号</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ($userInfo->count()) {
                //debug($userInfo);exit;
                $userRole = TableRegistry::get('WoUserRoles');
                $role = TableRegistry::get('WoRoles');
                foreach ($userInfo as $user) {
                    echo '<tr>';
                    echo '<td>'.h($user->username).'</td>';
                    echo '<td>'.h($user->realname).'</td>';
                    $roleName = $role->getRoleNameByRoleId($userRole->getRoleIdListByUserId($user->id)[0]);
                    echo '<td>'.h($roleName).'</td>';
                    echo '<td>'.h($user->email).'</td>';
                    echo '<td>'.h($user->phone_number).'</td>';
                    echo '<td>'.h($user->created_at->i18nFormat('yyyy-MM-dd HH:mm:ss')).'</td>';
                    echo '<td>';
                    if (isset($operateInfo)) {
                        foreach ($operateInfo as $operate) {
                            if ($operate['name'] == '编辑用户') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $user['id']]);
                            }
                            if ($operate['name'] == '删除用户') {
                                echo $this->Html->link(__($operate['name'].' '), ['controller' => $operate['controller'], 'action' => $operate['action'], $highStr, $user['id']]);
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
        if ($userInfo->count()) {
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