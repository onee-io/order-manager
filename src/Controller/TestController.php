<?php
/**
 * Created by PhpStorm.
 * User: VOREVER
 * Date: 9/26/16
 * Time: 13:48
 */

namespace  App\Controller;

use App\Model\Table\ApiStudentTable;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;


class TestController extends AppController {


    public function initialize(){
        // TODO: None
    }

    public function index() {
        $this->autoRender = false;

//        if (!empty($_GET['name'])) {
//            echo $_GET['name'].'<br>';
//        }
//
//        if (!empty($_REQUEST['name'])) {
//            echo $_REQUEST['name'].'<br>';
//        }

//        $student = TableRegistry::get('ApiStudent');
//        $query = $student->find();
//        foreach ($query as $row) {
//            echo $row;
//        }

//        $data = ['id' => 123, 'name' => 'asd', 'data' => ['message' => 'asdasd']];
//        $a = json_encode($data);


//        echo $a;exit;

//            ->where(['id' => '1001'])->first();
//        var_dump($student);

//        $name = $this->request->data('name');
//        return $this->render('default');
//        echo 'auto route here.';
//        var_dump('sssssssaasda');

        // 查
//        $student = TableRegistry::get('ApiStudent');
//        $member = $student->find()->where(['id' => 1001])->first();
//        debug($member);

        // 改
//        $student = TableRegistry::get('ApiStudent');
//        $res = $student->query()->update()->set(['age' => 13])->where(['id' => 1001])->execute();
//        debug($res);

        // 增
        $connect=ConnectionManager::get('default');
        $connect->insert('api_student',['name' => 'lisi', 'age' => 14, 'created_at' => time(), 'updated_at' => time()]);

        $student = TableRegistry::get('ApiStudent');
        $res = $student->query()
            ->insert(['name', 'age', 'created_at', 'updated_at'])
            ->values(['name' => 'lisi', 'age' => 14, 'created_at' => time(), 'updated_at' => time()])
            ->execute();
        debug($res);

        // 删
//        $student = TableRegistry::get('ApiStudent');
//        $res = $student->find()->where(['id' => 1015])->delete()->execute();
//        debug($res);

    }

    public function haha() {

        $this->autoRender = false;
        echo 'hahahahahahah';
    }

    public function testUediter() {
        $this->autoRender = false;

        if ($this->request->data) {
            debug($this->request->data());
            exit;
        }
        
    }
    
}