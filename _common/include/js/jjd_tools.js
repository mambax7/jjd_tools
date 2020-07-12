

function testOnLink(v) {


  alert ("zv = " + v);

    window.navigate ("http://xoops.kiolo.com");  
  alert ("zzzv = " + v);    
    
  }

function testOnMove(ob) {

  //ob.forecolor=
  
    
  }

//----------------------------------------------------------
function transformEntites(sLine){
//var z1 = "&nbsp;=&iexcl;=&cent;";
var z1 = "&nbsp;=&iexcl;=&cent;=&pound;=&curren;=&yen;=&brvbar;=&sect;=&uml;=&copy;=&ordf;=&laquo;=&not;=&shy;=&reg;=&macr;=&deg;=&plusmn;=&sup2;=&sup3;=&acute;=&micro;=&para;=&middot;=&cedil;=&sup1;=&ordm;=&raquo;=&frac14;=&frac12;=&frac34;=&iquest;=&Agrave;=&Aacute;=&Acirc;=&Atilde;=&Auml;=&Aring;=&AElig;=&Ccedil;=&Egrave;=&Eacute;=&Ecirc;=&Euml;=&Igrave;=&Iacute;=&Icirc;=&Iuml;=&ETH;=&Ntilde;=&Ograve;=&Oacute;=&Ocirc;=&Otilde;=&Ouml;=&times;=&Oslash;=&Ugrave;=&Uacute;=&Ucirc;=&Uuml;=&Yacute;=&THORN;=&szlig;=&agrave;=&aacute;=&acirc;=&atilde;=&auml;=&aring;=&aelig;=&ccedil;=&egrave;=&eacute;=&ecirc;=&euml;=&igrave;=&iacute;=&icirc;=&iuml;=&eth;=&ntilde;=&ograve;=&oacute;=&ocirc;=&otilde;=&ouml;=&divide;=&oslash;=&ugrave;=&uacute;=&ucirc;=&uuml;=&yacute;=&thorn;=&yuml;=&quot;=&lt;=&gt;=&amp;";
var z2 = " ¡¢£¤¥¦§¨ªª«¬­®¯ÝÝÝÝÝÝÝ++ÝÝ++++++--+-+ÝÝ++--Ý-+----++++++++Ý_ÝÝ_aáGpSsætFTOd8fen=ñ==()ö~øúúvnýÝÿ\"<>&";

  //var tEntite = new array();
  var tEntite = z1.split("=");
  //var tEntite = new Array("bb","zz","rr","tt");
  //alert (tEntite[0]);  
 //alert (tEntite.length);  
  
  
  for (h = 0; h < tEntite.length; h++){
    //alert (tEntite[h]+ " = " +  z2.charAt(h));
    motif = new RegExp(tEntite[h], "g") ;
    sLine = sLine.replace(motif, z2.charAt(h));
    
  }
  
  return sLine;  
}
//---------------------------------------------------------
function get_xhr() {
//var sHref = "<{$refSeeAlsoo}>";
   //alert("RequOte en cours !");   
   
var xhr_object = null; 
  //recherche du bon navigateur   
  if(window.XMLHttpRequest) // Firefox   
    {
      xhr_object = new XMLHttpRequest();      
      return xhr_object;
    }
   
 else if(window.ActiveXObject) // Internet Explorer   
    {
      xhr_object = new ActiveXObject("Microsoft.XMLHTTP");      
      return xhr_object;  
    }
   
 else { // XMLHttpRequest non supportT par le navigateur   
    alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");   
    return null;   
    }   
   
}

//-----------------------------------------------------------------------------
function gotoURL(sHref) {
  
        window.navigate (sHref);
    
}
function gotoURL2(sHref) {
  
        window.location = sHref;
    
}

//-----------------------------------------------------------------------------
function gotoPageOnId(url, obListName) {
    
    //alert (sHref);
    obList = document.getElementsByName(obListName);
    //id = obSource.value;

    
    //alert (ob[0].value);
    sHref = url + obList[0].value
    //window.navigate (sHref );
    gotoURL2 (sHref);
    //alert(obList[0].value);
}

/***************************************************************************
 *les fonctions suivantes permette de g‚rer un spinButton
 ***************************************************************************/
function changeImgFromList(obName, obListName, root, suffixe) {

    
    

    obImg  = document.getElementsByName(obName);
    obList = document.getElementsByName(obListName);
    newImg = root + obList[0].value + suffixe;
    
    
    obImg[0].src = newImg;    
/*
alert(newImg);

    newImg = root obList[0].value;obList[0].name
    
*/
}


/***************************************************************************
 *les fonctions suivantes permette de g‚rer un spinButton
 ***************************************************************************/
function changeImgFromList2(obName, obListName, root, lIndex) {

    
    

    obImg  = document.getElementsByName(obName);
    obList = document.getElementsByName(obListName);
    newImg = root + obList[0].value;
    newImg = newImg.replace(/[?]/g, lIndex);
    
    
    obImg[0].src = newImg;    
/*

alert(newImg + "--->" + lIndex);
    newImg = root obList[0].value;obList[0].name
    
*/
}


/**************************************************************************
 *
 **************************************************************************/
function checkAll(prefixe, indexForAll, indexClicked) {
  
    if(indexForAll == indexClicked){
        //alert ("coucou");    
        obCheckBox = document.getElementsByName(prefixe + "_" + indexForAll);
        
        newStatus =  (obCheckBox[0].checked);
        //alert (obCheckBox [0].name + "-" + status);
    
        h = 0;   
        while (h < 100) {
            if (!(h == indexForAll)){
              obCheckBox = document.getElementsByName(prefixe + "_" + h); 
              if (obCheckBox.length == 0){
                break;
              }else{
                obCheckBox[0].checked = newStatus;            
              }
            
        //alert (h + " - " + obCheckBox [0].name + " - " +  obCheckBox[0].checked + " - " + status);
            }
          h++;
         // if (h>5) break;
        }
      
    }else{
      /*
      */
        obCheckBoxAll = document.getElementsByName(prefixe + "_" + indexForAll);      
        h = 0;
        newStatus = true;        
        while (h < 100) {
            if (!(h == indexForAll)){
              obCheckBox = document.getElementsByName(prefixe + "_" + h); 
              if (obCheckBox.length == 0){
                break;
              }else{
                if (obCheckBox[0].checked == false){
                    newStatus = false;

                    break;                     
                }
           
              }
            
        //alert (h + " - " + obCheckBox [0].name + " - " +  obCheckBox[0].checked + " - " + status);
            }
          h++;
         // if (h>5) break;
        }
        obCheckBoxAll[0].checked = newStatus ;      
    }
  
     
/*
 
    //alert ("SpinChange" + "-" + prefixe + "-" + sens);
*/
    
}



/**************************************************************************
 *
 **************************************************************************/
function checkFromTo(prefixe, lRow1, lRow2, lCol1, lCol2, obCheckClicked, lMode) {



    obCheckBox = document.getElementsByName(obCheckClicked);
    newStatus =  (obCheckBox[0].checked);
 
    for (h = lRow1; h <= lRow2; h++){
//alert (obCheckClicked + "-" + prefixe + "-" + newStatus);    
      for (i = lCol1; i <= lCol2; i++){
      
        if (lMode == 0){
          obName = prefixe + h + "_" + i;        
        }else{
          obName = prefixe + i + "_" + h;        
        }
//alert (obName);        
        obCheckBox = document.getElementsByName(obName);
        if (obCheckBox.length > 0){
            obCheckBox[0].checked = newStatus;        
        }
        
      }    
    }
    
   /*    
   */    
    
   
}

/**************************************************************************
 *
 **************************************************************************/
function controlSaisie (){
    obZone = document.getElementsByName("txtName");
    if (obZone.lenght > 0){
      alert (obZone[0].value) ;      
    }
   
}
/**************************************************************************
 *
 **************************************************************************/
function insertAllCode (source, destination, intEditor, delimitor, event){
  
    var sText = "";  
    obSources = document.getElementsByName(source);
    obSource = obSources[0];
  
  
  if (event.shiftKey == false){
      for (h = 0; h < obSource.length; h++){
        sText = obSource[h].text + ' = ' + delimitor.charAt(0) + obSource[h].text + delimitor.charAt(1) + "<br>";  
        insertText2Wysiwyg(sText, destination, intEditor);
      }
    
    
  }else{
      //---------------------------------------------------
    	sText = "<table border='1'>";
    	d1 = delimitor.charAt(0);
    	d2 = delimitor.charAt(1);
      for (h = 0; h < obSource.length; h++){
        sText = sText + '<tr>';
        sText = sText + '<td>' + obSource[h].text + '</td>';    
        sText = sText + '<td>' + d1 + obSource[h].text + d2 + '</td>';    
        sText = sText + "</tr>";  
    
    
      }

    	sText = sText + '</table>';  
      insertText2Wysiwyg(sText, destination, intEditor);	    
    
  }


}

/**************************************************************************
 *
 **************************************************************************/
function insertText2Wysiwyg (sText2Insert, destination, intEditor){
//define ('_EDITOR_TEXTAREA',       0);
//define ('_EDITOR_DHTMLTEXTAREA',  1);
//define ('_EDITOR_KOIVI',          2);
//define ('_EDITOR_TINY',           3);
//define ('_EDITOR_INBETWEEN',      4);
//define ('_EDITOR_DHTMLA',         5);
  
  //alert( delimitor);
    
    //---------------------------------------------------
    textareaDoms = document.getElementsByName(destination);
    textareaDom = textareaDoms[0];     
    
    //---------------------------------
    switch (intEditor){
      case 2: //_EDITOR_KOIVI
	         XK_insertHTML(sText2Insert,destination);    
          break;
          
      case 3: //_EDITOR_TINY          
      case 4: //_EDITOR_TINY          
          tinyMCE.execInstanceCommand(destination, "mceInsertContent",false, sText2Insert);

                                 
      default: //_EDITOR_TEXTAREA - _EDITOR_DHTMLTEXTAREA - _EDITOR_DHTMLA
        xoopsInsertText(textareaDom, sText2Insert);   
        
    }
	  
    //textareaDom.focus();
    
	return;
   
}
/**************************************************************************
 *
 **************************************************************************/
function insertTextIntoWysiwyg (source, destination, intEditor, delimitor, event ){
//define ('_EDITOR_TEXTAREA',       0);
//define ('_EDITOR_DHTMLTEXTAREA',  1);
//define ('_EDITOR_KOIVI',          2);
//define ('_EDITOR_TINY',           3);
//define ('_EDITOR_INBETWEEN',      4);
//define ('_EDITOR_DHTMLA',         5);
  
  //alert( delimitor);
    var sText2Insert = "";
    obSources = document.getElementsByName(source);
    obSource = obSources[0];
    //sText2Insert = obSource.value;
    if (event.shiftKey){
        sText2Insert = obSource[obSource.value].text;    
    }else{
        sText2Insert = delimitor.charAt(0) + obSource[obSource.value].text + delimitor.charAt(1);      
    }
  //alert( "la");
    //---------------------------------------------------
    insertText2Wysiwyg(sText2Insert, destination, intEditor);	  
    //textareaDom.focus();
    
	return;
   
}
