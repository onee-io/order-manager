<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/8/16
 * Time: 17:56
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class RoleManagerController extends AppController {

    /**
     * 角色列表主页
     * @param null $id  分类ID( = $highStr)
     */
    public function index($id = null) {
        if ($id) {
            $highStr = $id;
            $this->paginate = [
                'limit' => 13
            ];
            $role = TableRegistry::get('WoRoles');
            $roles = $role->getAllRoleInfo();
            $roleInfo = $this->paginate($roles);
            $operateInfo = $this->getOperateInfoByManagerId($id);
            $this->set(compact('roleInfo'));
            $this->set(compact('operateInfo'));
            $this->set(compact('highStr'));
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'RoleManagerController - Index - Fatal Error';
            exit;
        }
    }

    /**
     * 新建角色
     * @param null $id  分类ID( = $highStr)
     */
    public function addRole($id = null) {
        if ($this->request->is('post') && $this->request->data) {
//            debug($this->request->data);exit;
            $values = array();
            if ($this->request->data('role_type')) {$values['role_type'] = $this->request->data('role_type');}
            if ($this->request->data('role_name')) {$values['role_name'] = $this->request->data('role_name');}
            if ($values) {
                $values['deleted'] = 0;
                $role = TableRegistry::get('WoRoles');
                $roleId = $role->insertRoleByValues($values);
//                debug($roleId);exit;
                $roleClassification = TableRegistry::get('WoRoleClassifications');
                if ($roleId) {
                    // 添加默认权限
                    switch ($values['role_type']) {
                        case 1:     //发起人
                            $roleClassification->addCreaterPowerByRoleId($roleId);
                            break;
                        case 2:     //受理人
                            $roleClassification->addAccepterPowerByRoleId($roleId);
                            break;
                        case 3:     //管理员
                            $roleClassification->addAdminPowerByRoleId($roleId);
                            break;
                        default:
                            echo 'Fatal Error addRole';
                            exit;
                    }
                    //添加分类权限
                    $classificationIdList = $this->request->data('classification');
                    if ($classificationIdList) {
                        foreach ($classificationIdList as $classificationId) {
                            $roleClassification->addPowerByRoleIdAndClassificationId($roleId, $classificationId);
                        }
                    }
                    $this->redirect(['controller' => 'RoleManager', 'action' => 'index', $id]);
                }
            }
            $this->set('highLight', $this->request->params['controller']);
        } else {
            $this->set('highLight', $this->request->params['controller']);
        }
    }

    /**
     * 编辑角色
     * @param null $id  分类ID( = $highStr)
     * @param null $roleId  角色ID
     */
    public function editRole($id = null, $roleId = null) {
        if ($id && $roleId) {
            $role = TableRegistry::get('WoRoles');
            $roleInfo = $role->getRoleInfoByRoleId($roleId);
            $roleClassification = TableRegistry::get('WoRoleClassifications');
            $classificationIdList = $roleClassification->getClassificationIdListByRoleId($roleId);
            $classification = TableRegistry::get('WoClassifications');
            $classificationIds = array();
            foreach ($classificationIdList as $classificationId) {
                if ($classification->isNormalClassification($classificationId)) {
                    $classificationIds[] = $classificationId;
                }
            }
            if ($this->request->is('post') && $this->request->data) {
                //修改角色信息
                $values = array();
                if ($this->request->data('role_type')) {$values['role_type'] = $this->request->data('role_type');}
                if ($this->request->data('role_name')) {$values['role_name'] = $this->request->data('role_name');}
                if ($values) {
                    $res = $role->modifyRoleInfoByRoleIdAndValues($roleId, $values);
                    if ($res) {
                        //修改分类权限信息
                        $oldClassificationIdList = $classificationIds;
                        $newClassificationIdList = $this->request->data('classification');
//                        debug($oldClassificationIdList);
//                        debug($newClassificationIdList);
                        if ($newClassificationIdList) {
                            foreach ($newClassificationIdList as $classificationId) {
                                if ($oldClassificationIdList == null) {
                                    $roleClassification->addPowerByRoleIdAndClassificationId($roleId, $classificationId);
                                    continue;
                                }
                                //新添分类权限
                                if (!in_array($classificationId, $oldClassificationIdList)) {
                                    $roleClassification->addPowerByRoleIdAndClassificationId($roleId, $classificationId);
                                }
                            }
                        }
                        if ($oldClassificationIdList) {
                            foreach ($oldClassificationIdList as $classificationId) {
                                if ($newClassificationIdList == null) {
                                    $roleClassification->deletePowerByRoleIdAndClassificationId($roleId, $classificationId);
                                    continue;
                                }
                                //删除分类权限
                                if (!in_array($classificationId, $newClassificationIdList)) {
                                    $roleClassification->deletePowerByRoleIdAndClassificationId($roleId, $classificationId);
                                }
                            }
                        }
                    }
                    $this->redirect(['controller' => 'RoleManager', 'action' => 'index', $id]);
                }
            }
            $this->set(compact('roleInfo'));
            $this->set(compact('classificationIds'));
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'RoleManagerController - editRole - Fatal Error';
            exit;
        }
    }

    /**
     * 删除角色
     * @param null $id  分类ID( = $highStr)
     * @param null $roleId  角色ID
     */
    public function deleteRole($id = null, $roleId = null) {
        if ($id && $roleId) {
            $role = TableRegistry::get('WoRoles');
            $res = $role->deletedRoleByRoleId($roleId);
            if ($res) {
                $this->redirect(['controller' => 'RoleManager', 'action' => 'index', $id]);
            } else {
                echo 'RoleManagerController - deleteRole - Fatal Error';
                exit;
            }
        } else {
            echo 'RoleManagerController - deleteRole - Fatal Error';
            exit;
        }
    }

    /**
     * 通过管理ID从缓存中取可执行操作权限
     * @param $id  分类ID
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