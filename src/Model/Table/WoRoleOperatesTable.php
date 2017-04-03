<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/26/16
 * Time: 18:00
 */

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * 角色操作关联表
 * Class WoRoleOperatesTable
 * @package App\Model\Table
 * id => ID
 * role_type => 用户类型
 * operate_id => 操作ID
 */
class WoRoleOperatesTable extends Table {

    /**
     * 通过角色类型获取操作ID列表
     * @param $roleType
     * @return array|null
     */
    public function getOperateListByRoleType($roleType) {
        if ($roleType) {
            $results = $this->find()->where([
                'role_type' => $roleType
            ])->toArray();
            $res = array();
            foreach ($results as  $result) {
                $res[] = $result['operate_id'];
            }
            return $res;
        }
        return null;
    }

}