<<<<<<< HEAD
﻿<?php

 function rand_char($phone){
    $characters =array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'G', 'K',  'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','2','3','4','5','6','7','8','9');
	$list=array();$arr=explode("-",date('Y-m-d-H-i-s',time()));
	foreach($arr as $key=>$valus)
	{
	    if($key=='0')
		{
		  $str=substr($valus,2,2);
		}else
		{
		  $str=$valus;
		}
		if($str!=='00')
		{
			if(strpos($str,'0')!==false)
			{ 
			   if(strpos($str,'0')=='0')
			   {
				 $str=str_replace('0','',$str);
			   }
			}
	    }
		$list[]=$characters[(int)$str];
	}
   $rs=join("", $list);
   $phone=substr($phone,7,4);
   $rs=$rs.$characters[(int)$phone{0}];
   $rs=$rs.$characters[(int)$phone{1}];
   $rs=$rs.$characters[(int)$phone{2}];
   $rs=$rs.$characters[(int)$phone{3}];
   return  $rs;
 }


function randCode($num,$arr=array())
{
   if(count($arr)>0)
   {
      $characters =$arr;
  
   }else
   {
      $characters = array(
       "0","1","2","3","4","5","6","7","8","9");
   }
 
   $keys = array();
   while(count($keys) < $num) 
   {
   
       $x = mt_rand(0, count($characters)-1);
       if(!in_array($x, $keys)) 
	   {
          $keys[] = $x;
       }
   }
  $random_chars='';
   foreach($keys as $key)
   {
        $random_chars .= $characters[$key];
   }
   return  $random_chars;
   
}


function randKey($imei){
    $imei=str_replace(':','',$imei);
	$count=strlen($imei);
	if($count>6){
	   $pretext=substr($imei, 0, 6);
	   $lasttext=substr($imei, 5);
	   $imei=$lasttext.'2s'.$pretext;
	}
    $characters =array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'G', 'K',  'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','2','3','4','5','6','7','8','9');
	$list=array();$arr=explode("-",date('Y-m-d-H-i-s',time()));
	foreach($arr as $key=>$valus)
	{
	    if($key=='0')
		{
		  $str=substr($valus,2,2);
		}else
		{
		  $str=$valus;
		}
		if($str!=='00')
		{
			if(strpos($str,'0')!==false)
			{ 
			   if(strpos($str,'0')=='0')
			   {
				 $str=str_replace('0','',$str);
			   }
			}
	    }
		$list[]=$characters[(int)$str];
	}
   $rs=join("", $list);
   return  $imei.$rs;
 }
=======
﻿<?php

 function rand_char($phone){
    $characters =array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'G', 'K',  'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','2','3','4','5','6','7','8','9');
	$list=array();$arr=explode("-",date('Y-m-d-H-i-s',time()));
	foreach($arr as $key=>$valus)
	{
	    if($key=='0')
		{
		  $str=substr($valus,2,2);
		}else
		{
		  $str=$valus;
		}
		if($str!=='00')
		{
			if(strpos($str,'0')!==false)
			{ 
			   if(strpos($str,'0')=='0')
			   {
				 $str=str_replace('0','',$str);
			   }
			}
	    }
		$list[]=$characters[(int)$str];
	}
   $rs=join("", $list);
   $phone=substr($phone,7,4);
   $rs=$rs.$characters[(int)$phone{0}];
   $rs=$rs.$characters[(int)$phone{1}];
   $rs=$rs.$characters[(int)$phone{2}];
   $rs=$rs.$characters[(int)$phone{3}];
   return  $rs;
 }


function randCode($num,$arr=array())
{
   if(count($arr)>0)
   {
      $characters =$arr;
  
   }else
   {
      $characters = array(
       "0","1","2","3","4","5","6","7","8","9");
   }
 
   $keys = array();
   while(count($keys) < $num) 
   {
   
       $x = mt_rand(0, count($characters)-1);
       if(!in_array($x, $keys)) 
	   {
          $keys[] = $x;
       }
   }
  $random_chars='';
   foreach($keys as $key)
   {
        $random_chars .= $characters[$key];
   }
   return  $random_chars;
   
}


function randKey($imei){
    $imei=str_replace(':','',$imei);
	$count=strlen($imei);
	if($count>6){
	   $pretext=substr($imei, 0, 6);
	   $lasttext=substr($imei, 5);
	   $imei=$lasttext.'2s'.$pretext;
	}
    $characters =array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'G', 'K',  'L', 'M', 'N', 'O', 'P', 'Q', 'R','S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','2','3','4','5','6','7','8','9');
	$list=array();$arr=explode("-",date('Y-m-d-H-i-s',time()));
	foreach($arr as $key=>$valus)
	{
	    if($key=='0')
		{
		  $str=substr($valus,2,2);
		}else
		{
		  $str=$valus;
		}
		if($str!=='00')
		{
			if(strpos($str,'0')!==false)
			{ 
			   if(strpos($str,'0')=='0')
			   {
				 $str=str_replace('0','',$str);
			   }
			}
	    }
		$list[]=$characters[(int)$str];
	}
   $rs=join("", $list);
   return  $imei.$rs;
 }
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
?>