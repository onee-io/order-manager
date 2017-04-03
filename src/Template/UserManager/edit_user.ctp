<?php
use Cake\ORM\TableRegistry;
?>
<div class="panel panel-default">
    <div class="panel-heading">编辑用户信息</div>
    <div class="panel-body">
        <form class="form-horizontal" method="post" action="/user-manager/edit-user/1/<?= $userInfo['id'] ?>">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="username" name="username" placeholder="请输入用户名" required value="<?= $userInfo['username'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="realname" class="col-sm-2 control-label">真实姓名</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="realname" name="realname" placeholder="请输入真实姓名" required value="<?= $userInfo['realname'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="password" name="password" placeholder="请输入密码" required value="<?= $userInfo['password'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">电子邮箱</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="email" name="email" placeholder="请输入电子邮箱" required value="<?= $userInfo['email'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="phone_number" class="col-sm-2 control-label">手机号</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="phone_number" name="phone_number" placeholder="请输入手机号" required value="<?= $userInfo['phone_number'] ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="role" class="col-sm-2 control-label">所属角色</label>
                <div class="col-sm-8">
                    <select id="role" name="role" class="form-control input-sm" required>
                        <option value="">--请选择--</option>
                        <?php
                            $userRole = TableRegistry::get('WoUserRoles');
                            $roleId = $userRole->getRoleIdListByUserId($userInfo['id'])[0];
                            $roles = TableRegistry::get('WoRoles');
                            $roleInfo = $roles->getAllRoleInfo()->toArray();
                            foreach ($roleInfo as $role) {
                                if ($role['id'] == $roleId) {
                                    echo '<option value="'.$role['id'].'" selected>'.$role['role_name'].'</option>';
                                } else {
                                    echo '<option value="'.$role['id'].'">'.$role['role_name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">确认修改</button>
                    <!--<button type="button" class="btn btn-sm btn-default">重置</button>-->
                </div>
            </div>
        </form>
    </div>
</div>