<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/7/16
 * Time: 19:06
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Phinx\Db\Table;
use App\PublicTool\Tool;
use Cake\I18n\Time;

class OrderManagerController extends AppController {

    /**
     * 工单列表主页
     */
    public function index() {
//        debug($this->request->session()->read());exit;
    }

    /**
     * 新增工单页面
     */
    public function addOrder() {
        if ($this->request->is('post')) {
            if ($this->request->data) {
                $pageContent = $this->request->data('customized-buttonpane');
                $result = $this->contentHandle($pageContent);
                $content = $result['content'];
                $imageArray = $result['image_arr'];
                $i = 0;
                foreach ($imageArray as $image) {
                    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)){
                        $type = $result[2];
                        $filename = $this->getRandStr(64);
                        $new_file = "./img/uploadImages/{$filename}.{$type}";
                        if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $image)))){
                            echo '文件保存失败：', $new_file;
                            exit;
                        }
                        $replace_filename = 'http://'.$_SERVER['HTTP_HOST'].substr($new_file, 1);
                        $content = preg_replace('/@#'.$i.'#@/', $replace_filename, $content);
                    }
                    $i ++;
                }
                $content = preg_replace('/<img src="/', '<img width="300px" src="', $content);
//                debug($content);exit;
                $classification_id = $this->request->data('classification');
                $title = $this->request->data('title');
                $create_user_id = $this->request->session()->read('user_info')['user_id'];
                $orderNo = $create_user_id.time();
                $order = TableRegistry::get('WoOrders');
                $result = $order->insertOrderInfoByValuesArray([
                    'order_no' => $orderNo,
                    'classification_id' => $classification_id,
                    'title' => $title,
                    'content' => $content,
                    'status' => 1,
                    'deleted' =>0,
                    'create_user_id' => $create_user_id,
                    'accept_user_id' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                if ($result) {
//                    Tool::alert('test','OrderManager','OrderList',[3,$classification_id]);
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'orderList', 3, $classification_id]);
                } else {
                    echo 'OrderManagerController - addOrder - Fatal Error';
                    exit;
                }
            } else {
                echo 'OrderManagerController - addOrder - No Params';
                exit;
            }
        } else {
            $this->set('highLight', $this->request->params['action']);
        }
    }

    /**
     * 添加评论
     */
    public function addComment() {
        if ($this->request->is('post')) {
            if ($this->request->data) {
//                debug($this->request->session()->read());exit;

                $pageContent = $this->request->data('customized-buttonpane');
                $result = $this->contentHandle($pageContent);
                $content = $result['content'];
                $imageArray = $result['image_arr'];
                $i = 0;
                foreach ($imageArray as $image) {
                    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)){
                        $type = $result[2];
                        $filename = $this->getRandStr(64);
                        $new_file = "./img/uploadImages/{$filename}.{$type}";
                        if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $image)))){
                            echo '文件保存失败：', $new_file;
                            exit;
                        }
                        $replace_filename = 'http://'.$_SERVER['HTTP_HOST'].substr($new_file, 1);
                        $content = preg_replace('/@#'.$i.'#@/', $replace_filename, $content);
                    }
                    $i ++;
                }
                $content = preg_replace('/<img src="/', '<img width="300px" src="', $content);
//                debug($content);exit; ha

                $highStr = $this->request->session()->read('highStr');
                $user_info = $this->request->session()->read('user_info');
                $order_info = $this->request->session()->read('order_info');

                $order_no = $order_info['order_no'];
//                $content = $this->request->data('comment');
                $from_user_id = $user_info['user_id'];
                $to_user_id = $order_info['create_user_id'];

                $comment = TableRegistry::get('WoComments');
                $result = $comment->insertCommentByValuesArray([
                    'order_no' => $order_no,
                    'content' => $content,
                    'from_user_id' => $from_user_id,
                    'to_user_id' => $to_user_id,
                    'deleted' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ]);
                if ($result) {
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $order_no, $highStr]);
                } else {
                    echo "orderManager - insert error addComment";
                    exit;
                }
            }
        } else {
            echo 'No param or request type error!';
            exit;
        }
    }

    /**
     * 查询工单页面
     */
    public function queryOrder() {
        if ($this->request->is('get')) {
//            debug($this->request->data);exit;
            if ($this->request->query) {
                $order = TableRegistry::get('WoOrders');
                $user = TableRegistry::get('WoUsers');
                $this->paginate = [
                    'limit' => 9
                ];

                $orderNo = $this->request->query('order_no');
                $createUserName = $this->request->query('create_user_name');
                $createUserId = $user->getUserIdByRealName($createUserName);
                $acceptUserName = $this->request->query('accept_user_name');
                $acceptUserId = $user->getUserIdByRealName($acceptUserName);
                $status = $this->request->query('status');
                $startTime = $this->request->query('start_time');
                $endTime = $this->request->query('end_time');

                $valuesArray = array();
                if ($orderNo) {$valuesArray['order_no'] = $orderNo;}
                if ($createUserId) {$valuesArray['create_user_id'] = $createUserId;}
                if ($acceptUserId) {$valuesArray['accept_user_id'] = $acceptUserId;}
                if ($status) {$valuesArray['status'] = $status;}
                if ($startTime) {$valuesArray['updated_at >='] = $startTime;}
                if ($endTime) {$valuesArray['updated_at <='] = $endTime;}
                $valuesArray['deleted'] = 0;

                $classificationListTemp = $this->request->session()->read('classification_info');
                $classificationIdList = array();
                foreach ($classificationListTemp as $classification) {
                    if ($classification['query_type'] == 3) {
                        $classificationIdList[] = $classification['id'];
                    }
                }
                $idStr = '';
                foreach ($classificationIdList as $id) {
                    $idStr .= $id . ',';
                }
                $idStr = substr($idStr,0,strlen($idStr)-1);
                $valuesArray[] = 'classification_id in ('.$idStr.')';
                if ($valuesArray) {
                    $orderInfo = $order->getOrderInfoByValuesArray($valuesArray);
                    $orders = $this->paginate($orderInfo);
                    if ($orders->count()) {
                        $this->set(compact('orders'));
                    }
                }
            }
            $this->set('highLight', $this->request->params['action']);
        } else {
            $this->set('highLight', $this->request->params['action']);
        }
    }

    /**
     * 初始化工单信息
     * @param $orderNo
     * @return $orderInfo|null
     */
    public function initOrderInfo($orderNo) {
        if ($orderNo) {
            $order = TableRegistry::get('WoOrders');
            $orderInfo = $order->getOrderInfoByOrderNo($orderNo);
            $this->request->session()->write([
                'order_info' => $orderInfo
            ]);
            return $orderInfo;
        }
        return null;
    }

    /**
     * 保存当前点击的分类栏
     * @param $highStr
     * @return null
     */
    public function setHighStr($highStr) {
        if ($highStr) {
            $this->request->session()->write(['highStr' => $highStr]);
        }
        return null;
    }

    /**
     * 工单详情页
     * @param $orderNo
     * @param $highStr
     * @return null
     */
    public function detailOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderTable = TableRegistry::get('WoOrders'); 
            $classificationId = $orderTable->getOrderInfoByOrderNo($orderNo)['classification_id'];
            $orderInfo = $this->initOrderInfo($orderNo);
            $operateInfo = $this->getOperateInfoByClassificationId($classificationId);
//            debug($operateInfo);exit;
            $comment = TableRegistry::get('WoComments');
            $commentList = $comment->getCommentListByOrderNo($orderNo);
            $this->set(compact('operateInfo'));
            $this->set(compact('orderInfo'));
            $this->set(compact('commentList'));
            $this->set('highStr', $classificationId);
        }
        return null;
    }

    /**
     * 受理工单
     * @param null $orderNo
     * @param $highStr
     * @return null
     */
    public function acceptOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderInfo = $this->initOrderInfo($orderNo);
            $classificationId = $orderInfo['classification_id'];
            $classification = TableRegistry::get('WoClassifications');
            $type = $classification->getClassificationInfoByClassificationId($classificationId)['query_type'];

            // status = 1 未受理状态
            if ($orderInfo['status'] == 1) {
                $order = TableRegistry::get('WoOrders');
                $result = $order->updateOrderInfoByOrderNoAndValuesArray($orderInfo['order_no'], [
                    'status' => 2,  // 更改为受理中
                    'accept_user_id' => $this->request->session()->read('user_info')['user_id'],
                    'updated_at' => time()
                ]);
                if ($result) {
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
                }
            } else {
                $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
            }
        } else {
            echo "No found orderNo";
            exit;
        }
    }

    /**
     * 验收工单
     * @param null $orderNo
     * @param $highStr
     * @return null
     */
    public function checkOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderInfo = $this->initOrderInfo($orderNo);
            $classificationId = $orderInfo['classification_id'];
            $classification = TableRegistry::get('WoClassifications');
            $type = $classification->getClassificationInfoByClassificationId($classificationId)['query_type'];

            // status = 3 待验收状态
            if ($orderInfo['status'] == 3) {
                $order = TableRegistry::get('WoOrders');
                $result = $order->updateOrderInfoByOrderNoAndValuesArray($orderInfo['order_no'], [
                    'status' => 4,  // 更改为已完成
                    'updated_at' => time()
                ]);
                if ($result) {
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
                }
            } else {
                $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
            }
        } else {
            echo "No found orderNo";
            exit;
        }
    }

    /**
     * 取消受理工单
     * @param null $orderNo
     * @param $highStr
     * @return null
     */
    public function cancelOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderInfo = $this->initOrderInfo($orderNo);
            $classification = TableRegistry::get('WoClassifications');
            $classificationId = $orderInfo['classification_id'];
            $type = $classification->getClassificationInfoByClassificationId($classificationId)['query_type'];
            // status = 2 受理中状态
            if ($orderInfo['status'] == 2) {
                $order = TableRegistry::get('WoOrders');
                $result = $order->updateOrderInfoByOrderNoAndValuesArray($orderInfo['order_no'], [
                    'status' => 1,  // 更改为未受理
                    'accept_user_id' => null,
                    'updated_at' => time()
                ]);
                if ($result) {
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
                }
            } else {
                $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
            }
        } else {
            echo "No found orderNo";
            exit;
        }
    }

    /**
     * 删除工单
     * @param null $orderNo
     * @param $highStr
     * @return null
     */
    public function deleteOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderInfo = $this->initOrderInfo($orderNo);
            $classification = TableRegistry::get('WoClassifications');
            $classificationId = $orderInfo['classification_id'];
            $type = $classification->getClassificationInfoByClassificationId($classificationId)['query_type'];
            $order = TableRegistry::get('WoOrders');
            $delOrderRes = $order->deleteOrderByOrderNo($orderNo);
            if ($delOrderRes) {
                $this->redirect(['controller' => 'OrderManager', 'action' => 'orderList', $type, $classificationId]);
            } else {
                echo 'deleteOrder Fatal Error.';
                exit;
            }
        } else {
            echo 'No param orderNo.';
            exit;
        }
    }

    /**
     * 完成工单
     * @param null $orderNo
     * @param $highStr
     * @return null
     */
    public function completeOrder($orderNo = null, $highStr = null) {
        if ($orderNo) {
            $this->setHighStr($highStr);
            $orderInfo = $this->initOrderInfo($orderNo);
            $classificationId = $orderInfo['classification_id'];
            $classification = TableRegistry::get('WoClassifications');
            $type = $classification->getClassificationInfoByClassificationId($classificationId)['query_type'];

            // status = 2 受理中状态
            if ($orderInfo['status'] == 2) {
                $order = TableRegistry::get('WoOrders');
                $result = $order->updateOrderInfoByOrderNoAndValuesArray($orderInfo['order_no'], [
                    'status' => 3,  // 更改为待验收
                    'updated_at' => time()
                ]);
                if ($result) {
                    $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
                }
            } else {
                $this->redirect(['controller' => 'OrderManager', 'action' => 'detailOrder', $orderNo, $highStr]);
            }
        } else {
            echo "No found orderNo";
            exit;
        }
    }

    /**
     * 工单列表页面
     * @param null $type
     * @param null $classificationId
     * @return null
     */
    public function orderList($type = null, $classificationId = null) {
        if ($type && $classificationId) {
            $this->paginate = [
                'limit' => 13
            ];
            switch ($type) {
                case 1:    // 我发起的工单
                    $highStr = $classificationId;
                    $order = TableRegistry::get('WoOrders');
                    $orderInfo = $order->getOrderListByCreateUserId($this->request->session()->read('user_info')['user_id']);
                    $operateInfo = $this->getOperateInfoByClassificationId($classificationId);
                    $orders = $this->paginate($orderInfo);
                    break;
                case 2:    // 我受理的工单
                    $highStr = $classificationId;
                    $order = TableRegistry::get('WoOrders');
                    $orderInfo = $order->getOrderListByAcceptUserId($this->request->session()->read('user_info')['user_id']);
                    $operateInfo = $this->getOperateInfoByClassificationId($classificationId);
                    $orders = $this->paginate($orderInfo);
                    break;
                case 3:    // 工单分类
                    $highStr = $classificationId;
                    $order = TableRegistry::get('WoOrders');
                    $orderInfo = $order->getOrderListByClassificationId($classificationId);
                    $operateInfo = $this->getOperateInfoByClassificationId($classificationId);
                    $orders = $this->paginate($orderInfo);
                    break;
                default:
                    echo 'OrderManager - orderList - Fatal Error';
                    exit;
            }
//            debug($orders);exit;
            $this->set(compact('orders'));
            $this->set(compact('operateInfo'));
            $this->set(compact('highStr'));
        }
        return null;
    }

    /**
     * 通过分类ID从缓存中取可执行操作权限
     * @param $id
     * @return null
     */
    public function getOperateInfoByClassificationId($id) {
        foreach ($this->request->session()->read('classification_info') as $classificationInfo) {
            if ($classificationInfo['id'] == $id) {
                $operateInfo = $classificationInfo['operate_info'];
                return $operateInfo;
            }
        }
        return null;
    }

    public function test($value = null) {
        $this->autoRender = false;

        echo 'OrderManagerController - test '.$value;
    }

//    /**
//     * 处理文本内容
//     * @param $content
//     * @return array
//     */
//    public function contentHandle($content){
//        $new_content = '';
//        $image_arr = [];
//        $flag_num = 0;
//
//        while (!empty($content)){
//            $f_arr = self::_contentSubStr($content,'<img src="');
//            if($f_arr === false){
//                $new_content .= $content;
//                break;
//            }
//            $new_content .= $f_arr['sub'] . '@#' . $flag_num . '#@' ;
//            $s_arr = self::_contentSubStr($f_arr['content'],'"');
//            $image_arr[] = $s_arr['sub'];
//            $content = $s_arr['content'];
//            $flag_num ++;
//        }
//        return ['content'=>$new_content,'image_arr'=>$image_arr];
//    }
//
//    /**
//     * 截取字符串
//     * @param $content
//     * @param $sub
//     * @return array|bool
//     */
//    private function _contentSubStr($content,$sub){
//        $pos = strpos($content,$sub);
//        if($pos === false){
//            return false;
//        }
//        $nn = 0;
//        if(strlen($sub) == 1){
//            $nn = 1;
//        }
//        $sub1 = substr($content,0,$pos+strlen($sub)-$nn);
//        $content = substr($content,$pos+strlen($sub)-$nn);
//        return ['sub'=>$sub1,'content'=>$content];
//    }
}