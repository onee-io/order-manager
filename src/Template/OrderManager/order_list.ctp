<?php use Cake\ORM\TableRegistry; ?>
<div class="panel panel-default">
    <div class="panel-heading">
        工单列表
    </div>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th width="150">工单号</th>
                <th>标题</th>
                <th>发起人</th>
                <th>受理人</th>
                <th width="85">状态</th>
                <th width="170">时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if ($orders->count()) {
                    $userInfo = TableRegistry::get('WoUsers');
                    $orderInfo = TableRegistry::get('WoOrders');
                    foreach ($orders as $order) {
                        $createUser = $userInfo->getUserInfoByUserId($order->create_user_id)['realname'];
                        $acceptUser = $userInfo->getUserInfoByUserId($order->accept_user_id)['realname'];
                        $orderTime = $order->updated_at->i18nFormat('yyyy-MM-dd HH:mm:ss');
                        $orderStatus = $orderInfo->getOrderStatusByOrderNo($order->order_no);
                        echo '<tr>';
                        echo '<td>'.h($order->order_no).'</td>';
                        echo '<td>'.h($order->title).'</td>';
                        echo '<td>'.h($createUser).'</td>';
                        echo '<td>'.h($acceptUser).'</td>';
                        echo '<td>'.h($orderStatus).'</td>';
                        echo '<td>'.h($orderTime).'</td>';
                        echo '<td>';
                        foreach ($operateInfo as $operate) {
                            //debug($operateInfo);exit;
                            if ($operate['name'] == '详情') {
                                echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
                                continue;
                            }
                            /*switch ($order['status']) {
                                case 1:     // 未受理
                                    if ($operate['name'] == '受理') {
                                        echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
                                    }
                                    break;
                                case 2:     // 受理中
                                    if ($operate['name'] == '完成' || $operate['name'] == '取消') {
                                        echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
                                    }
                                    break;
                                case 3:     // 待验收
                                    if ($operate['name'] == '验收') {
                                        echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
                                    }
                                    break;
                                case 4:     // 已完成
                                    break;
                                default:
                                    echo 'order_list.ctp Fatal Error!';
                                    exit;
                            }*/
                            //echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="10" class="text-center">暂无记录</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<!-- 分页 -->
<div>
    <?php
        if ($orders->count()) {
            if ($this->Paginator->numbers()) {
                echo '<ul class="pagination pull-right">';
                echo $this->Paginator->prev('< '.('上一页'));
                echo $this->Paginator->numbers(['modulus' => 3]);
                echo $this->Paginator->next('下一页'.' >');
                echo '</ul>';
            }
        }
    ?>
</div>
<div style="height: 60px;"></div>
