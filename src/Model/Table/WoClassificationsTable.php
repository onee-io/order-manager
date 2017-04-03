<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/9/16
 * Time: 10:33
 */

namespace App\Model\Table;


use Cake\ORM\Table;

/**
 * @name 分类表
 * Class WoClassificationTable   
 * @package App\Model\Table
 * id => ID
 * classification_name => 分类名称
 * classification_type => 分类类型 => 1.管理 2.操作 3.工单分类
 * controller => 控制器
 * action => 方法
 * query_type => 查询类型 => 0.无需查询 1.发起人查询 2.受理人查询 3.分类查询
 * deleted => 0.为删除 1.已删除
 */
class WoClassificationsTable extends Table {

    /**
     * @name 通过分类id获取分类信息
     * @param $classificationId
     * @return mixed|null
     */
    public function getClassificationInfoByClassificationId($classificationId) {
        if ($classificationId) {
            $res = $this->find()
                ->where([
                    'id' => $classificationId,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * @name 通过分类id获取分类名称
     * @param $classificationId
     * @return null|string
     */
    public function getClassificationNameByClassificationId($classificationId) {
        if ($classificationId) {
            $res = $this->find()
                ->where([
                    'id' => $classificationId,
                    'deleted' => 0
                ])
                ->first();
            return $res['classification_name'];
        }
        return null;
    }

    /**
     * @name 通过分类id获取分类类型
     * @param $classificationId
     * @return null|string
     */
    public function getClassificationTypeByClassificationId($classificationId) {
        if ($classificationId) {
            $res = $this->find()
                ->where([
                    'id' => $classificationId,
//                    'deleted' => 0
                ])
                ->first();
            if ($res) {
                switch ($res['classification_type']) {
                    case 1:
                        // 管理
                        return '管理';
                    case 2:
                        // 操作
                        return '操作';
                    case 3:
                        // 工单分类
                        return '工单分类';
                    default:
                        echo 'getClassificationTypeByClassificationId - Fatal error!';
                        exit;
                }
            }
            return null;
        }
        return null;
    }

    /**
     * 判断工单ID是否为普通工单
     * @param $classificationid
     * @return bool
     */
    public function isNormalClassification($classificationid) {
        if ($classificationid) {
            $res = $this->find()->where([
                'id' => $classificationid,
                'deleted' => 0
            ])->first();
            if ($res['query_type'] == 3) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * 获取所有工单分类
     * @return $this
     */
    public function getAllClassificationInfo() {
        return $this->find()->where([
            'classification_type' => 3,
            'query_type' => 3,
            'deleted' => 0
        ]);
    }

    /**
     * 插入分类
     * @param $classificationName
     * @return null
     */
    public function insertClassificationByClassification($classificationName) {
        if ($classificationName) {
            $res = self::newEntity();
            $res->classification_name = $classificationName;
            $res->classification_type = 3;
            $res->controller = 'OrderManager';
            $res->action = 'orderList';
            $res->query_type = 3;
            $res->deleted = 0;
            self::save($res);
            return $res->id;
        }
        return null;
    }

    /**
     * 删除分类信息
     * @param $classificationId
     * @return null
     */
    public function deleteClassificationByClassificationId($classificationId) {
        if ($classificationId) {
            $res = $this->query()->update()->set([
                'deleted' => 1
            ])->where([
                'id' => $classificationId
            ])->execute();
            return $res;
        }
        return null;
    }

    /**
     * 修改分类名称
     * @param $classificationId
     * @param $value
     * @return null
     */
    public function modifyClassificationNameByClassificationIdAndValue($classificationId, $value) {
        if ($classificationId && $value) {
            $res = $this->query()->update()->set([
                'classification_name' => $value
            ])->where([
                'id' => $classificationId
            ])->execute();
            return $res;
        }
        return null;
    }
}