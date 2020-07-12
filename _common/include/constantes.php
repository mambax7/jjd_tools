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


//-----------------------------------------------------------------
define ('_br', "\n");
//define ('_br', '<br>');
//-----------------------------------------------------------------
//Definition des constante e dossier
//-----------------------------------------------------------------
global $xoopsModule;

//define ('_JJD_DOC_PATH' , 'http://xoops.kiolo.com/_docModules/lexique/doc/lexique-french.htm');
define ('_JJD_DOC_PATH' , 'http://xoops.kiolo.com/_docModules/');
//-----------------------------------------------------------------

$slashP = ((substr(XOOPS_ROOT_PATH, -1) == '/') ? '' : '/');
$slashU = ((substr(XOOPS_URL,  -1) == '/') ? '' : '/');

define ('_JJD_PROOT',      XOOPS_ROOT_PATH.$slashP);
define ('_JJD_SB',         'modules/jjd_tools/_common/');
define ('_JJD_COMMON',     _JJD_PROOT.'modules/jjd_tools/_common/');

//define ('_JJD_ROOT_PATH' , XOOPS_ROOT_PATH."/modules/jjd_tools/_common/");

define ('_JJD_ROOT_URL' ,  XOOPS_URL.'/'._JJD_SB);

//-----------------------------------------------------------------
define ('_JJD_JS_TOOLS',     _JJD_ROOT_URL.'include/js/jjd_tools.js');
define ('_JJD_JSI_TOOLS',     "<script type=\"text/javascript\" src=\""._JJD_JS_TOOLS."\"></script>\n");


define ('_JJD_JS_SPIN',     _JJD_ROOT_URL.'include/spin/js/spin.js');
define ('_JJD_JSI_SPIN',     "<script type=\"text/javascript\" src=\""._JJD_JS_SPIN."\"></script>\n");

//-----------------------------------------------------------------

//define ('_JJDICO_URL',   XOOPS_URL.'/include/jjd/images/icones/');
define ('_JJDICO_URL',   _JJD_ROOT_URL.'images/icones/');

define ('_JJD_NOTATION_URL', _JJD_ROOT_URL.'images/notations/');
define ('_JJD_NOTATION',     _JJD_COMMON  .'images/notations/');

define ('_JJD_ALPHABET_URL', _JJD_ROOT_URL.'images/alphabets/');
define ('_JJD_ALPHABET',     _JJD_COMMON  .'images/alphabets/');

//-----------------------------------------------------------------
define ('_JJDICO_COMMENT0',     _JJDICO_URL.'comment.gif');
define ('_JJDICO_COMMENT1',     _JJDICO_URL.'comment1.gif');
define ('_JJDICO_COMMENT2',     _JJDICO_URL.'comment2.gif');
define ('_JJDICO_MOVE',         _JJDICO_URL.'move.gif');
define ('_JJDICO_DELETE',       _JJDICO_URL.'delete.gif');
define ('_JJDICO_REMOVE',       _JJDICO_URL.'remove.gif');
define ('_JJDICO_EDIT',         _JJDICO_URL.'edit.gif');
define ('_JJDICO_FRIEND',       _JJDICO_URL.'friend.gif');
define ('_JJDICO_PRINT',        _JJDICO_URL.'print.gif');
define ('_JJDICO_NEW',          _JJDICO_URL.'new.gif');
define ('_JJDICO_SEND',         _JJDICO_URL.'send.gif');
define ('_JJDICO_PROPERTY',     _JJDICO_URL.'propriete.gif');
define ('_JJDICO_EMPTY',        _JJDICO_URL.'empty.gif');
define ('_JJDICO_SEARCH',       _JJDICO_URL.'search.gif');
define ('_JJDICO_ASKDEF',       _JJDICO_URL.'askdef.gif');
define ('_JJDICO_CLEF',         _JJDICO_URL.'clef.gif');
define ('_JJDICO_VERROU',       _JJDICO_URL.'verrou.gif');
define ('_JJDICO_TOOLS',        _JJDICO_URL.'tools.gif');
define ('_JJDICO_VIEW',         _JJDICO_URL.'view.gif');
define ('_JJDICO_DUPLICATE',    _JJDICO_URL.'duplicate.gif');
define ('_JJDICO_FORBID',       _JJDICO_URL.'forbid.gif');
define ('_JJDICO_PREPAR',       _JJDICO_URL.'prepar.gif');

define ('_JJDICO_NOTE',         _JJDICO_URL.'note.gif');
define ('_JJDICO_SEND2WORLD',   _JJDICO_URL.'send2world.gif');
define ('_JJDICO_USER',         _JJDICO_URL.'user.gif');
define ('_JJDICO_WORLD',        _JJDICO_URL.'world.gif');



define ('_JJDICO_LIGHT_RED',      _JJDICO_URL.'light_red.gif');
define ('_JJDICO_LIGHT_YELLOW',   _JJDICO_URL.'light_yellow.gif');
define ('_JJDICO_LIGHT_WHITE',    _JJDICO_URL.'light_white.gif');
define ('_JJDICO_LIGHT_BLUE',     _JJDICO_URL.'light_blue.gif');
define ('_JJDICO_LIGHT_GREEN',    _JJDICO_URL.'light_green.gif');
define ('_JJDICO_LIGHT_ORANGE',   _JJDICO_URL.'light_orange.gif');
define ('_JJDICO_LIGHT_OFF',      _JJDICO_URL.'light_off.gif');

define ('_JJDICO_SYNDICATION',    _JJDICO_URL.'syndication.gif');


define('_JJD_HR_COLOR1',    '839D2D');

//-----------------------------------

define('_JJD_TR_BASE',         3);
define('_JJD_TR_bgColor_0',    'dbe0c6');
define('_JJD_TR_bgColor_1',    'c6e1de');
define('_JJD_TR_bgColor_2',    'f2dabe');

define('_JJD_color_disabled',  '#D2D2D2');

?>
