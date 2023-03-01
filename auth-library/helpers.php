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

    function getDaysWeeks($months){
        $date1 = new DateTime();
        $date2 = new DateTime();
        $date2->modify("+$months month");

        $interval = $date1->diff($date2);

        $months = $interval->format("%m");
        $days = $interval->format("%a");

        $weeks = ceil((int) ($days/7));

        return array('days' => $days, 'weeks' => $weeks, 'months' => $months);
    }
?>