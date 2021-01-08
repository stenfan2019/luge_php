<?php
/**
 * 一分快三
 * @author stenfan
 */
namespace common\models\lottery;
use common\models\lottery\Base;
use yii;

class Lyfks extends Base
{
    protected $code;
    
    public $is_win = false;
    
    
    public function __construct($code,$type)
    {
        $this->code = $code;
        
        $fn = "fn{$type}";
        $this->$fn();
        
        return $this->is_win;
    }
    
    //大：11-17
    protected function fn1048()
    {
         $sum = $this->_sum();
         if($sum >= 11){
             $this->is_win = true;
         }
    }
    //小：4-10
    protected function fn1049()
    {
        $sum = $this->_sum();
        if($sum < 11 && $sum > 3){
            $this->is_win = true;
        }
    }
    //单
    protected function fn1050()
    {
        $sum = $this->_sum();
        if($sum % 2 == 1){
            $this->is_win = true;
        }
    }
    //双
    protected function fn1051()
    {
        $sum = $this->_sum();
        if($sum % 2 == 0){
            $this->is_win = true;
        }
    }
    
    //多点:4
    protected function fn1052()
    {
        $sum = $this->_sum();
        if(4 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:5
    protected function fn1053()
    {
        $sum = $this->_sum();
        if(5 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:6
    protected function fn1054()
    {
        $sum = $this->_sum();
        if(6 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:7
    protected function fn1055()
    {
        $sum = $this->_sum();
        if(7 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:8
    protected function fn1056()
    {
        $sum = $this->_sum();
        if(8 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:9
    protected function fn1057()
    {
        $sum = $this->_sum();
        if(9 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:10
    protected function fn1058()
    {
        $sum = $this->_sum();
        if(10 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:11
    protected function fn1059()
    {
        $sum = $this->_sum();
        if(11 == $sum){
            $this->is_win = true;
        }
    }
    
    
    //多点:12
    protected function fn1060()
    {
        $sum = $this->_sum();
        if(12 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:13
    protected function fn1061()
    {
        $sum = $this->_sum();
        if(13 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:14
    protected function fn1062()
    {
        $sum = $this->_sum();
        if(14 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:15
    protected function fn1063()
    {
        $sum = $this->_sum();
        if(15 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:16
    protected function fn1064()
    {
        $sum = $this->_sum();
        if(16 == $sum){
            $this->is_win = true;
        }
    }
    
    //多点:17
    protected function fn1065()
    {
        $sum = $this->_sum();
        if(17 == $sum){
            $this->is_win = true;
        }
    }
    //三军:111
    protected function fn1066()
    {
        if('111' == $this->code){
            $this->is_win = true;
        }
    }
    
    //三军:222
    protected function fn1067()
    {
        if('222' == $this->code){
            $this->is_win = true;
        }
    }
    
    //三军:333
    protected function fn1068()
    {
        if('333' == $this->code){
            $this->is_win = true;
        }
    }
    
    //三军:444
    protected function fn1069()
    {
        if('444' == $this->code){
            $this->is_win = true;
        }
    }
    
    //三军:555
    protected function fn1070()
    {
        if('555' == $this->code){
            $this->is_win = true;
        }
    }
    
    //三军:666
    protected function fn1071()
    {
        if('666' == $this->code){
            $this->is_win = true;
        }
    }
    
    
    protected function _sum()
    {
        $n1 = substr($this->code, 0,1);
        $n2 = substr($this->code, 1,1);
        $n3 = substr($this->code, 2,1);
        return $n1 + $n2 + $n3;
    }
}