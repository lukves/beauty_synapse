function showAvailableDrives()
{
document.write( getDriveList() );
} 

function setActiveLanguage(str) {
  createCookie('language',str, 1);
}

function s(name, src) {
  eval('document.'+name+'.src="'+src+'";');
}

function datum()
{
	var dat = new Date();
	var den = new Array("nede&#318;a", "pondelok", "utorok", "streda", "&#353;tvrtok", "piatok", "sobota");
	var mesiac = new Array("januára", "februára", "marca", "apríla", "mája", "júna", "júla", "augusta", "septembra", "októbra", "novembra", "decembra");
	var plny = den[dat.getDay()] + ", " + dat.getDate() + ". " + mesiac[dat.getMonth()] + " " + dat.getFullYear();
	return plny;
}

function zobrazSkryj(idecko){
	el=document.getElementById(idecko).style; 
	el.display=(el.display == 'block')?'none':'block';
}

function setActiveStyleSheet(title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
}

function getActiveStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) return a.getAttribute("title");
  }
  return null;
}

function getPreferredStyleSheet() {
  var i, a;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1
       && a.getAttribute("rel").indexOf("alt") == -1
       && a.getAttribute("title")
       ) return a.getAttribute("title");
  }
  return null;
}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}

// this deletes the cookie when called
function deleteCookie( name, path, domain ) {
if ( Get_Cookie( name ) ) document.cookie = name + "=" +
( ( path ) ? ";path=" + path : "") +
( ( domain ) ? ";domain=" + domain : "" ) +
";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

window.onload = function(e) {
  var cookie = readCookie("style");
  var title = cookie ? cookie : getPreferredStyleSheet();
  setActiveStyleSheet(title);
}

window.onunload = function(e) {
  var title = getActiveStyleSheet();
  createCookie("style", title, 365);
}

var cookie = readCookie("style");
var title = cookie ? cookie : getPreferredStyleSheet();
setActiveStyleSheet(title);

function loadjscssfile(filename, filetype){
 if (filetype=="js"){ //if filename is a external JavaScript file
  var fileref=document.createElement('script')
  fileref.setAttribute("type","text/javascript")
  fileref.setAttribute("src", filename)
 }
 else if (filetype=="css"){ //if filename is an external CSS file
  var fileref=document.createElement("link")
  fileref.setAttribute("rel", "stylesheet")
  fileref.setAttribute("type", "text/css")
  fileref.setAttribute("href", filename)
 }
 if (typeof fileref!="undefined")
  document.getElementsByTagName("head")[0].appendChild(fileref)
}

function loadaltcssfile(filename, titlename){
  var fileref=document.createElement("link")
  fileref.setAttribute("rel", "alternate stylesheet")
  fileref.setAttribute("type", "text/css")
  fileref.setAttribute("title", titlename)
  fileref.setAttribute("href", filename)
if (typeof fileref!="undefined")
  document.getElementsByTagName("head")[0].appendChild(fileref)
}

// loadjscssfile("myscript.js", "js") //dynamically load and add this .js file

