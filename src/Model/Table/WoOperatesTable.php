<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 11:14
 */

namespace App\Model\Table;


use Cake\ORM\Table;


/**
 * @name 操作表
 * Class WoOperatesTable    
 * @package App\Model\Table
 * id => ID
 * operate_name => 操作名称
 */
class WoOperatesTable extends Table {

    /**
     * @name 通过操作ID获取操作信息
     * @param $operateId
     * @return null|string
     */
    public function getOperateInfoByOperateId($operateId) {
        if ($operateId) {
            $res = $this->find()
                ->where([
                    'id' => $operateId
                ])
                ->first();
            return $res;
        }
        return null;
    }
}