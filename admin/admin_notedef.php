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


include_once ("admin_header.php");
include_once (_JJD_JJD_PATH.'include/adminOnglet/adminOnglet.php');
//include_once ('admin_interface.php');

//-----------------------------------------------------------------------------------
global $xoopsModule;
include_once (XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar('dirname')
                               ."/include/jjd_constantes.php");
//-----------------------------------------------------------------------------------


//-------------------------------------------------------------
$vars = array(array('name' =>'op',         'default' => 'list'),
              array('name' =>'idNotedef',  'default' => 0),
              array('name' =>'pinochio',   'default' => false));
              
require (_JJD_JJD_PATH."include/gp_globe.php");
//-------------------------------------------------------------

function list_notedef () {
global $xoopsModule, $xoopsDB, $adoNotedef;
 
    
  echo _JJD_JSI_TOOLS;
  echo _JJD_JSI_SPIN;  
  
	  //xoops_cp_header();
    
    OpenTable();
    //**********************************************************************************    
    //echo "<b>"._AD_HER_TEXTES."</b><br>";    


    $sqlquery = $adoNotedef->getRows('idNotedef,name,description');    
    
    echo "<table ".getTblStyle().">";  
    
          
    while ($sqlfetch = $xoopsDB->fetchArray($sqlquery)) {

      
      $idNotedef = $sqlfetch['idNotedef'];    
      //displayArray($sqlfetch, "----------------list_notedef = $idNotedef{}--------"); 
      
      
           
      $bg = getRowStyle($row,'',0,3); 
      
      echo '<tr>';
      echo "<td {$bg} align='right'>({$idNotedef})</td>";
      //echo "<td>{$sqlfetch['description']}</td>";            
      
      echo "<td {$bg}>{$sqlfetch['name']}</td>";
      //echo "<td>{$sqlfetch['description']}</td>";            

        
      echo "<td{$bg}>{$sqlfetch['description']}</td>";        
        //-----------------------------------------------------------------------   	   
        $link = "admin_notedef.php?op=edit&idNotedef=".$idNotedef;
        echo build_icoOption($link, _JJDICO_EDIT, _AD_JJD_EDIT, '', '', $bg);
        //-----------------------------------------------------------------------
        //Dupliquer la lettre
    	  $link = "admin_notedef.php?op=duplicate&idNotedef=".$idNotedef;
        echo build_icoOption($link, _JJDICO_DUPLICATE, _AD_JJD_DUPLICATE, '', '', $bg);        
        //-----------------------------------------------------------------------
        //suppression du texte        
    	  $link = "admin_notedef.php?op=remove&idNotedef={$idNotedef}&name={$sqlquery['nom']}";        
        echo build_icoOption($link, _JJDICO_REMOVE, _AD_JJD_DELETE, '', '', $bg);
        //-----------------------------------------------------------------------
        //previsualisation du texte
    	  $link = "admin_notedef.php?op=preview&idNotedef={$idNotedef}&name={$sqlquery['name']}";        
        echo build_icoOption($link, _JJDICO_VIEW, _AD_JJD_PREVIEW, '', '', $bg); 
       //-----------------------------------------------------------------------  
      
      
      
      
      
      echo '</tr>';       
    }
    
    echo "</table>";      


    //**********************************************************************************
echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
  <tr valign='top'>
    <td align='left' ><input type='button' name='cancel' value='"._CLOSE."' onclick='".buildUrlJava("index.php",false)."'></td>
    <td align='left' width='200'></td>

    <td align='right'>
    <input type='button' name='new' value='"._AD_JJD_NEW."' onclick='".buildUrlJava("admin_notedef.php?op=new",false)."'>    
  </tr>
  </form>";

    
	CloseTable();
	//xoops_cp_footer();

}



//-----------------------------------------------------------------
/*****************************************************************
 *
 *****************************************************************/
function edit_notedef($p){
	
    Global $xoopsModuleConfig, $xoopsDB, $xoopsConfig, $xoopsModule;
	   $myts =& MyTextSanitizer::getInstance();

    //------------------------------------------------  
    $ligneDeSeparation = buildHR(1, _JJD_HR_COLOR1, 2);
    //$listYesNo = aList_noYes();    
    //------------------------------------------------    
          
  //echo versionJS();
  echo _JJD_JSI_TOOLS;
  echo _JJD_JSI_SPIN;  
  
    OpenTable();  

        
    //********************************************************************
	  //echo "<div align='center'><B>"._AD_HER_ADMIN." ".$xoopsConfig['sitename']."</B><br>";
  	//echo "<B>"._AD_HER_TEXTE_MANAGEMENT."</B></div>";
    
 		echo "<FORM ACTION='admin_notedef.php?op=save' METHOD=POST>";
    
    //********************************************************************
    //CloseTable();
    //OpenTable();   
    echo "<table width='80%'>";     
    //********************************************************************  
    //echo buildTitleOption (_AD_HER_OPTIONS_GENERALES,_AD_HER_OPTIONS_GENERALES_DESC);    
    //********************************************************************

    //---id
    echo "<TR>";
    echo "<TD align='left' >".""."</TD>";
    echo "<TD align='right' >".$p['idNotedef']." <INPUT TYPE=\"hidden\" id='idNotedef'  NAME='idNotedef'  size='1%'"." VALUE='".$p['idNotedef']."'></TD>";
    echo "</TR>";    



    //---Name
    echo buildInput(_AD_JJD_NAME, '', 'txtname', $myts->makeTboxData4Show($p['name'], "1", "1", "1"), '30%');    

    
    //---description
    echo buildInput(_AD_JJD_DESCRIPTION, '', 'txtdescription', $myts->makeTboxData4Show($p['description'], "1", "1", "1"), '60%');    
/*

   
    //---texte    
   	$desc1 = getXME($myts->makeTareaData4Show($p['description']), 'txtdescription', '','100%');
    echo "<TR>"._br;
    echo "<TD align='center' ><B>"._AD_HER_TEXTE."</B</TD>"._br;    
    echo "<TD align='left'  >";
    echo $desc1->render();
    echo "</TD>"._br;
    echo "</TR>"._br;
*/    
  
    ///////////////////////////////////////////////////////////////
    //---min / max
    echo buildSpin(_AD_JJD_NOTE_MIN, '', 'txtnoteMin', $p['noteMin'], 9, 0, 1, 10);
    echo buildSpin(_AD_JJD_NOTE_MAX, '', 'txtnoteMax', $p['noteMax'], 9, 0, 1, 10);


    //---Name
    echo buildInput(_AD_JJD_FONT_IMG, '', 'txtfontImg', $myts->makeTboxData4Show($p['fontImg'], "1", "1", "1"), '60%');    

    //---Name
    echo buildInput(_AD_JJD_CURSEUR_IMG, '', 'txtcurseurImg', $myts->makeTboxData4Show($p['curseurImg'], "1", "1", "1"), '60%');    


    //---indes des bandes grise et colorées
    echo buildSpin(_AD_JJD_IDX_IMG0, _AD_JJD_IDX_IMG0_DESC, 'txtcurseurIndexImg0', $p['curseurIndexImg0'], 10, 0, 1, 10);
    echo buildSpin(_AD_JJD_IDX_IMG1, _AD_JJD_IDX_IMG1_DESC, 'txtcurseurIndexImg1', $p['curseurIndexImg1'], 10, 0, 1, 10);
    
    
    /////////////////////////////////////////////////////////////// 
    //********************************************************************  
    echo "</table>";      
    CloseTable();
    OpenTable();    
    echo "<table width='80%'>";    
    //********************************************************************



    echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
      <tr valign='top'>
        <td align='left' ><input type='button' name='cancel' value='"._CANCEL."' onclick='".buildUrlJava("admin_notedef.php",false)."'></td>
        <td align='left' width='200'></td>
    
        <td align='right'>
        <input type='submit' name='submit' value='"._AD_JJD_VALIDER."' )'>    
        </td>    
      </tr>
      </table>
      </form>";
    
        
    	CloseTable();
//    	xoops_cp_footer();

      //------------------------------------------------------------------
      //$xoopsTpl->append('dic_post', $post);
    


}


/****************************************************************************
 *
 ****************************************************************************/
function preview_notedef ($idNotedef){
global $xoopsUser;


    $texte = "<hr><b>EN COURS DE DEVELOPPEMENT !<b><hr>";
    //**********************************************************************
    echo $texte;
    //**********************************************************************
    $link = "<a href='javascript:window.close();'>Close</a>";
    
		echo "<FORM ACTION='admin_notedef.php?op=list' METHOD=POST>";
    echo "<TABLE BORDER=0 CELLPADDING=2 CELLSPACING=3>
        <tr valign='top'>
        <td align='center' ><input type='submit' name='cancel' value='"._CLOSE."' ></td>
        <td align='left' width='200'></td>
        </tr>";
        //<td align='center' ><input type='button' name='cancel' value='"._CLOSE."' onclick='javascript:window.close();'></td>

   echo "</form>";
/*    
    //**********************************************************************    
	CloseTable();
	xoops_cp_footer();
*/ 
  
  
  
  
}



 

/************************************************************************
 *
 ************************************************************************/
//include_once (_HER_JJD_PATH.'include/adminOnglet/adminOnglet.php'); 
include_once (_JJD_ROOT_PATH.'class/cls_jjd_notedef.php');
$adoNotedef = new cls_JJD_NOTEDEF();
   
  admin_xoops_cp_header(_JJD_ONGLET_NOTE_DEF, $xoopsModule); 

  switch($op) {
  case "list":
		list_notedef ();
		break;
		

  case "new":
		//$adoNoteDef->saveRequest($_POST);
        $p = $adoNotedef->getArray(0);
        edit_notedef ($p);
		break;

  case "edit":
		$p = $adoNotedef->getArray($idNotedef);
        edit_notedef ($p);
    //redirect_header("admin_texte.php?op=edit",1,_AD_HER_ADDOK);    
		break;

  case "save":
		$adoNotedef->saveRequest($_POST);		
    redirect_header("admin_notedef.php?op=list",1,_AD_JJD_ADDOK);		
		break;



  case "remove":
    //xoops_cp_header();
    $msg = sprintf(_AD_JJD_CONFIRM_DEL, "<b>{$_GET['name']} (id:{$idNotedef})</b>" , _AD_JJD_NOTEDEF);            
    xoops_confirm(array('op'         => 'removeOk', 
                        'idNotedef'    => $_GET['idNotedef'] ,
                        'ok'         => 1),
                        "admin_notedef.php", $msg );
//    xoops_cp_footer();
    
    break;

  case "removeOk":
    $adoNotedef->deleteId($_POST['idNotedef']);    
    redirect_header("admin_notedef.php?op=list",1,_AD_JJD_DELETEOK);    
		break;

  case "duplicate":
	$p = $adoNotedef->newClone ($idNotedef, true, 'name');    
    edit_notedef ($p);    
  	break;


  case "preview":
        preview_notedef ($id);
		break;

		
	default:
	  //$state = _JJD_STATE_WAIT;
    redirect_header("admin_notedef.php?op=list",1,_AD_JJD_ADDOK);
    break;
}


   
admin_xoops_cp_footer();

 

 
//---------------------------------------------------------------------
    



?>
