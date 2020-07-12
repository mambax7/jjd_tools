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

// General settings
include_once ("header.php");




//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')."/include/jjd_constantes.php");
//-----------------------------------------------------------------------------------
include_once (_JJD_ROOT_PATH."include/jjd_constantes.php");

include_once (_JJD_ROOT_PATH."include/functions.php");
include_once (_JJD_ROOT_PATH."include/constantes.php");

//-------------------------------------------------------------
$vars = array(array('name' =>'op',        'default' => ''),
              array('name' =>'idLettre',  'default' => 0),
              array('name' =>'idArchive', 'default' => 0),              
              array('name' =>'pinochio',  'default' => false));
              
//require (XOOPS_ROOT_PATH."/include/jjd/gp_globe.php");
require (_JJD_JJD_PATH."/include/gp_globe.php");
//-------------------------------------------------------------



/**********************************************************************
 *
 **********************************************************************/ 
function editProfile($p) {
global $xoopsTpl,$xoopsModuleConfig;


$myts =& MyTextSanitizer::getInstance();

	//-----------------------------------------------------------------
	$xoopsTpl->assign('textintro', $xoopsModuleConfig['textintro']); 
	$xoopsTpl->assign('opRegistry', 'saveNewList');
	$xoopsTpl->assign('idUser', $p['idUser']);	
	$xoopsTpl->assign('showFormat', 1);	
	//-----------------------------------------------------------------	
  

  $lettres = array();
  //for ($h = 0; $h<5; $h++){
  //$lettres[] = array('name' => 'togodo', 'libelle' => 'aaaaaaaaaaaaa');
  //}
  //$lettres = db_getLettres();
  //$lettres = fetch2array ( db_getLettres());
  $lettres = getLettersForUser();  
  
//  displayArray($lettres,"-------------------------------");
  //$list = array('non','texte','HTML');
  $list = array(array('id' => 0 , 'lib'=>'non',   'bgColor'=>'CC99FF'),
                array('id' => 1 , 'lib'=>'texte', 'bgColor'=>'FFFF66'),
                array('id' => 2 , 'lib'=>'HTML',  'bgColor'=>'CCFF66'));

 // array('','','99FFFA','')

    
  for ($h = 0; $h < count($lettres); $h++){
      $item = $lettres[$h];
      $listState = getlistSearch ("lstState_{$item['idLettre']}", $list, 0, $item['state']);
    
      //$listState = buildHtmlList ("lstState_{$item['idLettre']}", $list, $item['state'],  0, 1, '', '');  
      $lettres[$h]['obList'] = $listState;
  }
  
  
  $xoopsTpl->assign('post',  $lettres);
	


}

/**********************************************************************
 *
 **********************************************************************/ 
function frmRegistry($p, $message = '') {
global $xoopsTpl;


$myts =& MyTextSanitizer::getInstance();
	//-----------------------------------------------------------------
	$xoopsTpl->assign('titre', '*************jjd*************'); 
	$xoopsTpl->assign('showRegistry', '1');	
	$xoopsTpl->assign('opRegistry', 'submitNewSubscrib');	
	$xoopsTpl->assign('message', $message);
  	
  echo '<hr>reigstry-fin';	
	//-----------------------------------------------------------------	
  

  $lettres = array();
  for ($h = 0; $h<5; $h++){
  $lettres[] = array('name' => 'togodo', 'libelle' => 'aaaaaaaaaaaaa');
  }
  //$lettres = db_getLettres();
  //$lettres = fetch2array ( db_getLettres());
  $lettres = getLettersForUser();  
  
  //displayArray($lettres,"-------------------------------");
  $xoopsTpl->assign('post',  $lettres);
	


}

/**********************************************************************
 *
 **********************************************************************/ 
function saveNewRegistry($p) {
  
  $t = array();
  
  
  if ($p['pseudo'] =='' ){
    $t[] = _MD_HER_MSG_PSEUDO_EMPTY;  
  }
  
  if (strlen($p['pseudo']) < 6 ){
    $t[] = _MD_HER_MSG_PSEUDO_TOLITTLE;  
  }

  if (strlen($p['password1']) < 6 ){
    $t[] = _MD_HER_MSG_PWD_TOLITTLE;  
  }

  if ($p['password1'] <> $p['password2']){
    $t[] = _MD_HER_MSG_CONFIRM_PSW_FAILED;  
  }
  
  //---------------------------------------------
  $message = implode("<br>", $t);
  if ($message <> ''){
    return $message;
    exit;  
  }
  //---------------------------------------------  
  
  
  createNewUser ($p['pseudo'], $p['pseudo'], $p['email'], $p['password1']);
  return 'zzzzz';

}

/**********************************************************************
 *
 **********************************************************************/ 

function saveNewList($p) {
  $idUser = $p['idUser'];
  //redirect_header(XOOPS_URL."/register.php",1,"");	
  $list = htmlArrayOnPrefix($p, array('idLettre','lstState'), '_');
  
  //displayArray($p,"--- lettres post ---");  
  //displayArray($list,"--- lettres cochées ---");



  saveNewListLetterForUser($list);
  
//exit;  
}


/**********************************************************************
 * fonction pour archives
 **********************************************************************/ 

function listArchive($idLettre, $mode) {
global $xoopsTpl,$xoopsUser,$xoopsDB,$xoopsModuleConfig;



$myts =& MyTextSanitizer::getInstance();
	//-----------------------------------------------------------------
	$xoopsTpl->assign('textintro', $xoopsModuleConfig['textintro']); 
	$xoopsTpl->assign('idUser', $xoopsUser->uid());	
	$xoopsTpl->assign('showFormat', 0);	
	//-----------------------------------------------------------------	
  //$idLettre =1;
  $lettres = getDistinctArchivesForUser();
  //if ($idLettre == 0){$idLettre = $lettres[0]['id'];}
  //displayArray($lettres,"----- Lettres -----");
  $link = _HER_URL."index.php?op=listArchive&idLettre=";
  $oc = "gotoPageOnId(\"$link\",\"listLettre\");";
  //$listLettres = buildHtmlList ('listLettre', $lettres, 0, 0, 0, $oc);
  $listLettres = getlistSearch ('listLettre', $lettres, 0, $idLettre, 0,
                                'id', 'lib', '', $oc,$idLettre);
  //-----------------------------------------------------
  //echo "listArchive -> idLettre= {$idLettre}";
  $archives    = getArchivesForUser($idLettre, $mode);  
  $lettre = $xoopsDB->fetchArray(db_GetLettres($idLettre));
  //displayArray($lettres,"-----------getArchivesForUser--------------------");
 

  $xoopsTpl->assign('pathToolsJS',  _JJD_JS_TOOLS);	
  
  $xoopsTpl->assign('listLettres',  $listLettres);  
  $xoopsTpl->assign('lettre',  $lettre);  
  
  $xoopsTpl->assign('post',  $archives);
	


}
/****************************************************************************
 *
 ****************************************************************************/
function viewArchive ($idArchive){
global $xoopsDB, $xoopsTpl, $xoopsUser;
  

    prepareArchive ($idArchive);
    //**********************************************************************************
    $link = "<a href='javascript:window.close();'>Close</a>";
    
		echo "<FORM ACTION='admin_lettre.php?op=list' METHOD=POST>";
    echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
        <tr valign='top'>
        <td align='center' ><input type='button' name='cancel' value='"._CLOSE."' onclick='javascript:window.close();'></td>
        <td align='left' width='200'></td>
        </tr>";

  
  
  
  
}

/****************************************************************************
 *
 ****************************************************************************/
function prepareArchive ($idArchive){
global $xoopsDB, $xoopsTpl, $xoopsUser;
  
  $rstArchive = $xoopsDB->fetchArray(db_getArchives($idArchive ));
  
  $sb = ($rstArchive['cheminArchivage'] =='')?(_HER_SUB_FOLDER."archives"):($rstArchive['cheminArchivage']);
  $f = XOOPS_ROOT_PATH."/".$sb."/".$rstArchive['nomFichier'];
  $f = str_replace('//', '/', $f);
  //echo "<hr>{$f}<hr>";
  $texte = loadTextFile($f);


  $params =array(_HER_CODE_USER.'idUser'   => $xoopsUser->uid(), //faut pas que l'on puisse désactiver une lettre a partir d'ne archive peut mettre 0, a voir
                 _HER_CODE_USER.'login'    => $xoopsUser->name(),
                 _HER_CODE_USER.'email'    => $xoopsUser->email(),
                 _HER_CODE_USER.'mail'     => $xoopsUser->email(),                 
                 _HER_CODE_USER.'pseudo'   => $xoopsUser->uname(),                 
                 _HER_CODE_USER.'name'     => $xoopsUser->name (),
                 'idLettre' => $rstArchive['idLettre'] );

                                    
  $textePerso = replaceCodePersonalise ($texte, $params);


    return $textePerso;

}

/**********************************************************************
 * fonction pour archives
 **********************************************************************/ 

function viewArchiveIn($idLettre, $idArchive, $mode) {
global $xoopsTpl,$xoopsUser,$xoopsDB,$xoopsModuleConfig;



$myts =& MyTextSanitizer::getInstance();
	//-----------------------------------------------------------------
	$xoopsTpl->assign('textintro', $xoopsModuleConfig['textintro']); 
	$xoopsTpl->assign('idUser', $xoopsUser->uid());	
	$xoopsTpl->assign('showFormat', 0);	
	//-----------------------------------------------------------------	
  //$idLettre =1;
  $lettres = getDistinctArchivesForUser();
  //if ($idLettre == 0){$idLettre = $lettres[0]['id'];}
  //displayArray($lettres,"----- Lettres -----");
  $link = _HER_URL."index.php?op=listArchiveIn&idLettre=";
  $oc = "gotoPageOnId(\"$link\",\"listLettre\");";
  //$listLettres = buildHtmlList ('listLettre', $lettres, 0, 0, 0, $oc);
  $listLettres = getlistSearch ('listLettre', $lettres, 0, $idLettre, 0,
                                'id', 'lib', '', $oc,$idLettre);
  //-----------------------------------------------------
  //echo "listArchive -> idLettre= {$idLettre}";
  $link = _HER_URL."index.php?op=listArchiveIn&idLettre={$idLettre}&idArchive=";
  $oc = "gotoPageOnId(\"$link\",\"listArchive\");";
  $archives    = getArchivesForUser($idLettre, $mode);  
  $listArchives = getlistSearch ('listArchive', $archives, 0, $idArchive, 0,
                                'idArchive', 'lib', '', $oc, $idArchive);
  
  
  $lettre = $xoopsDB->fetchArray(db_GetLettres($idLettre));
  //displayArray($lettres,"-----------getArchivesForUser--------------------");
 

  $xoopsTpl->assign('pathToolsJS',  _JJD_JS_TOOLS);	
  
  $xoopsTpl->assign('listLettres',  $listLettres);  
  $xoopsTpl->assign('listArchives',  $listArchives);  
  
  if ($idArchive <> 0){
	 $xoopsTpl->assign('archiveTexte', prepareArchive ($idArchive));    
  }




//  $xoopsTpl->assign('lettre',  $lettre);  
//  $xoopsTpl->assign('post',  $archives);
	


}


/**********************************************************************
 *
 **********************************************************************/ 
global $xoopsUser;
/*
*/  
if (($op == '' OR $op == 'listArchive') AND $xoopsModuleConfig['viewArchive'] == 1){
  $op = 'listArchiveIn';
}

//echo "<hr>{$op}<hr>";
if (is_object($xoopsUser)) {
  if ($op == '') {$op = 'listArchive';}
}else{
  $op = 'newRegistry';
}

if ($op=='viewArchive' OR $op=='revoke'  OR $op==''){$bolOk = false;}else{$bolOk=true;}
if($bolOk){include_once (XOOPS_ROOT_PATH."/header.php");}
//-------------------------------------------------------------  
//$op = 'edit';

//echo "<hr> -> {$op}<hr>";
switch ($op){

case 'profile':
  $xoopsOption['template_main'] = 'hermes_lettre.html';
  //$p = getLettreForUser ($gepeto);
  editProfile($gepeto);
  break;
  
 
case 'saveNewList':
  $xoopsOption['template_main'] = 'hermes_lettre.html';
  //$p = getLettreForUser ($gepeto);
  saveNewList($gepeto) ;
  editProfile($gepeto);  
  break;  


case 'newRegistry':
  //frmRegistry($gepeto,"rrrrr");
  redirect_header(XOOPS_URL."/register.php",1,"Login");	
  //include_once(XOOOPS_URL.'/register.php?op=register');
  //http://localhost/xoos-02/register.php

  break;


case 'viewArchive':
  viewArchive($idArchive) ;
  break;  
  

case 'viewArchiveInCurrentPage':

  viewArchiveIn($idArchive) ;
  break;  




case 'revoke':
  $source = $_SERVER['HTTP_REFERER'];  
    $ok = updateSuscribe($gepeto['newState'], $gepeto['idLettre'], $gepeto['idUser'], $gepeto['login'], $gepeto['mail'], $msg);
    redirect_header($source,3,"<font color='red'><b>{$msg}</b></font>");    
    break;

case "noteNewLettre":
case "noteNewLetter":
  $source = $_SERVER['HTTP_REFERER'];  
    noteNewLetter($gepeto['idArchive'], $gepeto['note']);
    // a modifier par un formulaire du style votre a ete enregistre
    //redirect_header("index.php",3,_MD_HER_MSG_VOTE_THANKYOU); 
    redirect_header($source,3,_MD_HER_MSG_VOTE_THANKYOU);       
		break;



case 'listArchiveIn':
    $xoopsOption['template_main'] = 'hermes_archiveIn.html';
    viewArchiveIn($idLettre, $idArchive, $xoopsModuleConfig['viewArchive']) ;
		break;
    
case 'listArchive':
default:
  $xoopsOption['template_main'] = 'hermes_archive.html';
  listArchive($idLettre, $xoopsModuleConfig['viewArchive']);

  
}


//-------------------------------------------------------------  
if($bolOk){include_once (XOOPS_ROOT_PATH."/footer.php");}
//-------------------------------------------------------------





?>

