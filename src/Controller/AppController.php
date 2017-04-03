<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        if (!$this->checkUserLogin()) {
            $this->redirect('/');
        }
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * 检查用户之前是否登陆
     */
    public function checkUserLogin() {
        // 检查session中是否有user_id
        if ($this->request->session()->check('user_info')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 弹窗显示信息
     * @param $message
     */
    public function showTipMessage($message) {
        if ($message) {
            echo '<script>alert($message);</script>';
        }
    }

    /**
     * 处理文本内容
     * @param $content
     * @return array
     */
    public function contentHandle($content){
        $new_content = '';
        $image_arr = [];
        $flag_num = 0;

        while (!empty($content)){
            $f_arr = self::_contentSubStr($content,'<img src="');
            if($f_arr === false){
                $new_content .= $content;
                break;
            }
            $new_content .= $f_arr['sub'] . '@#' . $flag_num . '#@' ;
            $s_arr = self::_contentSubStr($f_arr['content'],'"');
            $image_arr[] = $s_arr['sub'];
            $content = $s_arr['content'];
            $flag_num ++;
        }
        return ['content'=>$new_content,'image_arr'=>$image_arr];
    }

    /**
     * 截取字符串
     * @param $content
     * @param $sub
     * @return array|bool
     */
    private function _contentSubStr($content,$sub){
        $pos = strpos($content,$sub);
        if($pos === false){
            return false;
        }
        $nn = 0;
        if(strlen($sub) == 1){
            $nn = 1;
        }
        $sub1 = substr($content,0,$pos+strlen($sub)-$nn);
        $content = substr($content,$pos+strlen($sub)-$nn);
        return ['sub'=>$sub1,'content'=>$content];
    }

    /**
     * 生成随机数
     * @param $len
     * @return string
     */
    public function getRandStr($len)
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++)
        {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
}
