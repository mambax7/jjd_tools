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

//-----------------------------------------------------------------
//-----------------------------------------------------------------
//Definition des constante e dossier
//-----------------------------------------------------------------
global $xoopsModule, $xoopsDB;
if (!defined('_JJD_DIR_NAME')){ 
    define ('_JJD_DIR_NAME','jjd_tools');
}

$slash = ((substr(XOOPS_ROOT_PATH,-1) == '/' ) ? '' : '/');

define ('_JJD_SUB_FOLDER',    '/modules/'._JJD_DIR_NAME.'/'  );
define ('_JJD_ROOT_PATH',     XOOPS_ROOT_PATH.$slash.'modules/'._JJD_DIR_NAME.'/'  );
define ('_JJD_JJD_PATH',      XOOPS_ROOT_PATH.$slash.'modules/'._JJD_DIR_NAME.'/_common/'  );


define ('_JJD_GOTO_ADMIN', "javascript:window.navigate(\"".XOOPS_URL.""._JJD_SUB_FOLDER."admin/index.php\");");


//-----------------------------------------------------------------
                             
/************************************************************************
 * tables
 ************************************************************************/
//-----------------------------------------------------------------
//Definition des constante de table
//-----------------------------------------------------------------
define ('_JJD_TBL_PREFIXE',     'jjd_');
//-------------------------------------------------------
define ('_JJD_TBL_VERSION',    'versions');
define ('_JJD_TBL_NOTEDEF',    'notedef');
define ('_JJD_TBL_NOTATION',   'notation');
define ('_JJD_TBL_GLINK',      'glink');

//-------------------------------------------------------
define ('_JJD_TAB_VERSION',    _JJD_TBL_PREFIXE._JJD_TBL_VERSION);
define ('_JJD_TAB_NOTEDEF',    _JJD_TBL_PREFIXE._JJD_TBL_NOTEDEF);
define ('_JJD_TAB_NOTATION',   _JJD_TBL_PREFIXE._JJD_TBL_NOTATION);
define ('_JJD_TAB_GLINK',      _JJD_TBL_PREFIXE._JJD_TBL_GLINK);
//-----------------------------------------------------------------
define ('_JJD_TFN_VERSION',    $xoopsDB->prefix(_JJD_TAB_VERSION));
define ('_JJD_TFN_NOTEDEF',    $xoopsDB->prefix(_JJD_TAB_NOTEDEF));
define ('_JJD_TFN_NOTATION',   $xoopsDB->prefix(_JJD_TAB_NOTATION));
define ('_JJD_TFN_GLINK',      $xoopsDB->prefix(_JJD_TAB_GLINK));
//-----------------------------------------------------------------





/*************************************************************************
* definition des onglets
*************************************************************************/
define('_JJD_ONGLET_GESTION',  1);
define('_JJD_ONGLET_NOTE_DEF', 2);

define('_JJD_ONGLET_DOC',     3);
define('_JJD_ONGLET_LICENCE', _JJD_ONGLET_DOC + 1);
//define('_HER_ONGLET_'  , 4);

/*************************************************************************
* autres constantes
*************************************************************************/


?>
