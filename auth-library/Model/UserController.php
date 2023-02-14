<?php
require_once  __DIR__."/Database.php";
 
class UserModel extends Database

{
    public function getUsers_limit($limit)
    {
        return $this->select("SELECT * FROM users LIMIT ?", ["i", $limit]);
    }

    public function getUsersAll()
    {
        return $this->executeQuery("SELECT * FROM users");
    }

    public function getUser_where($col, $val, $type) 
    {
        if($type=="s"){
            return $this->executeQuery("SELECT * FROM users WHERE $col='$val'");
        }else{
            return $this->executeQuery("SELECT * FROM users WHERE $col=$val");
        }
    }

    public function getUser_where_operand($col1, $val1, $type1, $oprand, $col2, $val2, $type2) 
    {
        if($type1 == "s" && $type2 == "s"){
            return $this->executeQuery("SELECT * FROM users WHERE $col1='$val1' $oprand $col2='$val2'");
            
        }elseif($type1 == "s" && $type2 != "s"){
            return $this->executeQuery("SELECT * FROM users WHERE $col1='$val1' $oprand $col2=$val2");
            
        }elseif($type1 != "s" && $type2 == "s"){
            return $this->executeQuery("SELECT * FROM users WHERE $col1=$val1 $oprand $col2='$val2'");
            
        }elseif($type1 != "s" && $type2 != "s"){
            return $this->executeQuery("SELECT * FROM users WHERE $col1=$val1 $oprand $col2=$val2");
        }
    }
    
}
?>