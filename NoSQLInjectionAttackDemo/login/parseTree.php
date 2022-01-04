<?php
namespace control;
class ParseTree{
	
	function parseTree($string){
		
		if(strpos($string,'$gt') || (strpos($string,'//')) || strpos($string,'$ne') || strpos($string,'$lt') || strpos($string,'$lte') || strpos($string,'$gte'))  return true;
		else return false;
		
	}
}