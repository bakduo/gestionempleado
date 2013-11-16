<?php

/*
#############################################################################
#@copyright   Copyright (c) 2013, linuxknow <linuxknow@gmail.com            #                                                                         #
#   util.php                                                                #
#   This program is free software: you can redistribute it and/or modify    #
#   it under the terms of the GNU General Public License as published by    #
#   the Free Software Foundation, either version 3 of the License, or       #
#   (at your option) any later version.                                     #
#                                                                           #
#   This program is distributed in the hope that it will be useful,         #
#   but WITHOUT ANY WARRANTY; without even the implied warranty of          #
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
#   GNU General Public License for more details.                            #
#                                                                           #
#   You should have received a copy of the GNU General Public License       #
#   along with this program.  If not, see <http://www.gnu.org/licenses/>    #
#                                                                           #
#############################################################################
*/
 function normalize_special_characters( $str ) 
{ 
    # Quotes cleanup nombre/%20Key%C2%B4s%20hotel
    //$str = ereg_replace( chr(ord("`")), "'", $str );        # ` 
    //$str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 
    //-$str = ereg_replace( chr(ord("`")), "", $str );        # ` 
    //-$str = ereg_replace( chr(ord("´")), "", $str );        # ´ 
    //-$str = ereg_replace( chr(ord("„")), ",", $str );        # „ 
    //$str = ereg_replace( chr(ord("`")), "'", $str );        # ` 
    //$str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 
    //-$str = ereg_replace( chr(ord("`")), "", $str );        # ` 
    //-$str = ereg_replace( chr(ord("´")), "", $str );        # ´ 
    //-$str = ereg_replace( chr(ord("“")), "\"", $str );        # “ 
    //-$str = ereg_replace( chr(ord("”")), "\"", $str );        # ” 
    //$str = ereg_replace( chr(ord("´")), "'", $str );        # ´ 
    //-$str = ereg_replace( chr(ord("´")), "", $str );        # ´

    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'); 
    $str = strtr( $str, $unwanted_array ); 

    # Bullets, dashes, and trademarks
    //-$str = ereg_replace( chr(149), "&#8226;", $str );    # bullet • 
    //-$str = ereg_replace( chr(150), "&ndash;", $str );    # en dash 
    //-$str = ereg_replace( chr(151), "&mdash;", $str );    # em dash 
    //-$str = ereg_replace( chr(153), "&#8482;", $str );    # trademark 
    //-$str = ereg_replace( chr(169), "&copy;", $str );    # copyright mark 
    //-$str = ereg_replace( chr(174), "&reg;", $str );        # registration mark 

    return $str; 
} 

 function exploteStr($str){
 		  $str = str_replace("´", "%", $str);
 		  $str = str_replace("`", "%", $str);
          $str = str_replace(".", "%", $str);
          $pieces = explode(" ",$str);
          $cadena='';
          if (count($pieces)>0){
            $cadena='%';
            for($i=0;$i<count($pieces);$i++) {
                $cadena.=$pieces[$i].'%';
            }
          }else{
            $cadena=$str;
          }
        return strtoupper(normalize_special_characters($cadena));
        //return $cadena;
      }
?>