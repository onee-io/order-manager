<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 10/25/16
 * Time: 19:08
 */
namespace App\PublicTool;

class Tool{
    /**
     * @name   redirect
     * @param $message  
     * @param $class
     * @param $method
     */
    static function alert($message,$class,$method,$param = null){
        $param_temp = '';
        if(!is_null($param) && is_array($param)){
            $param_temp = '/'.join('/',$param);
        }
        echo '<script>
                alert("' . $message . '");
               window.location.href="http://'.$_SERVER['HTTP_HOST'].'/'.$class.'/'.$method.$param_temp.'";
            </script>';
        exit;
    }
}