<?php
//  ------------------------------------------------------------------------ //
//       HERMES - Module de gestion de lettre de diffusion pour XOOPS        //
//                    Copyright (c) 2006 JJ Delalandre                       //
//                       <http://xoops.kiolo.com>                                  //
//  ------------------------------------------------------------------------ //
/******************************************************************************

Module HERMES version 1.1.1pour XOOPS- Gestion de lettre de diffusion 
Copyright (C) 2007 Jean-Jacques DELALANDRE 
Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes de la Licence Publique Générale GNU publiée par la Free Software Foundation (version 2 ou bien toute autre version ultérieure choisie par vous). 

Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE, ni explicite ni implicite, y compris les garanties de commercialisation ou d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU pour plus de détails. 

Vous devez avoir reçu une copie de la Licence Publique Générale GNU en même temps que ce programme ; si ce n'est pas le cas, écrivez à la Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, +tats-Unis. 

Créeation juin 2007
Dernière modification : septembre 2007 
******************************************************************************/

//include_once ("admin_header.php");
include_once ('../../../include/cp_header.php');
include_once (XOOPS_ROOT_PATH."/include/xoopscodes.php");

//-----------------------------------------------------------------------------------
global $xoopsModule;

//$f = dirname(__FILE__);
define ('_JJD_ROOT_PATH_AO',  XOOPS_ROOT_PATH."/modules/jjd_tools/_common/");
define ('_JJD_ROOT_URL_AO',  XOOPS_URL."/modules/jjd_tools/_common/");
include_once (_JJD_ROOT_PATH_AO.'include/constantes.php');
include_once (_JJD_ROOT_PATH_AO.'include/functions.php');
include_once (_JJD_ROOT_PATH_AO.'include/html_functions.php');


//-----------------------------------------------------------------------------------

//define ('_HER_ROOT_PATH', XOOPS_ROOT_PATH.'/modules/hermes/');


/************************************************************************
 *
 ************************************************************************/

function adminOnglet_test ($message = 'coucouc') {
  echo "<hr>{$message}<hr>";
}

/************************************************************************
 *
 ************************************************************************/

function admin_adminMenu ($currentoption = 0, $xm = '') {

	include_once XOOPS_ROOT_PATH . '/class/template.php';
	
	

  $modulePath = XOOPS_ROOT_PATH."/modules/".$xm->getVar('dirname')."/";
	// global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	global $xoopsModule, $xoopsConfig;
/*
*/
	if (file_exists( $modulePath . 'language/' . $xoopsConfig['language'] . '/modinfo.php')) {
		include_once  $modulePath . 'language/' . $xoopsConfig['language'] . '/modinfo.php';
	} else {
		include_once  $modulePath . 'language/english/modinfo.php';
	}
	if (file_exists( $modulePath . 'language/' . $xoopsConfig['language'] . '/admin.php')) {
		include_once  $modulePath . 'language/' . $xoopsConfig['language'] . '/admin.php';
	} else {
		include_once  $modulePath . 'language/english/admin.php';
	}
	
 include  ($modulePath."admin/menu.php");
 //$configModule =  "<p>-&nbsp;<A HREF=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod=".$xm->getVar('mid')."\">".'Config'."</a><br></p>";
 //$homePage = "<a href='".XOOPS_URL."'>".'Home page'."</a>";
 
 
 $configModule =  "<A HREF=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod=".$xm->getVar('mid')."\">".'Config'."</a>";
 $homePage = "<a href='".XOOPS_URL."'>".'Home page'."</a>";
 $moduleIHM = "<A HREF=\"".XOOPS_URL."/modules/".$xm->getVar('dirname')."\">".'Module'."</a>";
	//-------------------------------------------------------------------------
	//include 'menu.php';
	//$xoopsModule->getVar('dirname')
//$f = $modulePath."admin/menu.php";
//echo "<hr>{$f}<hr>";
//include (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/admin/menu.php");	
	
  //-------------------------------------------------------------------------
	//global $adminmenu;
	$tpl =& new XoopsTpl();
	$tpl->assign( 'configModule', $configModule);	
	$tpl->assign( 'homePage',     $homePage);	
	$tpl->assign( 'moduleIHM',    $moduleIHM);	
	
	$headermenu =array();
	
	$tpl->assign( array(	
	'headermenu'	    => $headermenu,
	'adminmenu'		    => $adminmenu,
	'current'		      => $currentoption,
	'homePage'	      => $homePage,
	'headermenucount' => count($headermenu),
	'folderImg'       => _JJD_ROOT_URL_AO.'include/adminOnglet/images'
	) );

	$tpl->display( 'db:adminOnglet.html');
	//echo "<br />\n";
}

/************************************************************************
 *
 ************************************************************************/
function admin_xoops_cp_header($onglet = 1, $xm ='')
{
	xoops_cp_header();

	//$link = "<a href='".XOOPS_URL."'>".'Home page'."</a>";
  admin_adminMenu($onglet, $xm);	

}

/************************************************************************
 *
 ************************************************************************/
function admin_xoops_cp_footer()
{
  echo "</table>";  
  //echo "</div></div>";


	xoops_cp_footer();	

}

/************************************************************************
 *
 ************************************************************************/

function viewDoc ($doc, $lang, $root) {
global $xoopsModule, $xoopsDB, $xoopsConfig;
 
    
  //echo "<hr>{$doc}<hr>{$lang}<hr>{$root}<hr>";
  echo _JJD_JSI_TOOLS;
  //echo _JJD_JSI_SPIN;  
  
    
    OpenTable();
    //**********************************************************************************    
    
    echo "<table>";  
      echo '<tr>';              
      echo '<td>';
      //----------------------------------------------------------

      
      //$f = _HER_ROOT_PATH."doc/{$docRoot}-{$lang}.htm";
      $f = $root."doc/{$doc}-{$lang}.htm";     
      //$f = getURLDoc($xoopsModule['name'], $doc) ;
      
      //echo "<hr>{$f}<hr>";
      //$f = XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/doc/{$doc}-{$lang}.htm";      
  
      //echo "<hr>viewDoc -> {$f}<hr>";
      readfile ($f);
      //----------------------------------------------------------      
      echo '</td>';      
      echo '</tr>';    
    echo "</table>";      


    //**********************************************************************************
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("../admin/index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    
  </tr>
  </form>";

    
	CloseTable();

}

/************************************************************************
 *
 ************************************************************************/

function viewDocFromSite ($module, $doc, $lang, $root) {
global $xoopsModule, $xoopsDB, $xoopsConfig;
 
    
  //echo "<hr>{$doc}<hr>{$lang}<hr>{$root}<hr>";
  echo _JJD_JSI_TOOLS;
  //echo _JJD_JSI_SPIN;  

    
    OpenTable();
    //**********************************************************************************    
    
    //echo "<table width='100%' cellpadding='0'>";  
      //echo '<tr>';              
      //echo "<td width='100%'>";
      //----------------------------------------------------------
      if ($root == '') {
        $f = getURLDoc($module, $doc) ;      
      }else
      {
        $f = $root."/{$module}/doc/{$doc}-{$lang}.htm";      
      }
      
      
      
      
      //$f = str_replace('//', '/', $f);
      $protocole = 'http://';
      if (substr($f, 0, strlen($protocole)) <> $protocole) $f = $protocole.$f;
      //echo "<hr>viewDoc -> {$f}<hr>";      
      
      
      echo "<iframe src={$f} Name='doc' Width='100%' Height='500' "
          ."Frameborder='0' Marginwidth='0' Marginheight='0' "
          ."Hspace='0' Vspace='0' Noresize></iframe>";
      
/*      

      
      if (substr($f,0,strlen(XOOPS_URL)) == XOOPS_URL){
        readfile ($f);      
      }else{
        echo "<iframe src={$f} Name='doc' Width='100%' Height='500' "
            ."Frameborder='0' Marginwidth='0' Marginheight='0' "
            ."Hspace='0' Vspace='0' Noresize></iframe>";
        
        

        
   	Align  	Aligne un frame flottant à gauche, au centre ou à droite de l'écran.  	   	 
  	Name 	Attribue un nom au frame flottant 	  	 
  	Noresize 	Précise au navigateur que l'utilisateur ne peut modifier la taille du frame. Attribut sans paramètre. 	  	 
  	SRC 	Définit le document source et son adresse 	  	 
  	Width 	Permet de définir la largeur de la fenêtre ouverte. 	  	 
  	Height 	Définit la hauteur de la fenêtre ouverte. 	  	 
  	Frameborder 	Permet d'afficher ou non la bordure du frame. 	  	 
  	Scrolling 	Autorise ou interdit l'affichage des ascenseurs sur les côtés du frame. 	  	 
  	Marginwidth 	Permet de définir un espace horizontal entre la bordure du frame et la bordure du document. 	  	 
  	Marginheight 	Permet de définir un espace vertical entre la bordure du frame et le bordure du document. 	  	 
  	Hspace 	Détermine l'espace entre texte et frame sur les côtés verticaux. 	  	  
  	Vspace 	Détermine l'espace entre texte et frame sur les bords horizontaux. 	  	 
        
        
        
        
      }
*/
      //----------------------------------------------------------      
    //  echo '</td>';      
    //  echo '</tr>';    
    //echo "</table>";      


    //**********************************************************************************
	CloseTable();
  OpenTable();	
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("../admin/index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    
  </tr>
  </form>";

    
	CloseTable();

}


/*****************************************************************************
 *
 *****************************************************************************/
//function showVersions($moduleName, $moduleVersion, $moduleDate){
function getInfoVersions($xm, $xmc, $mode = 3){
//global $xoopsModule, $xoopsDB, $xoopsModuleConfig, $xoopsConfig;
//displayArray($xoopsModuleConfig,"--------xoopsModuleConfig------------");
//displayArray($xoopsModuleConfig,"--------xoopsModule------------");
    
    $moduleName = $xm->getVar('name');
    $moduleVersion = $xm->getVar('version')/100;
    $lastUpdate = date("D d/m/Y", $xm->getVar('last_update'));    
    $dateVersion = $xmc['dateVersion'];
     
    $ligneDeSeparation = buildHR(1, _JJD_HR_COLOR1, 3);
    $t = array();
    $t[] = "<table>";    
    //---------------------------------------------------------------    
    $t[] = "<TR><td colspan='3' align='center'><b>".'versions'."</b></td></TR>"; 
    $t[] = $ligneDeSeparation;       
    //---------------------------------------------------------------
    if (($mode & pow(2, 0)) <> 0){
        $t[] = '<tr>';
        $t[] = "<td width='150'>{$moduleName}</td><td> version: </td><td>{$moduleVersion}</td>";
        $t[] = '</tr>';
    
        $t[] = '<tr>';   
        $t[] = "<td></td><td> date version: </td><td>{$dateVersion}</td>";
        $t[] = '</tr>';    
        
        $t[] = '<tr>';   
        $t[] = "<td></td><td> last update: </td><td>{$lastUpdate}</td>";
        $t[] = '</tr>';    
        
        
        $t[] = $ligneDeSeparation;    
    
    }
    
    //---------------------------------------------------------------    
    if (($mode & pow(2, 1)) <> 0){
        $t[] = '<tr>';    
        $t[] = "<td>"._JJD_BIBLIO_LIBELLE."</td><td> version: </td><td>"._JJD_BIBLIO_VERSION."</td>";    
        $t[] = '</tr>';    
        
        $t[] = '<tr>';    
        $t[] = "<td></td><td> date: </td><td>"._JJD_BIBLIO_DATE."</td>";    
        $t[] = '</tr>';    
    
    }
    
    //---------------------------------------------------------------    
    $t[] = "</table>";
    $info = implode("\n", $t);
    return $info;


}

/***************************************************************************
 
 ***************************************************************************/

 function getURLDoc($moduleName, $doc, $folder = ''){
	global $xoopsModuleConfig, $xoopsDB, $xoopsConfig;
	
//define ('_JJD_DOC_PATH' , 'http://xoops.kiolo.com/_docModules/lexique/doc/lexique-french.htm');
//define ('_JJD_DOC_PATH' , 'http://xoops.kiolo.com/_docModules/');
  
  if ($folder <> '' ) $folder .= '/';
  $url =  _JJD_DOC_PATH."{$moduleName}/doc/{$folder}{$doc}-{$xoopsConfig['language']}.htm" ;	
    
  return $url;     
 }

?>
