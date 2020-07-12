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

/****************************************************************************
 *
 ****************************************************************************/
function getFolder ($folder, $extention = ''){

    if (!(substr($folder,-1) == '/')) $folder.='/';
    //echo "<hr>{$folder}<hr>";
    $folder = str_replace('//','/',$folder);
    $f = array();
    //$f[] = '';
    //-------------------------------------------
    
    if ($extention == ''){
    
          //foreach (glob("{$folder}*.*", GLOB_ONLYDIR) as $filename) {
          $td = glob($folder.'*', GLOB_ONLYDIR);
          //displayArray($td,"----- getFolder -----"); 
          foreach ($td as $filename) {          
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            //if (is_dir($folder.$filename)) $f[] = $folder.$filename;       
            $f[] = $filename;               
          }
    
    }else{
      //construction du tableu des extention
    //if (!substr($extention,0,1) == "."){$extention = ".".$extention; }      
    $extention = strtolower($extention);      
    $extention = str_replace ('.','', $extention);
    $t = explode(';', $extention); 
    //-------------------------------------------------
 
      for ($h=0; $h < count($t); $h++){
          $patern = "{$folder}*.{$t[$h]}";  
          //echo "<hr>$extention<br>$patern<hr>";   
          foreach (glob($patern) as $filename) {
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            $f[] = basename ($filename);          
          }
        
      }
    
    }

      
    //displayArray($f, '----fichiers-----'.$folder);
    return $f;
}

/****************************************************************************
 @tableau passer en réfarence
 @folder : dossier racine de recherche
 @$extention : chaine, list ou tableu de chaine des extension à rechercher
 @$level : niveau de profondeur de recherche dans les sous dossier : 0 = dossier racine
 @addblanck : pour ermettre de ne rien sélection dans les lste déroulante
 ****************************************************************************/
function getFiles2 ($folder, 
                    $fullName = false,
                    $extensions = '',
                    $level = 0, 
                    $addblanck = false, 
                    $sepExtension = ';'){
$becho = false;                    
    //----------------------------------------------
    if (!(substr($folder,-1) == '/')) $folder.='/';
    $folder = str_replace('\\','/',$folder);    
    $folder = str_replace('//','/',$folder);    
    if ($becho) echo "<hr>getFiles2 : level = {$level} : {$folder}<br>";    
    //----------------------------------------------
    //traitement de la liste des extention pour en faire un tableau propre
    //si $sepExtension = '*' alors ce traitement a deja ete effectué
    //ceci dans e cas de recherche dans les sous repertoires
    if ($sepExtension == '*'){
      $te =  $extensions;    
    }else{    
      if (is_array($extensions)){
       $extensions  = implode ($sepExtension, $extensions);
      }
      if ($becho) echo "getFiles2 : extentions={$extensions}<br>";
      //tout mettre en minuscule, normalement ca devrait pas poser de probleme
      $extensions = strtolower ($extensions);
      //suppression de tous les points
      $extensions = str_replace ('.', '', $extensions);    
      //transfert dans un tableau des extensions  
      $t = explode(';', $extensions); 
      $te = array_flip($t);
    }
    //if ($becho) displayArray($te, "getFiles2->extensions");
      //-------------------------------------------    
    $f = array();    
    if ($addblanck) $f[] = '';    
    //-------------------------------------------    
    //traitement des fichier du dossier racine
    $h = 0;
    foreach (glob("{$folder}*.*") as $filename) {
      if ($becho) echo "getFiles2 - glob: {$h}-{$filename}<br>";        
        $tmp = explode('.', $filename);
        $ext = ((count($tmp) == 1) ? '' : $tmp[count($tmp)-1]);
        $ext = strtolower($ext);
        
        if (isset($te[$ext])){
          $bolOk = true;
        }else{
          $bolOk=false;
        }
        //----------------------------------------------
        if ($bolOk){
          $f[] = $filename;        
        
          //$f[] = (($fullName)? '' : $folder) .$filename;
        }
      //echo "$filename occupe " . filesize($filename) . " octets\n";

      $h++;          
    }
    
    //------------------------------------------------------
    //traitement des sous répertoire le cas echeant
    $h = 0;
    if ($level > 0){
      $td = glob($folder.'*', GLOB_ONLYDIR);
      if (!$td == false){
    
      foreach ($td as $subFolder) { 
        if ($becho) echo "getFiles2 - glob folder: {$h}-{$subFolder}<br>";        
          /*
          */
        
          $tf = getFiles2 ($subFolder.'/', true, $te, $level -1, false, '*');
        
        //echo "$filename occupe " . filesize($filename) . " octets\n";
          //if (is_dir($folder.$filename)) $f[] = $folder.$filename;       
          $f = array_merge($f, $tf) ;
          $h++;
          //if ($h > 12) exit;        
                         
        }
      }      
    }
    
    
    if (!$fullName AND $level == 0){
      $lg = strlen($folder);
      for ($h = 0; $h < count($f); $h++){
        $f[$h] = substr($f[$h], $lg);
      }
    }
    //------------------------------------------------------------
    if ($becho) displayArray($f, '----fichiers-----'.$folder);
    return $f;
}

/****************************************************************************
 *$isFullfolder : nouveau paramètre pour indiquer si $folder est un dossier complet 
 * ou un dé but de racine
 * exemple : 
 * "monsite/modules/hermes/admin"   équivalent à  "monsite/modules/hermes/admin/" 
 * "monsite/modules/hermes/admin_"   équivalent à  "monsite/modules/hermes/admin/admin_*"
 * le premier est un chemin complet le 2eme est un cemin avec une racine de fichiers
 * ce qi permet de cherchertous les fichiers qui commence par un prfixe      
 ****************************************************************************/
function getFiles ($folder, $extention = '', $addblanck = true, $isFullNameFolder = true){

    if (!(substr($folder,-1) == '/') & $isFullNameFolder) $folder.='/';
    //echo "<hr>{$folder}<hr>";
    $folder = str_replace('//','/',$folder);
    $f = array();
    if ($addblanck) $f[] = '';
    //-------------------------------------------
    if ($extention == '' ){
          foreach (glob("{$folder}*.*") as $filename) {
            //echo "$filename occupe " . filesize($filename) . " octets\n";
            $f[] = $folder.$filename;          
          }
    
    }else{
      //construction du tableu des extention
    //if (!substr($extention,0,1) == "."){$extention = ".".$extention; }      
    $extention = strtolower($extention);      
    $extention = str_replace ('.','', $extention);
    $t = explode(';', $extention); 
    //-------------------------------------------------
 
      for ($h=0; $h < count($t); $h++){
          $patern = "{$folder}*.{$t[$h]}";  
          //echo "<hr>$extention<br>$patern<hr>";   
          foreach (glob($patern) as $filename) {
          //echo "$filename occupe " . filesize($filename) . " octets\n";
            $f[] = basename ($filename);          
          }
        
      }
    
    }

      
    //displayArray($f, '----fichiers-----'.$folder);
    return $f;
}

/****************************************************************************
 *
 ****************************************************************************/
function getFiles_S ($folder, $extention = ''){
      $f = array();
      $f[] = '';      
    if ($handle = opendir($folder)) {
        //echo "Directory handle: $handle\n";
        //echo "Files:\n";
      

      if (!substr($extention,0,1) == "."){$extention = ".".$extention; }
      $extention = strtolower($extention);
      $lg = strlen($extention);
      
        /* Ceci est la façon correcte de traverser un dossier. */
        while (false !== ($file = readdir($handle))) {
            if (strtolower(substr($file,-$lg)) == $extention AND substr($file,0,1)<>".") {
            $f[] = $file;
            }
            
           //echo "$file\n";
        }
    
    
        closedir($handle);
    }
    //displayArray($f, '----fichiers-----'.$folder);
    return $f;
}

/****************************************************************************
 *
 ****************************************************************************/
function htmlFilesList ($defaut = '', $folder = '', $extention = 'gif', 
                        $onChange = '', $name = 'lstIcones', 
                        $addblanck = true, $isFullNameFolder = false){

  //$list = getFiles (_LEXCST_DIR_LEXICONES, 'gif');
  $list = getFiles ($folder, $extention, $addblanck, $isFullNameFolder);
  
  //$list = getFiles2 ($folder, false, $extensions , 1, true);  
  //$list = getFiles_S ($folder, $extention);
  $listBox = buildHtmlListString($name, $list, $defaut, false, $onChange);
  return $listBox;
}



/****************************************************************************
 *
 ****************************************************************************/

function getFileList($folder, $extention = ""){

Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;
//$folder = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/";	



   
  $t = array();
  $f = $folder;  
  $d = dir($f);
 
  //echo "Pointeur: " . $d->handle . "<br />\n";
  //echo "Chemin: " . $d->path . "<br />\n";
//  echo "<hr>{$folder}<hr>";
  
  while (false !== ($entry = $d->read())) {

    if (substr($entry,0,1) <> "." AND $entry <> 'index.html') {
      if ($extention == ""){
          $t[] = $entry;      
      }elseif (substr($entry,-strlen($extention)) == $extention) {
          $t[] = $entry;      
      }
    
    }
  }
  $d->close();
  sort ($t);

//  displayArray($t,"**********liste des plugin****************") ;  
  return $t ; 
}

/****************************************************************************
 *
 ****************************************************************************/

function getFileListH($folder, $extention = "", $level = 9999, $tExt = ''){

//$folder = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/";	
  
  $extention = trim($extention);
  
  if (!is_array($tExt)){
    if ($extention == ''){  
      $tExt = array();    
    }else{
      $tExt = explode(';', $extention);    
    }  
  }
  $nbExt = count($tExt);
  //if ($level == 0) $level = 99999;
   


  //if ($level == 0) $level = 99999;
   
  $t = array();
  $f = $folder;  
  $d = dir($f);
  //echo "<hr>{$nbExt}-{$folder}<br>{$f}<hr>"; 

  
  while (false !== ($entry = $d->read())) {
    if (substr($entry,0,1) <> "." AND $entry <> 'index.html') {
      if (is_dir($folder.$entry) AND $level > 0){
        $sf = getFileListH ($folder.$entry.'/', $extention, $level -1, $tExt);
        $t = array_merge ($t, $sf);
      }elseif ($nbExt == 0){
      
          $t[] = $folder.$entry;      
      }else{
          for ($h = 0; $h < count($tExt); $h++){
            if (substr($entry,-strlen($tExt[$h])) == $tExt[$h]) {
                $t[] = $folder.$entry;  
            }
          }
        
      }
    }
  }
  $d->close();
  sort ($t);

  //displayArray($t,"**********liste des plugin****************") ;  
  return $t ; 
}

/**********************************************************************
 *
 ***********************************************************************/
function getFileListH2($folder, $extention = "", $level = 0){

Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;
//$folder = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/";	



   
  $t = array();
  $f = $folder;  
  $d = dir($f);
 
  //echo "Pointeur: " . $d->handle . "<br />\n";
  //echo "Chemin: " . $d->path . "<br />\n";
//  echo "<hr>{$folder}<hr>";
  
  while (false !== ($entry = $d->read())) {

    if (substr($entry,0,1) <> "." AND $entry <> 'index.html') {
      if ($extention == ""){
          $t[] = $folder.$entry;      
      }elseif (substr($entry,-strlen($extention)) == $extention) {
          $t[] = $folder.$entry;      
      }elseif (is_dir($folder.$entry)){
        $sf = getFileListH ($folder.$entry.'/', $extention);
        $t = array_merge ($t, $sf);
      }
    
    }
  }
  $d->close();
  sort ($t);

  //displayArray($t,"**********liste des plugin****************") ;  
  return $t ; 
}

///////////////////////////////////////////////////////////////////////////
//      fonctions de lecture des doc dans le repertoire language/doc
///////////////////////////////////////////////////////////////////////////
/****************************************************************************
 *
 ****************************************************************************/

function BuildLinkOnFolderDoc($url = 'index.php', $sep = _LEX_SEP_LINK2){

Global $xoopsDB, $xoopsModuleConfig,$xoopsConfig, $info,$libelle;
   
  $t = array();
  $f = _LEXCST_DIR_MODULEROOT."language/{$xoopsConfig['language']}/doc/";	
  $d = dir($f);
 
  //echo "Pointeur: " . $d->handle . "<br />\n";
  //echo "Chemin: " . $d->path . "<br />\n";
  $link1 = "{$url}?op=read&doc=";  
  while (false !== ($entry = $d->read())) {
    //$link2 = $link1.$entry;
    if (substr($entry,0,1) <> "." AND $entry <> 'index.html') {
      $link2 = "<A HREF='{$link1}{$entry}'>{$entry}</A>";  
    
       //echo $entry . "<br />\n";
       $t[] = $link2;
    
    }
  }
  $d->close();
  sort ($t);

     
    $r = $sep.implode ($sep, $t).$sep; 
    return $r ; 
}
/**************************************************************************
 *
 **************************************************************************/

function addSlash($path, $sl = '/'){
  
  $path = str_replace('\\', '/', $path);
  if (substr($path, -1) <> '/') $path = $path.$sl;
  return $path;
}

/**********************************************************************
 * 
 **********************************************************************/
function loadTextFile ($fullName){


  if (!is_readable($fullName)){return '';}
  
  $fp = fopen($fullName,'rb');
  $taille = filesize($fullName);
  $content = fread($fp, $taille);
  fclose($fp);
  
  return $content;

}
/**********************************************************************
 * 
 **********************************************************************/
function isFolder(&$path, $bCreate = false, $m = 0777){

 $m = 0777;
 
  $path = str_replace('\\', '/', $path.'/');
  $path = str_replace('//', '/', $path);  
  $r = false;
  $om = umask ( $m);    
  
 
  if (is_dir($path)) {
    $r = true;              
    addHtmlIndex2folder ($path);
  }else{
    if ($bCreate){ 
      //$b = mkdir ($path,0777, true);


      //$b = @mkdir ($path, $m, true);  
      $b = false;
      $pp = 0;    
      if (!$b) {
        $pp ++;
        $root = _JJD_PROOT ;       
        $sb = substr($path, strlen($root) );

        $t = explode('/', $sb);
        
        //echo "\n<hr>isFolder<br>{$path}<br>{$sb}<hr>\n";
        //displayArray($t,"---------isFolder------------------");
        while (list($key, $item) = each($t)){
            if ($item == '') continue;
            $root .= $item.'/';
            //echo "<hr>:{$pp}---->{$root}<hr>";            
            if (!is_dir($root)){

                $b = mkdir ($root, $m); 
                chmod($root, $m);                
                if (!$b) die ("-{$pp}-isFolder-Impossible de creer le dossier : {$root}") ;                       
            }else{
                chmod($root, $m);
            }
            addHtmlIndex2folder ($root); 
            
        }      
        //$b = mkdir ($path, $m);      
      } ;      
      if (!$b) die ("{$pp}-isFolder-Impossible de creer le dossier : {$path}") ;   
    
      $r = true;    
    }
   
  }  
  

//echo sprintf("<hr>%1\$s<br>%2\$o-%3\$o<hr>" , $path, $om, $m);
  if ($r) setChmod($path, $m);
  return $r;

}
/**********************************************************************
 * 
 **********************************************************************/
function addHtmlIndex2folder($sRoot){
    
    if (!is_dir($sRoot)) return false;
    //echo "\n<hr>addHtmlIndex2folder<br>{$sRoot}<hr>\n";
    $fileIndex = $sRoot . '/index.html';
    $fileIndex = str_replace ('//', '/', $fileIndex);
    

    if (!is_file($fileIndex)){
        //echo "\n<hr>addHtmlIndex2folder<br>{$fileIndex}<hr>\n";    
        $content = "<script>history.go(-1);</script>";
        saveTexte2File2($fileIndex,  $content, 0444);
    } 


}
/**********************************************************************
 * 
 **********************************************************************/
function setChmod(&$path, $m = 0777){
  
  if (!is_dir($path)) return false;
  chmod($path , $m);  

  $t = getFolder($path);
  //displayArray($t,"----------setChmod------------------");  
  while (list($key,$item) = each($t)){
  //for ($h=0; $h <= count($t); $h++){
    //echo "<hr>setChmod<br>{$item}<hr>";
    chmod($item , $m);  
  } 

}

/**********************************************************************
 * 
 **********************************************************************/
function buildPath($path){
    
    $b = isFolder($path, true);
    return $path;    

}

/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File($fullName, $content, $mod = 0000){
  $fullName = str_replace('//', '/', $fullName);  
  
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
  if (isFolder(dirname($fullName), true)){
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
    }else{
      return false;
    }
  

}
/**********************************************************************
 * 
 **********************************************************************/
function saveTexte2File2($fullName, $content, $mod = 0000){
  $fullName = str_replace('//', '/', $fullName);  
  
  if (!is_dir(dirname($fullName))) return false;
  //echo "\n<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>\n";
  //buildPath(dirname($fullName));
  //if (isFolder(dirname($fullName), true)){
      $fp = fopen ($fullName, "w");  
      fwrite ($fp, $content);
      fclose ($fp);
      if ($mod <> 0000) {
        //echo "<hr>saveTexte2File mode :{$mod}<br>{$fullName}<hr>";
        chmod($fullName, $mod);
      }
   // }else{
   //   return false;
   // }
  

}


?>
