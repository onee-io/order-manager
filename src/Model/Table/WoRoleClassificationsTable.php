<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 10:22
 */

namespace App\Model\Table;


use Cake\ORM\Table;


/**
 * @name 角色分类关联表
 * Class WoRoleClassificationTable
 * @package App\Model\Table
 * id => ID
 * role_id => 角色ID
 * classification_id => 分类ID
 */
class WoRoleClassificationsTable extends Table {

    /**
     * @name 通过角色ID获取可查看分类ID列表
     * @param $roleId
     * @return array|null
     */
    public function getClassificationIdListByRoleId($roleId) {
        if ($roleId) {
            $results = $this->find()->hydrate(false)
                ->where([
                    'role_id' => $roleId,
                    'deleted' => 0
                ])
                ->toArray();
            if ($results) {
                $classificationIdList = array();
                foreach ($results as $result) {
                    $classificationIdList[] = $result['classification_id'];
                }
                return $classificationIdList;
            }
            return null;
        }
        return null;
    }

    /**
     * @name 通过分类ID获取所有可以查看此分类的角色ID列表
     * @param $classificationId
     * @return array|null
     */
    public function getRoleIdListByClassificationId($classificationId) {
        if ($classificationId) {
            $results = $this->find()
                ->where([
                    'classification_id' => $classificationId,
                    'deleted' => 0
                ])
                ->toArray();
            if ($results) {
                $roleIdList = array();
                foreach ($results as $result) {
                    $roleIdList[] = $result['role_id'];
                }
                return $roleIdList;
            }
            return null;
        }
        return null;
    }

    /**
     * 新建分类后默认添加管理员权限
     * @param $classificationId
     * @return null
     */
    public function addAdminPowerByRoleIdListAndClassificationId($roleIdList, $classificationId) {
        if ($roleIdList && $classificationId) {
            foreach ($roleIdList as $roleId) {
                $this->query()->insert([
                    'role_id',
                    'classification_id',
                    'deleted'
                ])->values([
                    'role_id' => $roleId,
                    'classification_id' => $classificationId,
                    'deleted' => 0
                ])->execute();
            }
            return true;
        }
        return null;
    }

    /**
     * 发起人默认权限
     * @param $roleId
     * @return bool|null
     */
    public function addCreaterPowerByRoleId($roleId) {
        if ($roleId) {
            $res1 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 4,
                'deleted' => 0
            ])->execute();
            $res2 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 5,
                'deleted' => 0
            ])->execute();
            $res3 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 6,
                'deleted' => 0
            ])->execute();
            if ($res1 && $res2 && $res3) {
                return true;
            }
        }
        return null;
    }

    /**
     * 受理者默认权限
     * @param $roleId
     * @return bool|null
     */
    public function addAccepterPowerByRoleId($roleId) {
        if ($roleId) {
            $res1 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 5,
                'deleted' => 0
            ])->execute();
            $res2 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 7,
                'deleted' => 0
            ])->execute();
            if ($res1 && $res2) {
                return true;
            }
        }
        return null;
    }

    /**
     * 管理元默认权限
     * @param $roleId
     * @return bool|null
     */
    public function addAdminPowerByRoleId($roleId) {
        if ($roleId) {
            $res1 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 1,
                'deleted' => 0
            ])->execute();
            $res2 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 2,
                'deleted' => 0
            ])->execute();
            $res3 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 3,
                'deleted' => 0
            ])->execute();
            $res4 = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => 5,
                'deleted' => 0
            ])->execute();
            if ($res1 && $res2 && $res3 && $res4) {
                return true;
            }
        }
        return null;
    }

    /**
     * 添加一条分类权限
     * @param $roleId
     * @param $classificationId
     * @return null
     */
    public function addPowerByRoleIdAndClassificationId($roleId, $classificationId) {
        if ($roleId && $classificationId) {
            $res = $this->query()->insert([
                'role_id',
                'classification_id',
                'deleted'
            ])->values([
                'role_id' => $roleId,
                'classification_id' => $classificationId,
                'deleted' => 0
            ])->execute();
            return $res;
        }
        return null;
    }

    public function deletePowerByRoleIdAndClassificationId($roleId, $classificationId) {
        if ($roleId && $classificationId) {
            $this->query()->update()->set([
                'deleted' => 1
            ])->where([
                'role_id' => $roleId,
                'classification_id' => $classificationId
            ])->execute();
        }
        return null;
    }
}