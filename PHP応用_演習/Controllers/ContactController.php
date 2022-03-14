<?php
require_once(ROOT_PATH .'Models/ContactModel.php');

class ContactController
{
  private $view;    
  private $model;
 
  public function __construct()
  {        
    // ビューオブジェクト生成        
    $this->view = new Smarty();        
    $this->view->template_dir = '../Views/contact.php';        
    // モデルオブジェクト生成        
    $this->model = new ContactModel();    
  } 
 
  public function displayProc()    
  {         
    $req = new Request();        
    $params = $req->getParam();        
    $name = $params['name']; 
    $kana = $params['kana']; 
    $tel = $params['tel']; 
    $email = $params['email']; 
    $body = $params['body']; 
    // 情報を取得        
    $basicdata = $this->model->getBasicData($name,$kana,$tel,$email,$body);         
    // ビュー内の smarty変数に値を割り当てる        
    $this->view->assign('basic_data', $basicdata);          
    // 表示        
    $this->view->display('Views/contact.php');    
  } 
}