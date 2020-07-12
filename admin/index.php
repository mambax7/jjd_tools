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


include_once ('admin_header.php');
include_once ('../include/jjd_constantes.php');

include_once (_JJD_JJD_PATH.'include/constantes.php');
include_once (_JJD_JJD_PATH.'include/adminOnglet/adminOnglet.php');
include_once (_JJD_JJD_PATH."include/functions.php");
include_once (_JJD_JJD_PATH.'include/version.php');


define("_JJD_ADMIN_SEPZONE", " ");
//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'onglet',    'default' => 0),
              array('name' =>'ok',        'default' => 0),              
              array('name' =>'doc',       'default' => ''),              
              array('name' =>'pinochio',  'default' => false));
              
//require (XOOPS_ROOT_PATH."/include/jjd/gp_globe.php");

require (_JJD_JJD_PATH."include/gp_globe.php");

//-------------------------------------------------------------

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin(){
global $xoopsModuleConfig;  

    
  showAdmin_Begin ();      echo _JJD_ADMIN_SEPZONE;
  //showAdmin_Options ();    echo _JJD_ADMIN_SEPZONE;
  showAdmin_Versions ();   echo _JJD_ADMIN_SEPZONE;
  
  //showAdmin_Lettres ();    echo _HER_ADMIN_SEPZONE;  
  //showAdmin_Texte ();      echo _HER_ADMIN_SEPZONE;  
  //showAdmin_Quick ();      echo _HER_ADMIN_SEPZONE;
  //showAdmin_Tools ();      echo _HER_ADMIN_SEPZONE;
  
  //----------------------------------------------------------  
  //outils et traitements perso, ne pas activer en prod  

    //  showAdmin_JJD ();echo _HER_ADMIN_SEPZONE;
  //----------------------------------------------------------
  

  showAdmin_End ();  
}

/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Begin(){
global $xoopsModule, $xoopsDB;
//xoops_cp_header();
    //OpenTable();

}
/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_End(){
global $xoopsModule, $xoopsDB;

  //CloseTable();
 // xoops_cp_footer();

}


/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Options(){
global $xoopsModule, $xoopsDB;
 
    
    
    OpenTable();
    //**********************************************************************************    
    
    echo "<p><A HREF=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&op=showmod&mod=".$xoopsModule->getVar('mid')."\">- "._AD_HER_CONFIGURATION_MODULE."</a><br></p><br>";

//displayArray($_SERVER,"---------- SERVER ----------");
//echo $_SERVER['SCRIPT_NAME']."<br>";
/*

    $link = BuildLink ('her_lettre', 'idLettre', 'nom',
                       "admin_lettre.php?op=edit&idLettre=%0%", 'nom');   
    echo "<p>-&nbsp;<A HREF='admin_lettre.php?op=list'>"._AD_HER_LETTRE_MANAGEMENT."</A> : {$link}<br>";
    
    //-----------------------------------------------------------------------                   
    $link = BuildLink ('her_texte', 'idTexte', 'nom',
                       "admin_texte.php?op=edit&idTexte=%0%", 'nom');   
    echo "<p>-&nbsp;<A HREF='admin_texte.php?op=list'>"._AD_HER_TEXTE_MANAGEMENT."</A> : {$link}<br>";

    //-----------------------------------------------------------------------                   
    $link = BuildLink ('her_plugin', 'idPlugin', 'nom',
                       "admin_plugin.php?op=edit&idPlugin=%0%", 'nom');   
    echo "<p>-&nbsp;<A HREF='admin_plugin.php?op=list'>"._AD_HER_PLUGIN_MANAGEMENT."</A> : {$link}<br>";

    //-----------------------------------------------------------------------                   
*/

    echo "<p><A HREF='index.php?op=purgerArchives'>- "._AD_HER_DELETE_ARCHIVES."</A></p><br>";    
    echo "<p><A HREF='index.php?op=purgerAllArchives'>- "._AD_HER_DELETE_ALLARCHIVES."</A></p><br>";
    echo "<p><A HREF='her_action.php?op=updatePluginsList'>- "._AD_HER_UPDATEPLUGINSLIST."</A></p><br>";    
    
    //**********************************************************************************
    CloseTable();

}


/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_Tools(){
global $xoopsModule, $xoopsDB;

    OpenTable();
    //**********************************************************************************
    

    
    echo "<p>-&nbsp;<A HREF='her_action.php?op=createNewGroupHermesA'>"._AD_HER_CREATE_GRP_HERMESA."</A></p>";        
    //**********************************************************************************    
    CloseTable();

}


/*****************************************************************************
 *
 *****************************************************************************/
function showAdmin_JJD(){
global $xoopsModule, $xoopsDB;

    OpenTable();
    
    



    echo "<p>-&nbsp;Fonctions particulieres utilisees pour pendant le dev</p>";  
    echo "<p>-&nbsp;mettre la variable jjdebug a false en prod</p>";
    echo "<p>-&nbsp;Ces options ne sont absolument pas garanties dans leur comportement</p>";
    echo '<HR>';   
    //------------------------------------------------------------------------
    echo "<p>-&nbsp;<A HREF='her_action.php?op=setFolderForUpload'>"._AD_HER_setFolderForUpload."</A></p>";


    CloseTable();

}

/*****************************************************************************
 *
 *****************************************************************************/
//function showVersions($moduleName, $moduleVersion, $moduleDate){
function showAdmin_Versions(){
global $xoopsModule, $xoopsDB, $xoopsModuleConfig, $xoopsConfig;
//displayArray($xoopsModuleConfig,"--------xoopsModuleConfig------------");
//displayArray($xoopsModuleConfig,"--------xoopsModule------------");
    
    OpenTable();
    echo getInfoVersions($xoopsModule,$xoopsModuleConfig, 1);
    CloseTable();

}

/*****************************************************************************
 *
 *****************************************************************************/
//function showVersions($moduleName, $moduleVersion, $moduleDate){
function showAdmin_Versions2(){
global $xoopsModule, $xoopsDB, $xoopsModuleConfig, $xoopsConfig;
//displayArray($xoopsModuleConfig,"--------xoopsModuleConfig------------");
//displayArray($xoopsModuleConfig,"--------xoopsModule------------");
    
    $moduleName = $xoopsModule->getVar('name');
    $moduleVersion = $xoopsModule->getVar('version')/100;
    $lastUpdate = date("D d/m/Y", $xoopsModule->getVar('last_update'));    
    $dateVersion = $xoopsModuleConfig['dateVersion'];
     
    $ligneDeSeparation = "<TR><td colspan='3'><hr></td></TR>"._herbr;
    $t = array();
    //---------------------------------------------------------------    
    $t[] = "<TR><td colspan='3' align='center'><b>".'versions'."</b></td></TR>\n"; 
    $t[] = $ligneDeSeparation;       
    //---------------------------------------------------------------
/*
*/
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

    //---------------------------------------------------------------    
    $t[] = '<tr>';    
    $t[] = "<td>"._JJD_BIBLIO_LIBELLE."</td><td> version: </td><td>"._JJD_BIBLIO_VERSION."</td>";    
    $t[] = '</tr>';    
    
    $t[] = '<tr>';    
    $t[] = "<td></td><td> date: </td><td>"._JJD_BIBLIO_DATE."</td>";    
    $t[] = '</tr>';    
    
    //---------------------------------------------------------------    
    $info = implode("\n", $t);
    OpenTable();
    echo $info;
    CloseTable();

}

/****************************************************************************
 *
 ****************************************************************************/
function readDoc($doc, $redirect = 'index.php'){

	Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	
    $f = _HER_ROOT_PATH."language/{$xoopsConfig['language']}/doc/{$doc}";	
    
    if (!file_exists($f)){
      redirect_header($redirect,1,_AD_HER_ADDOK);
      return;
    }    

    //------------------------------------------------  
    //$ligneDeSeparation = "<TR><td colspan='2'><hr></td></TR>"._br;  
    $ligneDeSeparation = "<hr>"._br;

	  //xoops_cp_header();
    OpenTable();    
    //------------------------------------------------   
	  echo "<B>"._AD_HER_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	echo "<B>"._AD_HER_DOCUMENTATIONS." : </B>".BuildLinkOnFolderDoc();
    
    echo $ligneDeSeparation;     
    getButtonReadFile();    
    //------------------------------------------------    

    
 		echo "<FORM ACTION='{$redirect}' METHOD=POST>"._br;
    readfile ($f);
  
    //------------------------------------------------
  
     
  echo $ligneDeSeparation;	
  
  echo "<B>"._AD_HER_DOCUMENTATIONS." : </B>".BuildLinkOnFolderDoc();
  getButtonReadFile();

  CloseTable();
  
echo  "</form>";    
	CloseTable();
//	xoops_cp_footer();



}
/****************************************************************************
 *
 ****************************************************************************/
function getButtonReadFile(){
  $linkCancel = buildUrlJava ("index.php",  false);  
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3
  <tr valign='top'>
    <td align='left' >

    </td>
    <td align='left' width='10'></td>


    <td align='right'>
    <input type='button' name='cancel' value='"._CLOSE."' onclick='".$linkCancel."'>    
    </td>    
  </tr>
  </table>";


}

/*****************************************************************************
 *  controleur
*****************************************************************************/

//$onglet = $op;

   admin_xoops_cp_header(_JJD_ONGLET_GESTION, $xoopsModule);
   //echo "<hr>onglet -> {$onglet}<hr>";


  switch ($op){
    //--------------------------------------------------------------------  
    //--------------------------------------------------------------------
   //--------------------------------------------------------------------
  default:
      showAdmin();      
      break;
      
  }
admin_xoops_cp_footer();






?>
