<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/8/16
 * Time: 17:58
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ClassificationManagerController extends AppController {

    /**
     * 分类列表主页
     * @param null $id  分类ID( = $highStr)
     */
    public function index($id = null) {
        $this->updateSessionClassificationInfo();
        if ($id) {
            $highStr = $id;
            $this->paginate = [
                'limit' => 13
            ];
            $classification = TableRegistry::get('WoClassifications');
            $classifications = $classification->getAllClassificationInfo();
            $classificationInfo = $this->paginate($classifications);
            $operateInfo = $this->getOperateInfoByManagerId($id);
            $this->set(compact('classificationInfo'));
            $this->set(compact('operateInfo'));
            $this->set(compact('highStr'));
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'ClassificationManagerController - Index - Fatal Error';
            exit;
        }
    }

    /**
     * 新建分类
     * @param null $id  分类ID( = $highStr)
     */
    public function addClassification($id = null) {
        if ($this->request->is('post') && $this->request->data) {
            $classificationName = null;
            if ($this->request->data('classification_name')) {$classificationName = $this->request->data('classification_name');}
            $classification = TableRegistry::get('WoClassifications');
            $resId = $classification->insertClassificationByClassification($classificationName);
            if ($resId) {
                $role = TableRegistry::get('WoRoles');
                $roleIdList = $role->getRoleIdListByRoleType(3);
                $roleClassification = TableRegistry::get('WoRoleClassifications');
                $res = $roleClassification->addAdminPowerByRoleIdListAndClassificationId($roleIdList, $resId);
                if ($res) {
                    $this->redirect(['controller' => 'ClassificationManager', 'action' => 'index', $id]);
                }
            }
            $this->set('highLight', $this->request->params['controller']);
        } else {
            $this->set('highLight', $this->request->params['controller']);
        }
    }

    /**
     * 编辑分类
     * @param null $id  分类ID( = $highStr)
     * @param null $classificationId  分类ID
     */
    public function editClassification($id = null, $classificationId = null) {
        if ($id && $classificationId) {
            $classification = TableRegistry::get('WoClassifications');
            if ($this->request->data) {
//                debug($this->request->data);exit;
                $classificationName = $this->request->data('classification_name');
                $res = $classification->modifyClassificationNameByClassificationIdAndValue($classificationId, $classificationName);
                if ($res) {
                    $this->redirect(['controller' => 'ClassificationManager', 'action' => 'index', $id]);
                }
            }
            $classificationInfo = $classification->getClassificationInfoByClassificationId($classificationId);
            $this->set(compact('classificationInfo'));
            $this->set('highLight', $this->request->params['controller']);
        } else {
            echo 'ClassificationManagerController - editClassification - Fatal Error';
            exit;
        }
    }

    /**
     * 删除分类
     * @param null $id  分类ID( = $highStr)
     * @param null $classificationId  分类ID
     */
    public function deleteClassification($id = null, $classificationId = null) {
        if ($id && $classificationId) {
            $classification = TableRegistry::get('WoClassifications');
            $res = $classification->deleteClassificationByClassificationId($classificationId);
            if ($res) {
                $this->redirect(['controller' => 'ClassificationManager', 'action' => 'index', $id]);
            }
        } else {
            echo 'ClassificationManagerController - deleteClassification - Fatal Error';
            exit;
        }
    }

    /**
     * 更新侧边栏Session信息
     */
    public function updateSessionClassificationInfo() {
        $roleId = $this->request->session()->read('role_info')['role_id'];
        $roleClassification = TableRegistry::get('WoRoleClassifications');
        $classificationIdList = $roleClassification->getClassificationIdListByRoleId($roleId);
        if ($classificationIdList) {
            // 分类权限
            $classification_info = array();
            $classifications = TableRegistry::get('WoClassifications');
            foreach ($classificationIdList as $classificationId) {
                if ('工单分类' == $classifications->getClassificationTypeByClassificationId($classificationId)) {
                    $classificationInfo = $classifications->getClassificationInfoByClassificationId($classificationId);
                    if ($classificationInfo) {$classification_info[] = $classificationInfo;}
                }
            }
            if ($classification_info) {
                $classification_session = array();
                foreach ($classification_info as $classification) {
                    $classification_session[] = [
                        'id' => $classification['id'],
                        'type' => '工单分类',
                        'name' => $classification['classification_name'],
                        'controller' => $classification['controller'],
                        'action' => $classification['action'],
                        'query_type' => $classification['query_type'],
                        'operate_info' => $this->initOperateInfo($classification['id'])
                    ];
                }
                $this->request->session()->write([
                    'classification_info' => $classification_session
                ]);
            }
        }
    }

    /**
     * 初始化分类可执行操作
     * @param $classificationId
     * @return array|null
     */
    public function initOperateInfo($classificationId){
        if ($this->request->session()->check('role_info')) {
            $roleType = $this->request->session()->read('role_info')['role_type'];
            if ($classificationId) {
                $roleOperate = TableRegistry::get('WoRoleOperates');
                $operateIdList = $roleOperate->getOperateListByRoleType($roleType);
                if ($operateIdList) {
                    $operates = TableRegistry::get('WoOperates');
                    $operateList = array();
                    foreach ($operateIdList as $operateId) {
                        $operateInfo = $operates->getOperateInfoByOperateId($operateId);
                        $operateList[] = [
                            'name' => $operateInfo['operate_name'],
                            'controller' => $operateInfo['controller'],
                            'action' => $operateInfo['action']
                        ];
                    }
                    return $operateList;
                }
                return null;
            }
            return null;
        }
        return null;
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