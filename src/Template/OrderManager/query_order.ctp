<?php
use Cake\ORM\TableRegistry;
?>

<style type="text/css">
    td{padding: 6px;}
    .table_search{ width:100%;}
    .table_search .spanright{text-align: right;}
    .table_search .spanleft{text-align: left;}
</style>

<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal" method="get" action="/order-manager/query-order">
            <table class="table_search">
                <colgroup>
                    <col width="8%" align="right">
                    <col width="20%" align="left">
                    <col width="12%" align="right">
                    <col width="20%" align="left">
                    <col width="12%" align="right">
                    <col width="20%" align="left">
                </colgroup>
                <tbody>
                    <tr>
                        <td class="spanright">工单号</td>
                        <td class="spanleft">
                            <input type="text" class="form-control input-sm" name="order_no">
                        </td>
                        <td class="spanright">发起人</td>
                        <td class="spanleft">
                            <input type="text" class="form-control input-sm" name="create_user_name">
                        </td>
                        <td class="spanright">受理人</td>
                        <td class="spanleft">
                            <input type="text" class="form-control input-sm" name="accept_user_name">
                        </td>
                    </tr>
                    <tr>
                        <td class="spanright">工单状态</td>
                        <td class="spanleft">
                            <select name="status" class="form-control input-sm">
                                <option value="">--请选择--</option>
                                <option value="1">未受理</option>
                                <option value="2">受理中</option>
                                <option value="3">待验收</option>
                                <option value="4">已完成</option>
                            </select>
                        </td>
                        <td class="spanright">时间</td>
                        <td colspan="3" class="spanleft">
                            <input id="start_time" name="start_time" type="text" class="form-control input-sm" style="display: inline-block;width: auto">
                            至
                            <input id="end_time" name="end_time" type="text" class="form-control input-sm" style="display: inline-block;width: auto">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group" style="margin-bottom: 0;margin-top: 8px;">
                <div class="text-center">
                    <button type="submit" class="btn btn-sm btn-primary">查询</button>
                    <!-- <button type="button" class="btn btn-sm btn-default">重置</button> -->
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">查询结果</div>
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
                if (isset($orders)) {
                    if ($orders->count()) {
                        $userInfo = TableRegistry::get('WoUsers');
                        $orderInfo = TableRegistry::get('WoOrders');
                        $roleClassificationOperate = TableRegistry::get('WoRoleClassificationOperates');
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
                            $classificationId = $order['classification_id'];
                            $operateInfo = null;
                            foreach ($this->request->session()->read('classification_info') as $classificationInfo) {
                                if ($classificationInfo['id'] == $classificationId) {
                                    $operateInfo = $classificationInfo['operate_info'];
                                }
                            }
                            if ($operateInfo) {
                                foreach ($operateInfo as $operate) {
                                    //debug($operateInfo);exit;
                                    if ($operate['name'] == '详情') {
                                        echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no]);
                                        continue;
                                    }
                                    /*switch ($order['status']) {
                                        case 1:     // 未受理
                                            if ($operate['name'] == '受理') {
                                                echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no]);
                                            }
                                            break;
                                        case 2:     // 受理中
                                            if ($operate['name'] == '完成' || $operate['name'] == '取消') {
                                                echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no]);
                                            }
                                            break;
                                        case 3:     // 待验收
                                            if ($operate['name'] == '验收') {
                                                echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no]);
                                            }
                                            break;
                                        case 4:     // 已完成
                                            break;
                                        default:
                                            echo 'order_list.ctp Fatal Error!';
                                            exit;
                                    }*/
                                    //echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no]);
                                }
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
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
        if (isset($orders)) {
            if ($orders->count()) {
                if ($this->Paginator->numbers()) {
                    echo '<ul class="pagination pull-right">';
                    echo $this->Paginator->prev('< '.('上一页'));
                    echo $this->Paginator->numbers(['modulus' => 3]);
                    echo $this->Paginator->next('下一页'.' >');
                    echo '</ul>';
                }
            }
        }
    ?>
</div>
<div style="height: 60px;"></div>

<?= $this->Html->script('jquery-2.2.0.min.js'); ?>
<?= $this->Html->script('bootstrap.min.js'); ?>
<?= $this->Html->script('bootstrap-datetimepicker.min.js') ?>

<script>
    $('#start_time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss'
    });
    $('#end_time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss'
    });
</script>
