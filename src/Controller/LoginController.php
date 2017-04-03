<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/6/16
 * Time: 15:46
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Phinx\Db\Table;

class LoginController extends AppController {

    /**
     * 不检查session
     */
    public function initialize() {
    }

    /**
     * 默认跳转登录
     */
    public function index() {
        $this->login();
    }

    /**
     * 加载登录页面
     */
    public function login() {
        if ($this->checkUserLogin()) {
            echo '已是登录状态,直接跳转。';
            $this->redirect('/order-manager');
        } else {
            if ($this->request->session()->check('errorMessage')) {
                echo "<script>alert('".$this->request->session()->read('errorMessage')."')</script>>";
            }
            $this->viewBuilder()->layout('');  // 去掉模版
            $this->render('login');
            $this->request->session()->destroy();
        }
    }

    /**
     * 退出登录,清空session
     */
    public function logout() {
        $this->autoRender = false;
        // 清空session信息
        $this->request->session()->destroy();
        $this->redirect('/');
    }

    /**
     * 检查用户登录信息
     */
    public function checkInfo() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $username = $this->request->data('username');
            $password = $this->request->data('password');
            $user = TableRegistry::get('WoUsers');
            $userInfo = $user->getUserInfoByUsername($username);
            if ($userInfo) {
                // 有此用户
                if ($userInfo['password'] == $password) {
                    // 密码正确
                    $this->initUserInfo($userInfo);
                    $this->initRoleInfo();
                    $this->initClassificationInfo();
                    // 跳转到工单主页
                    $this->redirect('/order-manager');
                } else {
                    // 密码错误
                    $this->request->session()->write(['errorMessage' => '密码错误,请检查后重新登录!']);
                    $this->redirect('/login');
                }
            } else {
                // 无此用户
                $this->request->session()->write(['errorMessage' => '无此用户,请检查后重新登录!']);
                $this->redirect('/login');
            }
        }
    }

    /**
     * @name 初始化用户信息
     * @param $userInfo
     */
    public function initUserInfo($userInfo) {
        $this->request->session()->write([
            'user_info' => [
                'user_id' => $userInfo['id'],
                'username' => $userInfo['username'],
                'password' => $userInfo['password'],
                'realname' => $userInfo['realname'],
                'email' => $userInfo['email'],
                'phone_number' => $userInfo['phone_number']
            ]
        ]);
    }

    /**
     * @name 初始化角色信息
     */
    public function initRoleInfo() {
        if ($this->request->session()->check('user_info')) {
            $userId = $this->request->session()->read('user_info')['user_id'];
            $userRole = TableRegistry::get('WoUserRoles');
            $roleIdList = $userRole->getRoleIdListByUserId($userId);
            if ($roleIdList) {
                $roleIds = array();
                foreach ($roleIdList as $roleId) {
                    $roleIds[] = $roleId;
                }
                // 目前只考虑一个用户一种身份,以后这里要改
                $roleId = $roleIds[0];
                $role = TableRegistry::get('WoRoles');
                $roleInfo = $role->getRoleInfoByRoleId($roleId);
                $roleName = $roleInfo['role_name'];
                $roleType = $roleInfo['role_type'];
                $this->request->session()->write([
                    'role_info' => [
                        'role_id' => $roleId,
                        'role_name' => $roleName,
                        'role_type' => $roleType
                    ]
                ]);
            }
        }
    }
    
    /**
     * @name 初始化可见分类
     */
    public function initClassificationInfo() {
        if ($this->request->session()->check('role_info')) {
            $roleId = $this->request->session()->read('role_info')['role_id'];
            $roleClassification = TableRegistry::get('WoRoleClassifications');
            $classificationIdList = $roleClassification->getClassificationIdListByRoleId($roleId);
//            debug($classificationIdList);exit;
            if ($classificationIdList) {
                // 管理权限
                $manager_info = array();
                // 操作权限
                $operate_info = array();
                // 分类权限
                $classification_info = array();

                $classifications = TableRegistry::get('WoClassifications');
                foreach ($classificationIdList as $classificationId) {
                    switch ($classifications->getClassificationTypeByClassificationId($classificationId)) {
                        case '管理':
                            $managerInfo = $classifications->getClassificationInfoByClassificationId($classificationId);
                            if ($managerInfo) {$manager_info[] = $managerInfo;}
                            break;
                        case '操作':
                            $operateInfo = $classifications->getClassificationInfoByClassificationId($classificationId);
                            if ($operateInfo) {$operate_info[] = $operateInfo;}
                            break;
                        case '工单分类':
                            $classificationInfo = $classifications->getClassificationInfoByClassificationId($classificationId);
                            if ($classificationInfo) {$classification_info[] = $classificationInfo;}
                            break;
                        default:
                            echo 'LoginController - initClassificationInfo - Fatal error';exit;
                    }
                }

                if ($manager_info) {
                    $manager_session = array();
                    foreach ($manager_info as $manager) {
                        $manager_session[] = [
                            'id' => $manager['id'],
                            'type' => '管理',
                            'name' => $manager['classification_name'],
                            'controller' => $manager['controller'],
                            'action' => $manager['action'],
                            'query_type' => $manager['query_type'],
                            'operate_info' => $this->initOperateInfo($manager['id'])
                        ];
                    }
                    $this->request->session()->write([
                        'manager_info' => $manager_session
                    ]);
                }
                if ($operate_info) {
                    $operate_session = array();
                    foreach ($operate_info as $operate) {
                        $operate_session[] = [
                            'id' => $operate['id'],
                            'type' => '操作',
                            'name' => $operate['classification_name'],
                            'controller' => $operate['controller'],
                            'action' => $operate['action'],
                            'query_type' => $operate['query_type']
                        ];
                    }
                    $this->request->session()->write([
                        'operate_info' => $operate_session
                    ]);
                }
                if ($classification_info) {
                    $classification_session = array();
                    foreach ($classification_info as $classification) {
                        $classification_session[] = [
                            'id' => $classification['id'],
                            'type' => '工单分类',
                            'name' => $classification['classification_name'],
                            'controller' => $classification['controller'],
                            'action' => $classification['action'],
                            'query_type' => $classification['query_type'],
                            'operate_info' => $this->initOperateInfo($classification['id'])
                        ];
                    }
                    $this->request->session()->write([
                        'classification_info' => $classification_session
                    ]);
                }
            }
        }
    }

    /**
     * 初始化操作权限
     * @param $classificationId
     * @return array|null
     */
    public function initOperateInfo($classificationId){
        if ($this->request->session()->check('role_info')) {
            $roleType = $this->request->session()->read('role_info')['role_type'];
            if ($classificationId) {
                $roleOperate = TableRegistry::get('WoRoleOperates');
                $operateIdList = $roleOperate->getOperateListByRoleType($roleType);
                if ($operateIdList) {
                    $operates = TableRegistry::get('WoOperates');
                    $operateList = array();
                    foreach ($operateIdList as $operateId) {
                        $operateInfo = $operates->getOperateInfoByOperateId($operateId);
                        $operateList[] = [
                            'name' => $operateInfo['operate_name'],
                            'controller' => $operateInfo['controller'],
                            'action' => $operateInfo['action']
                        ];
                    }
                    return $operateList;
                }
                return null;
            }
            return null;
        }
        return null;
    }

}