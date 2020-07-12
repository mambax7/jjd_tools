<?php
//  ------------------------------------------------------------------------ //
//                      JJD-SPIN - Composant spinButton                      //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                            //
//  ------------------------------------------------------------------------ //
/******************************************************************************

 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Création avril 2006
Dernière modification : septembre 2007
******************************************************************************/
/*
 * Pour obtenir les infos sur le serveur ...
 *
 */
function ParseURLplus($url){
	$URLpcs = parse_url($url);
	$PathPcs = explode("/",$URLpcs['path']);
	$URLpcs['file'] = end($PathPcs);
	unset($PathPcs[key($PathPcs)]);
	$URLpcs['dir'] = implode("/",$PathPcs);

return ($URLpcs);
}

/*
 * Pour triturer deux chaines de caractères ... et en extraires certaines parties (ds les deux sens ...)
 *
 */
function diffstringsimilar($string1,$string2,$reverse=FALSE) {
$substring = array ();
//echo "<b style='color:red'>" . $string1 . "</b><br />";
//echo "<b style='color:red'>" . $string2 . "</b><br />";
$length1 = strlen($string1);
$length2 = strlen($string2);
$substring1 = $substring2 = '';
$pass = TRUE;
$i = 0;

$length = ($length1<$length2) ? $length2:$length1;

	if ($reverse==TRUE){ 
		$string1=strrev($string1);
		$string2=strrev($string2);
	}

	while ($i++<$length)
	{
		if ($pass && ($string1[$i] == $string2[$i]))
		{
			continue;
		}
		else {
			$substring1 .= $string1[$i];
			$substring2 .= $string2[$i];
			$pass=FALSE;
		}
	}
		
	if ($reverse==TRUE){ 
		$substring1=strrev($substring1);
		$substring2=strrev($substring2);
	}

$substring[0] = $substring1;
$substring[1] = $substring2;
return $substring;
}



/***********************************************************************
 * construit une ligne avec un spinButton
 ***********************************************************************/
function buildSpin($title, $description, $name, $default, 
                   $max, $min, $smallInc, $largeInc, $fin = '', 
                   $unit = '', $imgFolder = ''){
    
    
    
    $t = array();
    $t[] = "<TR>";
    $t[] = "<TD align='left' ><B>{$imgFolder}{$title}</B></TD>";
  

    $spin =  htmlSpin ("",$name, $default, $max, $min,$smallInc ,$largeInc ,
                       $imgFolder, 1, '','', $unit);
    
    $t[] = "<TD align='left' >{$spin}</TD>"._br; 
    
    $t[] = "</TR>";    
    
    if ($description <> ''){$t[] = buildDescription($description);}
    if ($fin         <> ''){$t[] = $fin;}    
    //-------------------------------------
    return  _br.implode(_br, $t)._br; 

}


/*******************************************************************
 *
 *******************************************************************/
function htmlSpin($Caption, $prefixe, 
                  $lValue, $lMax, $lMin = 0, $lIncrement = 1, 
                  $size = 12, 
                  $sFolderImg = "", $lSizeImg = 1,
                  $styleBordure = '', $styleText = '', 
                  $unit = ''){

 
     if ($sFolderImg == ''){
      //$sFolderImg = XOOPS_URL."/include/jjd/images/";
      //$sFolderImg = dirname($_SERVER['REQUEST_URI']).'/images/';    
      //$sFolderImg = dirname(__FILE__).'/images/';       
      
      
 /*
         $t1 = explode ("/", $_SERVER['SERVER_PROTOCOL']);     
        $sf = $t1[0].'://'.$_SERVER['SERVER_NAME'].substr( dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']));
        $sFolderImg= str_replace('\\','/',$sf).'/images/';
        //$sFolderImg = dirname(__FILE__)."/";       
 
  $ts = array();
  $ts [] = $t1[0].'://';
  $t [] =  $_SERVER['SERVER_NAME'];

  $tf = explode ("/", $_SERVER['PHP_SELF']);
  $tf[ count($tf)-1 ] = "images";
  $sFolderImg = $t1[0].':/'.implode('/', $tf)."/";
echo $sFolderImg."<br>";
echo __FILE__."<br>";
 echo 'PHP_SELF --> '.$_SERVER['PHP_SELF']."<br>";

 */   
 
 /*--------------------------------------------------------------------------
 transfomation du chemin physique des images en url (JJD)
 ---------------------------------------------------------------------------*/
$STR0 = array ();
$STR1 = array ();
$URLpcs1 = ParseURLplus($_SERVER['PHP_SELF']);
$cp = str_replace ('\\', '/' , dirname(__FILE__) );  //remplace les \ par de / because windows

$STR0=diffstringsimilar(getcwd(),$cp,FALSE);
//echo $STR0[1]; echo "<br />";

$STR1=diffstringsimilar($URLpcs1['dir'],$STR0[0],TRUE);
//echo $STR1[0]; echo "<br />";

$t1 = explode ("/", $_SERVER['SERVER_PROTOCOL']);    //recupere juste le protocole sans la version
//echo $t1[0];


$sFolderImg = $t1[0].'://'.$_SERVER['SERVER_NAME'].'/'. $STR1[0] . $STR0[1] . '/images/'; //construction de l'url de base des images

// this sets the sytem / or \ :
strstr( PHP_OS, "WIN") ? $slash = "\\" : $slash = "/";

// This is the location of the php file that contains this
// function. Usually this request is made to files/folders
// down the directory structure, so the php file that
// contains these functions is a good "where am i"
// reference point:
$WIMPY_BASE['path']['physical'] = getcwd();
$WIMPY_BASE['path']['www'] = "http://".$_SERVER['HTTP_HOST'];


 $t1 = explode ("/", $_SERVER['SERVER_PROTOCOL']);    //recupere juste le protocole sans la version
 $t = explode('/', $_SERVER['PHP_SELF']);             //decoupe du de l'url du script pour recuperer la racine 
$t=$_SERVER['PHP_SELF'];
 $root = $t[1];                                       //recupe de la racine du site
 $cp = str_replace ('\\', '/' , dirname(__FILE__) );  //remplace les \ par de / because windows
 //$pos = stripos ($cp , $root);                        //recheche ans le chemin pysique du script de la racine du site
 //$fin = strstr($cp, $root);
 
 // $tf = explode($root, $cp);
 //$sFolderImg = $t1[0].'://'.$_SERVER['SERVER_NAME'].'/'.$fin.'/images/'; //construction de l'url de base des images
// TROP beau :  $sFolderImg = $cp . '/images/';
//echo $sFolderImg;

 /*
  echo  $root."<br>";
 echo  $sFolderImg."<br>"; 

C] Les variables :
Enfin les variables que tu voulais :
$_SERVER['SERVER_NAME']=debian.lan => OK
dirname(__FILE__)=/home/bruno/Travail/public_html/tba1/htdocs/modules/tba => 
OK
$_SERVER['DOCUMENT_ROOT']=/var/www/ => OK

Pour moi elles sont bonnes, car le serveur tourne par défaut dans '/var/www/' 
Je regarde dans le fichier (/etc/apache2/sites-available/default) où cette 
variable est définie : DocumentRoot /var/www/

Enfin, je n'ai pas touché du tout à ces fichiers ... C'est la configue par 
défaut avec l'activation du répertoire en question (public_html) ...
--------------------------

L'url n'est pas bien bâtie :
http://debian.lanno/Travail/public_html/tba1/htdocs/modu ...

OR ce devrait-être :
http://debian.lan/~bruno/tba1/htdocs/modu ...

----------------------------------------------------
 
 
 
 
 
 
      
      $t1 = explode ("/", $_SERVER['SERVER_PROTOCOL']);     
      $t2 = explode ("/", $_SERVER['SCRIPT_NAME']);
      $u = count($t2) - 1;
      $t2[$u] = 'images';
      $sFolderImg = $t1[0].':/'.implode('/', $t2).'/';   
  */       
 /*
       
    $t1 = explode ("/", $_SERVER['SERVER_PROTOCOL']);
    $t2 = explode ("/", $_SERVER['PHP_SELF']);
    $u = count($t2) - 1;
    $t2[$u] = 'images';
    
    
    //array_slice
    $sFolderImg = $t1[0].'://'.$_SERVER['SERVER_NAME'].implode('/', $t2);    
    
        echo $sFolderImg;
 
 */  
 
       
    }
    
    
  //  echo "<hr>{$sf}<hr>";    
  //$onMouseDown1 = "onSpinStart(\"{$prefixe}\",1, 200);";
  //$onMouseDown2 = "onSpinStart(\"{$prefixe}\",-1,200);";  
  $prefixe2 = 'spin'.$prefixe;
  
  $onMouseDown1 = "spinStart(\"{$prefixe}\", \"{$prefixe2}\",  1,  10, 200, \"{$sFolderImg}spin/spinUp1{$lSizeImg}.gif\");";
  $onMouseDown2 = "spinStart(\"{$prefixe}\", \"{$prefixe2}\", -1, -10, 200, \"{$sFolderImg}spin/spinDown1{$lSizeImg}.gif\");";  
  
  $onMouseUp = "spinStop();";  
  //----------------------------------------------------------------
  $styleBordureDefault = "color: #FFFF00; background-color: #CCCCCC; line-height: 100%;border-width:1; border-style: solid; border-color: #000000; margin-top: 0; margin-bottom: 0; padding: 0";
  $styleTextDefault    = "color: #000000; text-align: right; margin-left: 1; margin-right: 2; padding-right: 8";
  
  $styleBordure = htmlAddAttribut ('style', $styleBordure, $styleBordureDefault);
  $styleText    = htmlAddAttribut ('style', $styleText,    $styleTextDefault);  
  $styleArrow = "style=\"text-align: center; line-height: 100%; font-size: 7 pt; margin-top: 0; margin-bottom: 0; padding: 0\"";
  //----------------------------------------------------------------  
  $t = array();

  
  //<Div style="width:646px;height:370px;overflow:auto;">
  $t[] = "<div STYLE='width:50px'>";  
  //$t[] = "<table border='0' width='8%' cellpadding='0' cellspacing='0'>";
  $t[] = "<table border='0' width='8%' cellpadding='0' cellspacing='0' {$styleBordure}>";  
  $t[] = "  <tr>";
  //$t[] = "    <td width='60%'>{$Caption}</td>";    
  $t[] = "    <td width='60%'>";
  $t[] = "    	<INPUT TYPE='hidden' NAME='{$prefixe2}_min' VALUE='{$lMin}'>";
  $t[] = "    	<INPUT TYPE='hidden' NAME='{$prefixe2}_max' VALUE='{$lMax}'>";  
  $t[] = "    	<INPUT TYPE='hidden' NAME='{$prefixe2}_increment' VALUE='{$lIncrement}'  style='text-align: right'>";  
  $t[] = "      <input type='text'  name='{$prefixe}' size='{$size}' value='{$lValue}' {$styleText}>";
  $t[] = "    </td>";
  $t[] = "    <td width='63%' align='center' {$styleArrow}>";


//  $t[] = "      <img border='0' src='{$sFolderImg}spin/spinUp{$lSizeImg}.gif'   onclick='{$onClick1}' onmouseover='{$onClick1}'><br>";
  //$t[] = "      <img border='0' src='{$sFolderImg}spin/spinDown{$lSizeImg}.gif' onclick='{$onClick2}' onmouseover='{$onClick2}'>";

//  $t[] = "      <img border='0' src='{$sFolderImg}spin/spinUp{$lSizeImg}.gif'   onclick='{$onClick1}' ><br>";
//  $t[] = "      <img border='0' src='{$sFolderImg}spin/spinDown{$lSizeImg}.gif' onclick='{$onClick2}' >";

  $t[] = "      <img border='0' name='{$prefixe2}_img0' src='{$sFolderImg}spin/spinUp0{$lSizeImg}.gif'   onmousedown='{$onMouseDown1}' onmouseup='{$onMouseUp}' onmouseout='{$onMouseUp}'><br>";
  $t[] = "      <img border='0' name='{$prefixe2}_img1' src='{$sFolderImg}spin/spinDown0{$lSizeImg}.gif' onmousedown='{$onMouseDown2}' onmouseup='{$onMouseUp}' onmouseout='{$onMouseUp}'>";

  $t[] = "    </td>";
  
  if ($unit <> ''){
    $t[] = "    <td>&nbsp;&nbsp;{$unit}&nbsp;&nbsp;</td>";  
  }
  
  
  $t[] = "  </tr>";
  $t[] = "</table>"._br;
  $t[] = "</div>";
  
  $html = implode (_br, $t);
  return $html;
}








?>
