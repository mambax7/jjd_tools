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


//***************************************************************


/**********************************************************************
 * 
 **********************************************************************/
function grp_createNewGroup ($name, $description, $group_type = 'Anonymous'){
	global $xoopsModuleConfig, $xoopsDB,$xoopsGroup;
	
/*
  $sql = "INSERT INTO ".$xoopsDB->prefix(_HERCST_TBL_LETTRE)
       ."(name,description,group_type)"
       .VALUES ('{}','{description}','{$group_type}');
       
       
 
      $xoopsDB->query($sql);
      $groupid = $xoopsDB->getInsertId() ;


*/
	

include_once(XOOPS_ROOT_PATH."/include/functions.php")  ;
  //$xg = new XoopsGroupHandler('rr');
    
    
    $xg = xoops_gethandler('group');  
    $g = $xg->create(true);
    $g->name        = $name;
    $g->description = $description;
    $g->group_type  = $group_type;
    
    $groupid = $xg->insert($g);
    //$groupid = $g->groupid;

    return $groupid;
    
    

}

?>
