<?php
use Cake\ORM\TableRegistry;
?>
<style type="text/css">
    .my_btn{
        margin-left: 5px;
        margin-right: 5px;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
    工单详情
        <?php
                foreach ($operateInfo as $operate) {
                //debug($operateInfo);exit;
                if ($operate['name'] == '删除') {
                    echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $orderInfo->order_no, $highStr], ['class' => 'pull-right btn btn-xs btn-danger my_btn']);
                    continue;
                }
                switch ($orderInfo['status']) {
                    case 1:     // 未受理
                        if ($operate['name'] == '受理') {
                            echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $orderInfo->order_no, $highStr], ['class' => 'pull-right btn btn-xs btn-primary my_btn']);
                        }
                        break;
                    case 2:     // 受理中
                        if ($operate['name'] == '完成' || $operate['name'] == '取消') {
                            echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $orderInfo->order_no, $highStr], ['class' => 'pull-right btn btn-xs btn-primary my_btn']);
                        }
                        break;
                    case 3:     // 待验收
                        if ($operate['name'] == '验收') {
                            echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $orderInfo->order_no, $highStr], ['class' => 'pull-right btn btn-xs btn-primary my_btn']);
                        }
                        break;
                    case 4:     // 已完成
                        break;
                    default:
                        echo 'order_list.ctp Fatal Error!';
                        exit;
                }
                //echo $this->Html->link(__($operate['name'].' '),['controller' => $operate['controller'], 'action' => $operate['action'], $order->order_no, $highStr]);
            }
        ?>
    </div>
    <table class="table">
        <tbody>
            <?php
                $classification = TableRegistry::get('WoClassifications');
                $order = TableRegistry::get('WoOrders');
                $user = TableRegistry::get('WoUsers');
            ?>
            <tr>
                <td class="col-sm-2 text-right">工单号:</td>
                <td class="col-sm-8"><?= h($orderInfo->order_no) ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">所属分类:</td>
                <td class="col-sm-8"><?= $classification->getClassificationNameByClassificationId(h($orderInfo->classification_id)) ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">工单状态:</td>
                <td class="col-sm-8"><?= $order->getOrderStatusByOrderNo(h($orderInfo->order_no)) ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">标题:</td>
                <td class="col-sm-8"><?= h($orderInfo->title) ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">内容:</td>
                <td class="col-sm-8"  style="padding-right: 100px;">
                <p><?= $orderInfo->content ?></p>
                </td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">发起人:</td>
                <td class="col-sm-8"><?= $user->getUserInfoByUserId(h($orderInfo->create_user_id))['realname'] ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">受理人:</td>
                <td class="col-sm-8"><?= $user->getUserInfoByUserId(h($orderInfo->accept_user_id))['realname'] ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">创建时间:</td>
                <td class="col-sm-8"><?= $orderInfo->created_at->i18nFormat('yyyy-MM-dd HH:mm:ss') ?></td>
            </tr>
            <tr>
                <td class="col-sm-2 text-right">最后更新时间:</td>
                <td class="col-sm-8"><?= $orderInfo->updated_at->i18nFormat('yyyy-MM-dd HH:mm:ss') ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="panel panel-default">
    <div class="panel-heading">评论区</div>
    <table class="table">
        <tbody>
            <?php
                if ($commentList) {
                    foreach ($commentList as $comment) {
                        echo '<tr>';
                        echo '<td class="col-sm-2 text-right">'.$user->getUserInfoByUserId($comment['from_user_id'])['realname'].'&nbsp评论&nbsp:&nbsp</td>';
                        echo '<td class="col-sm-8"><p>'.$comment['content'].'</p></td>';
                        echo '<td class="col-sm-2 text-right">'.$comment['created_at']->i18nFormat('yyyy-MM-dd HH:mm:ss').'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            <tr>
                <td class="col-sm-2"></td>
                <td class="col-sm-8">
                    <form method="post" action="/order-manager/add-comment">
                        <div onmousedown="show_element(event)" style="clear:both" id="customized-buttonpane" class="editor"></div>
                        <!-- <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="请输入评论内容" style="resize:none" required></textarea> -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary">发表评论</button>
                        </div>
                    </form>
                </td>
                <td class="col-sm-2"></td>
            </tr>
        </tbody>
    </table>
</div>
<div style="height:60px;"></div>