<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/6/16
 * Time: 16:32
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * @name 用户信息表
 * Class WoUsersTable
 * @package App\Model\Table
 * id => 用户ID
 * username => 用户名
 * password => 密码
 * realname => 真实姓名
 * email => 邮箱
 * phone_number => 手机号
 * deleted => 是否已删除 => 0.为删除 1.已删除
 * created_at => 创建时间
 * updated_at => 更新时间
 */
class WoUsersTable extends Table {

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('wo_users');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always'
                ]
            ]
        ]);
    }

    /**
     * 获取所有用户信息
     * @return array
     */
    public function getAllUserInfo() {
        return $this->find()->where([
            'id >=' => 1003,   // 1000、1001、1002 三个测试账户不允许操作
            'deleted' => 0
        ]);
    }

    /**
     * @name 通过用户名获取用户信息
     * @param $username
     * @return $res|null
     */
    public function getUserInfoByUsername($username) {
        if ($username) {
            $res = $this->find()
                ->hydrate(false)
                ->where([
                    'username' => $username,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * @name 通过用户ID获取用户信息
     * @param $userId
     * @return $res|null
     */
    public function getUserInfoByUserId($userId) {
        if ($userId) {
            $res = $this->find()
                ->where([
                    'id' => $userId,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * @name 通过邮箱获取用户信息
     * @param $email
     * @return $res|null
     */
    public function getUserInfoByEmail($email) {
        if ($email) {
            $res = $this->find()
                ->where([
                    'email' => $email,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * @name 通过手机号获取用户信息
     * @param $phoneNumber
     * @return mixed|null
     */
    public function getUserInfoByPhoneNumber($phoneNumber) {
        if ($phoneNumber) {
            $res = $this->find()
                ->where([
                    'phone_number' => $phoneNumber,
                    'deleted' => 0
                ])
                ->first();
            return $res;
        }
        return null;
    }

    /**
     * 通过用户真实姓名获取用户ID
     * @param $realName
     * @return null
     */
    public function getUserIdByRealName($realName) {
        if ($realName) {
            $res = $this->find()->where([
                'realname' => $realName,
                'deleted' => 0
            ])->first();
            return $res['id'];
        }
        return null;
    }

    /**
     * 插入一个新的用户通过属性数组
     * @param $valuesArray
     * @return null
     */
    public function insertUserByValuesArray($valuesArray) {
        if ($valuesArray) {
            if ($this->find()->where([
                'username' => $valuesArray['username']
            ])->first()) {
                return false;
            }
            $res = $this->query()->insert([
                'username',
                'password', 
                'realname',
                'email',
                'phone_number',
                'deleted',
                'created_at',
                'updated_at'
            ])->values($valuesArray)->execute();
//            debug($res);exit;
            return $res;
        }
        return null;
    }

    /**
     * 通过userID删除指定用户
     * @param $userId
     * @return $this|bool|mixed|null
     */
    public function deleteUserByUserId($userId) {
        if ($userId) {
//            debug($userId);exit;
            $res = $this->query()->update()->set([
                'deleted' => 1
            ])->where([
                'id' => $userId
            ])->execute();
            return $res;
        }
        return null;
    }

    /**
     * 修改用户信息
     * @param $userId
     * @param $values
     * @return null
     */
    public function modifyUserInfoByUserIdAndValues($userId, $values) {
        if ($userId && $values) {
            $res = $this->query()->update()->set($values)->where([
                'id' => $userId
            ])->execute();
            return $res;
        }
        return null;
    }



//    public function test($value){
//        $re = self::newEntity();
//        $re->f = 'test';
//        self::save($re);
//        return $re->id;
//    }
}


