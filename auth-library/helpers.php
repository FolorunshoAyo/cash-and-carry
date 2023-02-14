<?php
    function greeting(){
        $theDate = date("H"); 
        if($theDate < 12){
            return "Good morning to you";
        }  
        else if($theDate < 18) {
            return "Good afternoon to you"; 
        }
        else{
            return "Good evening to you"; 
        } 
    }
?>