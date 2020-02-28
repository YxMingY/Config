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
   
   public function __construct($file,$type = self::JSON,$data = null){
      $this->type = $type;
      if(!file_exists($file)){
         switch($type){
            case 0:
               file_put_contents($file,$data ?? "");
            break;
            case 1:
               file_put_contents($file,json_encode($data ?? []));
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
       $data = $this->getAll();
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
    
    public function set($key,$value){
       if($this->type == 0) return;
       $data = $this->getAll();
       $data[$key] = $value;
       $this->setAll($data);
    }
   
   public function remove($key)
   {
     if ($this->type == 0) return;
     $data = $this->getAll();
     if (isset($data[$key]))
       unset($data[$key]);
     $this->setAll($data);
   }
    
    public function append($value){
       if($this->type == 0) return;
       $data = $this->getAll();
       $data[] = $value;
       $this->setAll($data);
    }
      
    public function shift(bool $del = true){
       if($this->type == 0) return false;
       $data = $this->getAll();
       if($del){
          $d = array_shift($data);
          $this->setAll($data);
          return $d;
       }
       foreach($data as $d){
          return $d;
       }
       return null;
    }
    
    public function pop(bool $del = true){
       if($this->type == 0) return false;
       $data = $this->getAll();
       if($del){
          $d = array_pop($data);
          $this->setAll($data);
          return $d;
       }
       return end($data);
    }
    
    public function getLength(){
       if($this->type == 0) return 0;
       return count($this->getAll());
    }
  }
}
