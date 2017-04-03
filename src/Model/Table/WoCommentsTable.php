<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 14:11
 */

namespace App\Model\Table;


use Cake\ORM\Table;


/**
 * @name 评论表
 * Class WoCommentsTable   
 * @package App\Model\Table
 * id => ID
 * order_no => 工单编号
 * content => 内容
 * from_user_id => 评论者
 * to_user_id => 被评论者
 * deleted => 0.未删除 1.已删除
 * created_at => 创建时间
 * updated_at => 更新时间
 */
class WoCommentsTable extends Table {

    /**
     * @name 通过工单编号NO获取评论列表
     * @param $orderNo
     * @return array|null
     */
    public function getCommentListByOrderNo($orderNo) {
        if ($orderNo) {
            $results = $this->find()
                ->where([
                    'order_no' => $orderNo
                ])
                ->orderAsc('created_at')
                ->toArray();
            return $results;
        }
        return null;
    }

    /**
     * 添加一条评论
     * @param $valuesArray
     * @return bool
     */
    public function insertCommentByValuesArray($valuesArray) {
        if ($valuesArray) {
            $result = $this->query()->insert([
                'order_no',
                'content',
                'from_user_id',
                'to_user_id',
                'deleted',
                'created_at',
                'updated_at'
            ])->values($valuesArray)->execute();
            return $result;
        }
        return false;
    }

//    /**
//     * 依据工单No删除所有评论
//     * @param $orderNo
//     * @return bool|\Cake\Database\StatementInterface
//     */
//    public function deleteCommentsByOrderNo($orderNo) {
//        if ($orderNo) {
//            $result = $this->find()->where([
//                'order_no' => $orderNo
//            ])->delete()->execute();
//            return $result;
//        }
//        return false;
//    }

}