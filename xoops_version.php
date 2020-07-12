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


//-----------------------------------------------------------------------------------
global $xoopsModule;
//include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/hermes_constantes.php");
include_once (dirname(__FILE__)."/include/jjd_constantes.php");
//-----------------------------------------------------------------------------------

if (!defined('_JJD_DIR_NAME')){ 
    define ('_JJD_DIR_NAME','jjd_tools');
}

//include_once ("_common/include/editor_functions.php");
include_once ("_common/include/version.php");

//----------------------------------------------------------------------------

//include_once (dirname(__FILE__)."/include/constantes.php");
//include_once (_JJD_JJD_PATH."include/editor_functions.php");

//----------------------------------------------------------------------------
include_once ("include/jjd_constantes.php");
include_once (_JJD_JJD_PATH."include/editor_functions.php");

            
//----------------------------------------------------------------------------

$modversion['name']         = "jjd_tools"; 
$modversion['version']      = _JJD_BIBLIO_VERSION; 
$modversion['dateVersion']  = _JJD_BIBLIO_DATE;

$modversion['description']  = _JJD_BIBLIO_LIBELLE; //'Bibliothèque de fonction pour modules perso';
$modversion['credits']      = "Jean-Jacques DELALANDRE";
$modversion['author']       = "jjd@kiolo.com";
$modversion['initiales']    = "J&deg;J&deg;D";
$modversion['license']      = "GPL";
$modversion['official']     = 0;
$modversion['image']        = "images/jjd_tools_logo.png";
$modversion['dirname']      = _JJD_DIR_NAME;

// Admin things
$modversion['hasAdmin']     = 1;
$modversion['adminindex']   = "admin/index.php";
$modversion['adminmenu']    = "admin/menu.php";

//--------------------------------------------------------

//install:
//$modversion['onInstall']     = 'include/install.php';
$modversion['onInstall']     = 'admin/admin_version.php';
//suppression:
//$modversion['onUninstall']   = 'include/uninstall.php';
$modversion['onUninstall']   = 'admin/admin_version.php';
//mise à jour:
//$modversion['onUpdate'] = 'include/update.php';
$modversion['onUpdate'] = 'admin/admin_version.php';
//--------------------------------------------------------

// Blocks
// pas de block


// Menu -----------------------------------------------------------------
$modversion['hasMain'] = 0;

//-----------------------------------------------------------------

//-----------------------------------------------------------------

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$i = 0;
$modversion['tables'][$i++]  = _JJD_TAB_VERSION;
$modversion['tables'][$i++]  = _JJD_TAB_NOTEDEF;
$modversion['tables'][$i++]  = _JJD_TAB_NOTATION;
$modversion['tables'][$i++]  = _JJD_TAB_GLINK;
//----------------------------------------------------------------

// Templates
$i = 0;

$i++;

$modversion['templates'][$i]['file']         = 'adminOnglet.html';
$modversion['templates'][$i]['description']  = 'Page adminOnglet';

//------------------------------------------------------------------
// Search
$modversion['hasSearch']      = 0;
//$modversion['search']['file'] = "include/search.inc.php";
//$modversion['search']['func'] = "her_search";

// Comments
$modversion['hasComments']          = 0;


       
//------------------------------------------------------------------
// Config Settings
//------------------------------------------------------------------
$i=-1;
//------------------------------------------------------------------
// General 
//------------------------------------------------------------------
$i++;
$modversion['config'][$i]['name'] = 'dateVersion';
$modversion['config'][$i]['title'] = '_MI_JJD_DATEVERSION';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype'] = 'hidden';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '31/08/2007';

//------------------------------------------------------------------

$i++;
$modversion['config'][$i]['name'] = 'textintro';
$modversion['config'][$i]['title'] = '_MI_JJD_INTROTEXT';
$modversion['config'][$i]['description'] = '_MI_JJD_INTROTEXTDESC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '_MI_JJD_INTROTEXT_JJD';

$i++;
$modversion['config'][$i]['name'] = 'urlDoc';
$modversion['config'][$i]['title'] = '_MI_JJD_URLDOC';
$modversion['config'][$i]['description'] = '_MI_JJD_URLDOC_DSC';
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'xoops.kiolo.com';

$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = '_MI_LEX_EDITOR';
$modversion['config'][$i]['description'] = '_MI_LEX_EDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['options'] =  getEditorList();



//--------------------------------------------------------------




//------------------------------------------------------------------------
// Notification
$modversion['hasNotification'] = 0;



?>
