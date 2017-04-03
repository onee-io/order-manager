<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 14:06
 */

namespace App\Model\Table;


use Cake\ORM\Table;
use RuntimeException;
use Cake\I18n\Time;


/**
 * @name 工单表
 * Class WoOrdersTable   
 * @package App\Model\Table
 * id => ID
 * order_no => 工单号 
 * classification_id => 分类ID
 * title => 标题
 * content => 内容
 * status => 工单状态 => 1.未受理 2.受理中 3.待验收 4.已完成
 * deleted => 0.未删除 1.已删除
 * create_user_id => 发起人
 * accept_user_id => 受理人
 * created_at => 创建时间
 * updated_at => 更新时间
 */
class WoOrdersTable extends Table {

    /**
     * 获取工单信息通过自定义条件
     * @param $valuesArray
     * @return $this|null
     */
    public function getOrderInfoByValuesArray($valuesArray) {
        if ($valuesArray) {
            $res = $this->find()->where($valuesArray)->orderDesc('updated_at');
            return $res;
        }
        return null;
    }
    
    /**
     * @name 通过工单号NO获取工单信息
     * @param $orderNo
     * @return mixed|null
     */
    public function  getOrderInfoByOrderNo($orderNo) {
        if ($orderNo) {
            $res = $this->find()
                ->where([
                    'order_no' => $orderNo,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * 获取工单状态通过工单编号
     * @param $orderNo
     * @return null|string
     */
    public function getOrderStatusByOrderNo($orderNo) {
        if ($orderNo) {
            $res = $this->find()
                ->where([
                    'order_no' => $orderNo,
                    'deleted' => 0
                ])
                ->first();
            if ($res) {
                switch ($res['status']) {
                    case 1:    // 未受理
                        return '未受理';
                    case 2:    // 受理中
                        return '受理中';
                    case 3:    // 待验收
                        return '待验收';
                    case 4:    // 已完成
                        return '已完成';
                    default:
                        echo "WoOrdersTable - getOrderStatusByOrderNo Fatal error!";
                        exit;
                }
            }
            return null;
        }
        return null;
    }

    /**
     * @name 通过分类ID获取该分类下工单列表
     * @param $classificationId
     * @return array|null
     */
    public function  getOrderListByClassificationId($classificationId) {
        if ($classificationId) {
            $results = $this->find()
                ->where([
                    'classification_id' => $classificationId,
                    'deleted' => 0
                ])
                ->orderDesc('updated_at');
//                ->toArray();
            return $results;
        }
        return null;
    }

    /**
     * @name 通过发起人ID获取该发起人所有工单的列表
     * @param $createUserId
     * @return array|null
     */
    public function  getOrderListByCreateUserId($createUserId) {
        if ($createUserId) {
            $results = $this->find()
                ->where([
                    'create_user_id' => $createUserId,
                    'deleted' => 0
                ])
                ->orderDesc('updated_at');
//                ->toArray();
            return $results;
        }
        return null;
    }

    /**
     * @name 通过受理人ID获取该受理人所有工单的列表
     * @param $acceptUserId
     * @return array|null
     */
    public function  getOrderListByAcceptUserId($acceptUserId) {
        if ($acceptUserId) {
            $results = $this->find()
                ->where([
                    'accept_user_id' => $acceptUserId,
                    'deleted' => 0
                ])
                ->orderDesc('updated_at');
//                ->toArray();
            return $results;
        }
        return null;
    }

    /**
     * @name 通过状态ID获取所有该状态工单的列表
     * @param $status
     * @return array|null
     */
    public function  getOrderListByStatus($status) {
        if ($status >= 1 && $status <= 4) {
            $results = $this->find()
                ->where([
                    'status' => $status,
                    'deleted' => 0
                ])
                ->orderDesc('updated_at');
//                ->toArray();
            return $results;
        }
        return null;
    }

    /**
     * 插入一条工单数据
     * @param $valuesArray
     * @return bool
     */
    public function insertOrderInfoByValuesArray($valuesArray) {
        if ($valuesArray) {
            $result = $this->query()->insert([
                'order_no',
                'classification_id',
                'title',
                'content',
                'status',
                'deleted',
                'create_user_id',
                'accept_user_id',
                'created_at',
                'updated_at'
            ])->values($valuesArray)->execute();
            return $result;
        }
        return false;
    }

    /**
     * 通过工单No更改工单数据
     * @param $orderNo
     * @param $valuesArray
     * @return bool
     */
    public function updateOrderInfoByOrderNoAndValuesArray($orderNo, $valuesArray) {
        if ($orderNo && $valuesArray) {
            $result = $this->query()
                ->update()
                ->set($valuesArray)
                ->where([
                    'order_no' => $orderNo
                ])->execute();
            return $result;
        }
        return false;
    }

    /**
     * 删除工单通过工单No
     * @param $orderNo
     * @return bool|\Cake\Database\StatementInterface
     */
    public function deleteOrderByOrderNo($orderNo) {
        if ($orderNo) {
            $res = $this->query()->update()->set([
                'deleted' => 1
            ])->where([
                'order_no' => $orderNo
            ])->execute();
            return $res;
        }
        return false;
    }
}