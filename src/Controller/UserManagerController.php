<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/8/16
 * Time: 17:47
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\PublicTool\Tool;

class UserManagerController extends AppController {

    /**
     * 用户列表主页
     */
    public function index($id = null) {
        if ($id) {
            $highStr = $id;
            $this->paginate = [
                'limit' => 13
            ];
            $user = TableRegistry::get('WoUsers');
            $users = $user->getAllUserInfo();
            $userInfo = $this->paginate($users);
            $operateInfo = $this->getOperateInfoByManagerId($id);
            $this->set(compact('userInfo'));
            $this->set(compact('operateInfo'));
            $this->set(compact('highStr'));
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'UserManagerController - Index - Fatal Error';
            exit;
        }
    }

    /**
     * 新建用户
     */
    public function addUser($id = null) {
        if ($this->request->is('post') && $this->request->data) {
            $userValues = array();
            if ($this->request->data('username')) {$userValues['username'] = $this->request->data('username');}
            if ($this->request->data('password')) {$userValues['password'] = $this->request->data('password');}
            if ($this->request->data('realname')) {$userValues['realname'] = $this->request->data('realname');}
            if ($this->request->data('email')) {$userValues['email'] = $this->request->data('email');}
            if ($this->request->data('phone_number')) {$userValues['phone_number'] = $this->request->data('phone_number');}
            $userValues['deleted'] = 0;
            if ($userValues) {
                $userValues['created_at'] = date('Y-m-d H:i:s');
                $userValues['updated_at'] = date('Y-m-d H:i:s');
            }
            $user = TableRegistry::get('WoUsers');
            $result = $user->insertUserByValuesArray($userValues);
            if ($result) {
                $userRole = TableRegistry::get('WoUserRoles');
                $userRoleValues = array();
                $userRoleValues['user_id'] = $user->getUserIdByRealName($userValues['realname']);
                if ($this->request->data('role')) {$userRoleValues['role_id'] = $this->request->data('role');}
                $res = $userRole->insertRelationByValuesArray($userRoleValues);
                if ($res) {
                    $this->redirect(['controller' => 'UserManager', 'action' => 'index', $id]);
                } else {
                    echo 'Fatal Error';exit;
                }
            } else {
                $this->showTipMessage("用户已存在");
            }
            $this->set('highLight', $this->request->params['controller']);
        } else {
            $this->set('highLight', $this->request->params['controller']);
        }
    }

    /**
     * 编辑用户
     * @param null $id 分类ID( = $highStr)
     * @param null $userId  用户ID
     */
    public function editUser($id = null, $userId = null) {
        if ($id && $userId) {
            if ($this->request->is('post') && $this->request->data) {
                $values = array();
                if ($this->request->data('username')) {$values['username'] = $this->request->data('username');}
                if ($this->request->data('realname')) {$values['realname'] = $this->request->data('realname');}
                if ($this->request->data('password')) {$values['password'] = $this->request->data('password');}
                if ($this->request->data('email')) {$values['email'] = $this->request->data('email');}
                if ($this->request->data('phone_number')) {$values['phone_number'] = $this->request->data('phone_number');}
                $user = TableRegistry::get('WoUsers');
                $res = $user->modifyUserInfoByUserIdAndValues($userId, $values);
                if ($res) {
                    $relationValues = array();
                    if ($this->request->data('role')) {$relationValues['role_id'] = $this->request->data('role');}
                    $userRole = TableRegistry::get('WoUserRoles');
                    $result = $userRole->modifyRelationByUserIdAndValues($userId, $relationValues);
                    if ($result) {
                        $this->redirect(['controller' => 'UserManager', 'action' => 'index', $id]);
                    } else {
                        echo 'modifyRelationByUserIdAndValues';exit;
                    }
                } else {
                    echo 'modifyUserInfoByUserIdAndValues error';exit;
                }
            } else {
                $user = TableRegistry::get('WoUsers');
                $userInfo = $user->getUserInfoByUserId($userId);
                $this->set(compact('userInfo'));
            }
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'UserManagerController - editUser - Fatal Error';
            exit;
        }
    }

    /**
     * 删除用户
     * @param null $id 分类ID( = $highStr)
     * @param null $userId  用户ID
     */
    public function deleteUser($id = null, $userId = null) {
        if ($id && $userId) {
            $user = TableRegistry::get('WoUsers');
            $result = $user->deleteUserByUserId($userId);
            if ($result) {
                $this->redirect(['controller' => 'UserManager', 'action' => 'index', $id]);
            } else {
                echo 'Deleted Fail';exit;
            }
        } else {
            echo 'UserManagerController - deleteUser - Fatal Error';
            exit;
        }
    }

    /**
     * 通过管理ID从缓存中取可执行操作权限
     * @param $id
     * @return null
     */
    public function getOperateInfoByManagerId($id) {
        foreach ($this->request->session()->read('manager_info') as $managerInfo) {
            if ($managerInfo['id'] == $id) {
                $operateInfo = $managerInfo['operate_info'];
                return $operateInfo;
            }
        }
        return null;
    }

}