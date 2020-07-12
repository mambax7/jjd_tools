<?php
//  ------------------------------------------------------------------------ //
//            JJD-BIBLIO - Bibliothèque de fonction pour modules             //
//                Utilisées nottamment par Lexique et HErmes                 //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Création avril 2006
Dernière modification : septembre 2007
******************************************************************************/

include_once (XOOPS_ROOT_PATH."/class/xoopsformloader.php");
define ('_EDITOR_VERSION',     '1.10');

define ('_EDITOR_F_DHTMLTEXTAREA',     '/class/xoopsformloader.php');
define ('_EDITOR_F_KOIVI',             '/class/wysiwyg/formwysiwygtextarea.php');
define ('_EDITOR_F_TINY',              '/class/xoopseditor/tinyeditor/formtinyeditortextarea.php');
define ('_EDITOR_F_INBETWEEN',         '/class/xoopseditor/inbetween/forminbetweentextarea.php');
define ('_EDITOR_F_DHTMLA',            '/class/xoopseditor/dhtmla/formdhtmlatextarea.php');
define ('_EDITOR_F_FCKEDITOR',         '/class/xoopseditor/fckeditor/formfckeditor.php'); //grandoc 27/09/08 + MERCI GRANDOC JJD
define ('_EDITOR_F_KOIVI_X23',         '/class/xoopseditor/koivi/formwysiwygtextarea.php');
         
define ('_EDITOR_TEXTAREA',       0);
define ('_EDITOR_DHTMLTEXTAREA',  1);
define ('_EDITOR_KOIVI',          2);
define ('_EDITOR_TINY',           3);
define ('_EDITOR_INBETWEEN',      4);
define ('_EDITOR_DHTMLA',         5);
define ('_EDITOR_FCKEDITOR',      6);  //grandoc 27/09/08
define ('_EDITOR_KOIVI_X23',      7);

define ('_EDITOR_N_TEXTAREA',       'Standart TextBox');
define ('_EDITOR_N_DHTMLTEXTAREA',  'DHTML');
define ('_EDITOR_N_KOIVI',          'Koivi');
define ('_EDITOR_N_TINY',           'Tiny editor');
define ('_EDITOR_N_INBETWEEN',      'Inbetween');
define ('_EDITOR_N_DHTMLA',         'DHTML Advanced');
define ('_EDITOR_N_FCKEDITOR',      'FCKeditor'); //grandoc 27/09/08
define ('_EDITOR_N_KOIVI_X23',      'Koivi (Xoops 2.3+)');

/***************************************************************************
Ajout de la prise en charge d'un nouvel editeur
Dans les exemples ci dessous il faudra remplacer "WYSIWYG" par le nom de l'éditeur à intégrer
//--------------------------------------------------------------------------
//---1) ajout des constantes suivantes sur le modèles existant en tête du script

//Chemin de la classe qui gère l'éditeur
define ('_EDITOR_F_WYSIWYG',     '/class/xoopsformloader.php');

//Code associé à l'éditeur. Prendre le dernier +1
define ('_EDITOR_WYSIWYG',       6);

//un libellé qui sera affiché dans les listes déroulantes de sélection par exemple
define ('_EDITOR_WYSIWYG',       'Standart TextBox');  
//--------------------------------------------------------------------------
//---2) dans la fonction "getEditorHTML" ajouter un "case _EDITOR_N_WYSIWYG"
//et le code nécessaire pour renvoyer l'objet editor. Cete fonction doit tester si la classe existe et l'inclure
//ne pas oublier de mettre la variable $bolOk à true; si false c'est l'éditeur par défaut qui sera renvoyé'
//exemple:
     case _EDITOR_WYSIWYG:   //WYSIWYG
      $f = XOOPS_ROOT_PATH._EDITOR_F_WYSIWYG; 
        include_once ($f);          
        $ed  = new XoopsFormWYSIWYG($caption, $name, $value, $rows, $cols);/exemple
        $bolOk = true;       
  		 break;

//--------------------------------------------------------------------------
//---3 ajouter dans la fonction "getFullEditorList" un item à la fin du tableau

   array ('id' =>  _EDITOR_WYSIWYG,      'file' => _EDITOR_F_WYSIWYG,     'name' => _EDITOR_N_WYSIWYG));  


//--------------------------------------------------------------------------
//--4 utilisation: apeller une des fonctions "getEditorHTML", "getModuleEditor", "getXME"
// avec les paramètres qui vont bien
//notamment le code de l'éditeur choisie.

//getEditorHTML :  vous permet de définir l'éditeur que vous souhaitez 
//             en passant dans le premier paramètre la constante numérique définie plus haut
//

//getXoopsModuleEditor :  renvoi l'éditeur configuré dans votre module 
//             si il n'y a pas d'éditeur de configuré renvoi celui de XOOPS par défaut 
//             la fonction prend en dernier argument le nom attribué dans xoops_version
//             il est recommandé d'utiliser 'editor', cela évite de le passer en paramètre
//             à chaque fois puisque c'est la valeur par défaut
//

//getXME :  la même que getXoopsModuleEditor en plus concis

//exemple:

echo getEditorHTML(_EDITOR_F_WYSIWYG, $Montexte, 'txtDescription' , 'definition')
echo getXoopsModuleEditor($Montexte, 'txtDescription' , 'definition')
echo getXME($Montexte, 'txtDescription' , 'definition')

****************************************************************************/

/***************************************************************************
JJD - 15/07/2006
Nouvelle fonction pour int&eacute;grer un &eacute;diteur wywysig tel KOIVI
Cette option a &eacute;t&eacute; ajoutée dans la fen&ecirc;tre de param&egrave;trage du module
Je voulais ajouter les autres &eacute;diteurs connus mais je ne savais pas trop
il suffit normalement d'ajouter un <case> et de modifier 
le fichier xoops_version.php en cons&eacute;quense 
La ligne à changer:
$modversion['config'][xx]['options'] = array('Aucun' => 0, 'DHTML' => 1, 'Koivi' => 2);
function toto($param = array('a'=>1,'z'=>2,'e'=>8)){
echo "jjjjjjjj";
}

****************************************************************************/
function getEditorHTML($editor, &$value, $name = 'txtEdit', $caption = 'Texte',  
                   $width='80%', $height='200px', 
                   $rows = 8 , $cols = 69 ) {
   
   /*

   $height='50';
   $width='30px';
   echo "<hr>{$editor}-{$width}-{$height}<hr>";
   */   
  global $ed;

    $bolOk = false;


  switch($editor) {
   	 //-----------------------------------------------------------
     case _EDITOR_DHTMLTEXTAREA:   //DHTML
      $f = XOOPS_ROOT_PATH._EDITOR_F_DHTMLTEXTAREA; 
        include_once ($f);          
        $ed  = new XoopsFormDhtmlTextArea($caption, $name, $value, $rows, $cols);
        $bolOk = true;       
  		 break;
  		 
    //-----------------------------------------------------------  		 
     case _EDITOR_DHTMLA://DHTML avanc‚
      $f = XOOPS_ROOT_PATH._EDITOR_F_DHTMLA;
      if (is_readable($f)){
        include_once ($f);  
        $ed  = new XoopsFormDhtmlaTextArea($caption, $name, $value, $rows, $cols);
        $bolOk = true;      

      }
  		 break;
      
    //-----------------------------------------------------------
   	case _EDITOR_KOIVI:// KOIVI
      $f = XOOPS_ROOT_PATH._EDITOR_F_KOIVI;
      if (is_readable($f)){
        include_once ($f); 
        $ed  = new XoopsFormWysiwygTextArea ($caption, 
                                             $name, 
                                             $value, 
                                             $width, 
                                             $height);
        $bolOk = true;
      }
    	break;

    //-----------------------------------------------------------
   	case _EDITOR_KOIVI_X23:// KOIVI (xoops 2.3+))
      $f = XOOPS_ROOT_PATH._EDITOR_F_KOIVI_X23;
      if (is_readable($f)){
        include_once ($f); 
        $ed  = new XoopsFormWysiwygTextArea (array('caption'=> $caption,
                                                   'name'  => $name,
                                                   'value' => $value,
                                                   'width' => $width,                                                   
                                                   'height'=> $height),
                                                   true);
        $bolOk = true;
      }
    	break;
    	
    //-----------------------------------------------------------    	
   	case _EDITOR_TINY:// tinyeditor

      $f = XOOPS_ROOT_PATH._EDITOR_F_TINY;
      if (is_readable($f)){
        include_once ($f); 
        $ed  = new XoopsFormTinyeditorTextArea (array('caption'    => $caption,
                                                      'name'       => $name,
                                                      'value'      => $value,
                                                      'width'      => $width,
                                                      'height'     => $height,
                                                      'xEditor'    => 1));
       
        $bolOk = true;
      }
   	  

    	break;
    	
    //-----------------------------------------------------------    	
   	case _EDITOR_INBETWEEN: //inbetween

      $f = XOOPS_ROOT_PATH._EDITOR_F_INBETWEEN;
      if (is_readable($f)){
        include_once ($f); 
				$ed = new XoopsFormInbetweenTextArea(array('caption' => $caption, 
                                                   'name'    => $name, 
                                                   'value'   => $value, 
                                                   'width'   => $width, 
                                                   'height'  => $height));       
        $bolOk = true;      
      }
   	  

    	break;



 	
    //-----------------------------------------------------------	
	case _EDITOR_FCKEDITOR:// FCKeditor //grandoc 27/09/08

      $f = XOOPS_ROOT_PATH._EDITOR_F_FCKEDITOR;
      if (is_readable($f)){
        include_once ($f); 
        $ed  = new XoopsFormFckeditor (array('caption'    => $caption,
                                             'name'       => $name,
                                             'value'      => $value,
                                             'width'      => $width,
                                             'height'     => $height,
                                             'xEditor'    => 1));
       
        $bolOk = true;
      }
   	  

    	break;
    	
    //-----------------------------------------------------------
    //default:
  	//break;
  }
  
  //-----------------------------------------------------------  
  //si le fichier de l'editeur choisi n'existe pas on prend celui de Xoops par défaut
  if (!$bolOk){
      //dans tous les autres cas on utilise une zone de textarea standart
      $ed  = new XoopsFormTextArea($caption, $name, $value, $rows, $cols);   
  }
  //-----------------------------------------------------------  
  //echo "Editeur utilisé: {$editorName}<br>dans {$f}<br>";
  return $ed;
  
}

/***************************************************************************
JJD - 15/07/2006
Nouvelle fonction pour int&eacute;grer un &eacute;diteur wywysig tel KOIVI
Cet option a &eacute;t&eacute; ajoutée dans la fen&ecirc;tre de param&egrave;trage du module
Je voulais ajouter les autres &eacute;diteur connus mais je ne savais pas trop
il suffit normalement d'ajouter un <case> et de modifier 
le fichier xoops_version.php en cons&eacute;quense 
La ligne a changer:
$modversion['config'][xx]['options'] = array('Aucun' => 0, 'DHTML' => 1, 'Koivi' => 2);
function toto($param = array('a'=>1,'z'=>2,'e'=>8)){
echo "jjjjjjjj";
}

****************************************************************************/
function getXoopsModuleEditor(&$value, 
                              $name = 'txtEdit', $caption = 'Texte',  
                              $width='80%', $height='200px', 
                              $rows = 8 , $cols = 69,
                              $configName = 'editor') {
//$configName  est le nom attribué dans xoops_version pour l'éditeur.
// chaine vide prend 'editor' par défaut
  global $ed, $xoopsModuleConfig;
  
  if ($configName == '') $editor = 'editor';
  
  $editor = (isset($xoopsModuleConfig[$configName]))?$xoopsModuleConfig[$configName]:0;   
  
  //return getEditorHTML ($editor, &$value, $name , $caption , 
  //                  $width, $height, $rows, $cols );
                    
  return getEditorHTML ($editor, $value, $name , $caption , 
                    $width, $height, $rows, $cols );
  
}
/******************************************************************************
 *La même que getXoopsModuleEditor en plus court
 *****************************************************************************/
function getXME(&$value, $name = 'txtEdit', $caption = 'Texte',  
                $width='80%', $height='200px', 
                $rows = 8 , $cols = 69,
                $configName = 'editor' ) {
  
//  return getXoopsModuleEditor (&$value, $name , $caption , 
//                               $width, $height, $rows, $cols, $configName);
 
  return getXoopsModuleEditor ($value, $name , $caption , 
                               $width, $height, $rows, $cols, $configName);
  
}

/***************************************************************************
 *Renvoi la liste de tous les éditeurs pris en charge par les fonctions de ce script
 ***************************************************************************/
 function getFullEditorList() {
     
    $ed = array( 
            array ('id' =>  _EDITOR_TEXTAREA,       'file' => "",                      'name' => _EDITOR_N_TEXTAREA),
            array ('id' =>  _EDITOR_DHTMLTEXTAREA,  'file' => _EDITOR_F_DHTMLTEXTAREA, 'name' => _EDITOR_N_DHTMLTEXTAREA),
            array ('id' =>  _EDITOR_DHTMLA,         'file' => _EDITOR_F_DHTMLA,        'name' => _EDITOR_N_DHTMLA),
            array ('id' =>  _EDITOR_KOIVI,          'file' => _EDITOR_F_KOIVI,         'name' => _EDITOR_N_KOIVI),
            array ('id' =>  _EDITOR_TINY,           'file' => _EDITOR_F_TINY,          'name' => _EDITOR_N_TINY),
            array ('id' =>  _EDITOR_INBETWEEN,      'file' => _EDITOR_F_INBETWEEN,     'name' => _EDITOR_N_INBETWEEN),
	          array ('id' =>  _EDITOR_FCKEDITOR,      'file' => _EDITOR_F_FCKEDITOR,     'name' => _EDITOR_N_FCKEDITOR),
	          array ('id' =>  _EDITOR_KOIVI_X23,      'file' => _EDITOR_F_KOIVI_X23,     'name' => _EDITOR_N_KOIVI_X23));
  return $ed;
  
}

  
/***************************************************************************
 *Renvoi la liste des éditeurs installés, du moins ceux que je connais
 ***************************************************************************/
 function getEditorList() {
  
  global $ed;

    $ed = getFullEditorList();  

    $t = array();
    $h = 0;    
    $t[$ed[$h]['name']] = $ed[$h]['id'];    
    

    for ($h = 1; $h < count($ed); $h++){
      //echo "<hr>count = {$h}/".count($ed)." -> {$ed[$h]['file']}<hr>";    
      $f = str_replace('//','/', XOOPS_ROOT_PATH.$ed[$h]['file']);
      //echo "<hr>{$f}";      
      if (is_readable($f)){
          $t[$ed[$h]['name']] = $ed[$h]['id'];
          

      }
    }  
  
  return $t;
  
}

/***************************************************************************
 *Renvoi la liste des éditeurs installés, du moins ceux que je connais
 ***************************************************************************/
 function getEditorList2() {
  
  global $ed;
    $lib = 'lib';
    $val = 'val';
    $id  = 'id';
  
  
    $ed = getFullEditorList();  

    $t = array();
    //---------------------------------------------------------------
    $h = 99;    
    //$t[$ed[$h]['name']] = $ed[$h]['id'];    
    $t[] = array($lib => '',  $val => $h, $id => $h);     
    //---------------------------------------------------------------
    $h = 0;    
    //$t[$ed[$h]['name']] = $ed[$h]['id'];    
    $t[] = array($lib => $ed[$h]['name'],  $val => $ed[$h]['id'], $id => $ed[$h]['id']);     
    //---------------------------------------------------------------
    
    
    
    
    
    for ($h = 1; $h < count($ed); $h++){
      //echo "<hr>count = {$h}/".count($ed)." -> {$ed[$h]['file']}<hr>";    
      $f = str_replace('//','/', XOOPS_ROOT_PATH.$ed[$h]['file']);
      //echo "<hr>{$f}";      
      if (is_readable($f)){
          //$t[$ed[$h]['name']] = $ed[$h]['id'];
          $t[] = array($lib => $ed[$h]['name'],  $val => $ed[$h]['id'], $id => $ed[$h]['id']);          

      }
    }  
  
  return $t;


  
}

?>
