<?php
/*
Decsri: xMing's Exclusive Config
Auther: xMing
Create: By Quoda
*/
namespace ymind\xming{
class Config{
   
   const TEXT = 0;
   
   const JSON = 1;
   
   protected $type;
   
   protected $file;
   
   public function __construct($file,$type,$data){
      $this->type = $type;
      if(!file_exists($file)){
         switch($type){
            case 0:
               file_put_contents($file,$data);
            break;
            case 1:
               file_put_contents($file,json_encode(data));
            break;
         }
      }
      $this->file = $file;
   }
   
    public function getAll(){
       $str = trim(file_get_contents($this->file));
       return $this->type == 0 ? $str : json_decode($str,true);
    }
    
    public function get($key){
       $data = $this->getAllData();
       if($this->type == 0) return false;
       return isset($data[$key]) ? $data[$key] : false;
    }
    
    public function setAll($data){
       if($this->type == 0){
          file_put_contents($this->file,$data);
       }else{
          file_put_contents($this->file,json_encode($data));
       }
    }
    
    public function (int $key,$value,$mode = true){
       if($this->type == 0) return;
       $data = $this->getAllData();
       if($mode){
          $data[$key] = $value;
       } elseif (isset($data[$key])) {
          unset($data[$key]);
       }
       $this->setAllData($data);
    }
    
    public function appendData($value){
       if($this->type == 0) return;
       $data = $this->getAllData();
          $data[] = $value;
       $this->setAllData($data);
    }
    
    public function getLength(){
       if($this->type == 0) return 0;
       return count($this->getAllData());
    }
  }
}