<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 10:19
 */

namespace App\Model\Table;


use Cake\ORM\Table;


/**
 * @name 角色表
 * Class WoRolesTable 
 * @package App\Model\Table
 * id => ID
 * role_name => 角色名称
 * role_type => 角色类型 => 1.发起人 2.受理人 3.管理员
 * deleted => 0.为删除 1.已删除
 */
class WoRolesTable extends Table {

    /**
     * @name 通过角色id获取角色信息
     * @param $roleId
     * @return mixed|null
     */
    public function getRoleInfoByRoleId($roleId) {
        if ($roleId) {
            $res = $this->find()
                ->where([
                    'id' => $roleId,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }
    
    /**
     * @name 通过角色ID获取角色名称
     * @param $roleId
     * @return null|string
     */
    public function getRoleNameByRoleId($roleId) {
        if ($roleId) {
            $res = $this->find()
                ->where([
                    'id' => $roleId,
                    'deleted' => 0
                ])
                ->first();
            return $res['role_name'];
        }
        return null;
    }

    /**
     * @name 通过角色ID获取角色类型
     * @param $roleId
     * @return null|string
     */
    public function getRoleTypeByRoleId($roleId) {
        if ($roleId) {
            $res = $this->find()
                ->where([
                    'id' => $roleId,
                    'deleted' => 0
                ])
                ->first();
            switch ($res['role_type']) {
                case 1:
                    // 发起人
                    return '发起者';
                case 2:
                    // 受理人
                    return '受理者';
                case 3:
                    // 管理员
                    return '管理员';
                default:
                    return null;
            }
        }
        return null;
    }

    /**
     * 获取所有角色信息
     * @return $this
     */
    public function getAllRoleInfo() {
        return $this->find()->where([
            'deleted' => 0,
//            'id >' => 3
        ]);
    }

    /**
     * 添加一个新的角色
     * @param $values
     * @return mixed|null
     */
    public function insertRoleByValues($values) {
        if ($values) {
            $res = self::newEntity();
            $res->role_name = $values['role_name'];
            $res->role_type = $values['role_type'];
            $res->deleted = $values['deleted'];
            self::save($res);
            return $res->id;
        }
        return null;
    }

    /**
     * 获取某一类型的所有角色ID
     * @param $roleType
     * @return null
     */
    public function getRoleIdListByRoleType($roleType) {
        if ($roleType) {
            $results = $this->find()->where([
                'role_type' => 3
            ])->toArray();
            if ($results){
                $roleIdList = array();
                foreach ($results as $result) {
                    $roleIdList[] = $result['id'];
                }
                return $roleIdList;
            }
            return null;
        }
        return null;
    }

    /**
     * 删除一个角色信息
     * @param $roleId
     * @return null
     */
    public function deletedRoleByRoleId($roleId) {
        if ($roleId) {
            $res = $this->query()->update()->set([
                'deleted' => 1
            ])->where([
                'id' => $roleId
            ])->execute();
            return $res;
        }
        return null;
    }

    /**
     * 修改角色信息
     * @param $roleId
     * @param $values
     * @return null
     */
    public function modifyRoleInfoByRoleIdAndValues($roleId, $values) {
        if ($roleId && $values) {
            $res = $this->query()->update()->set($values)->where([
                'id' => $roleId,
                'deleted' => 0
            ])->execute();
            return $res;
        }
        return null;
    }
}