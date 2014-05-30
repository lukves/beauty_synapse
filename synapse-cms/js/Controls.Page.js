(function(){
 
    var special = jQuery.event.special,
        uid1 = 'D' + (+new Date()),
        uid2 = 'D' + (+new Date() + 1);
 
    special.scrollstart = {
        setup: function() {
 
            var timer,
                handler =  function(evt) {
 
                    var _self = this,
                        _args = arguments;
 
                    if (timer) {
                        clearTimeout(timer);
                    } else {
                        evt.type = 'scrollstart';
                        jQuery.event.handle.apply(_self, _args);
                    }
 
                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);
 
                };
 
            jQuery(this).bind('scroll', handler).data(uid1, handler);
 
        },
        teardown: function(){
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );
        }
    };
 
    special.scrollstop = {
        latency: 300,
        setup: function() {
 
            var timer,
                    handler = function(evt) {
 
                    var _self = this,
                        _args = arguments;
 
                    if (timer) {
                        clearTimeout(timer);
                    }
 
                    timer = setTimeout( function(){
 
                        timer = null;
                        evt.type = 'scrollstop';
                        jQuery.event.handle.apply(_self, _args);
 
                    }, special.scrollstop.latency);
 
                };
 
            jQuery(this).bind('scroll', handler).data(uid2, handler);
 
        },
        teardown: function() {
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
        }
    };
 
})();


//**************************************************
// COMMON FN
//**************************************************
window.onload = OnLoadQueue;

function OnLoadQueue(){
	StartTipRotator();
	if(typeof(LinkRotator)!="undefined" && LinkRotator.Count>0)
	{
		LinkRotator.Start();
	}
}


//**************************************************
function hackFlash(){
}
//**************************************************
function gObject(oName){
	return document.getElementById(oName);
}

//**************************************************
// ARTICLE HANDLERS
//**************************************************
function preparePrint(idarticle){
	window.print();
	return false;
	if(parseInt(idarticle)>0){
		var wa = window.open("/default.aspx?textartimg=1&prnwin=1&article=" + idarticle, "prn", "width=670, height=520, status=1, scrollbars=1, tollbar=0, resizable=1");
	}else{
		var wa = window.open("/default.aspx?printcourse=1&prnwin=1", "prnc", "width=700, height=400, status=1, scrollbars=1, tollbar=0, resizable=1");
	}
}
//**************************************************
function InsSm(which, where){
	var oObj = gObject(InsSm.arguments.length==1 ? "Editor" : where);
	if(oObj){
		oObj.value += which;
	}else{
		if(typeof(mailerEditor)!="undefined"){
			mailerEditor.value += which;
		}
	}
}
//**************************************************
function runMailClient(mMail){
	if(!mMail) return;
	var eAdd = new String("") + mMail.replace(" zavinac ", "@");
	eAdd = eAdd.replace(/\$/igm, ".");
	document.location = "mailto:" + eAdd;
	
}
//**************************************************
function showppp(){
	var wa = window.open("http://klub.mf.cz/podminkycz.html", "adol", "width=480, height=360, status=1, scrollbars=1, toolbar=0, resizable=0");
}


///**************************************************
// DISCUSSION
//**************************************************
function displayDiscTab(){
	var oObj = gObject("disctabdata0");
	if(oObj){
		if(oObj.style.display=="block"){
			oObj.style.display = "none";
			gObject("disctabdata1").style.display = "block";
			gObject("disctabtx").innerHTML = "Zpět na diskusi";
		}else{
			oObj.style.display = "block";
			gObject("disctabdata1").style.display = "none";
			gObject("disctabtx").innerHTML = "Zadat dotaz";
		}
	}
}



//**************************************************
// INQUIRY
//**************************************************
function arInquiry(quest){
	this.items	= null;
	this.header	= quest;
	this.footer	= new String();

	this.draw 	= fnDrawInquiry;
	this.addStrip	= fnAddInquiryStrip;
	this.addFooter	= fnAddInquiryFooter;

	return this;
}
//**************************************************
function fnDrawInquiry(){
	if(this.items!=null){
		var iText = new String();

		iText += "<div class='box box-inquiry box-red'>\n";
		iText += "<div class='box-top'><span class='corner'></span></div>\n";
		iText += "<div class='box-data'>\n<div class='inq-data-clip'>\n"
	
		iText += "<h3>" + this.header + "</h3>\n";

		for(var i=0; i< this.items.length; i++){
			iText += '<div class="inq-answer"><a href="javascript:PubSystemControlsRunInquiryVote(' + this.items[i].idInquiry + ', ' + this.items[i].idAnswer + ')">' + this.items[i].answer + '</a></div>\n';
			iText += '<div class="inq-state">\n';
			iText += '<span class="inq-state-strip float-left"><a href="javascript:PubSystemControlsRunInquiryVote(' + this.items[i].idInquiry + ', ' + this.items[i].idAnswer + ')"><span style="width:' + this.items[i].clicks + 'px;"></span></a></span>\n';
			iText += '<span class="inq-state-count float-left">' + this.items[i].clicks + '%</span>\n';
			iText += "<br class=\"clear\">\n";
			iText += '</div>\n';
		}

		iText += "<br class=\"clear\" />\n";
		iText += this.footer;
		iText += "</div>\n</div>\n"
		iText += "<div class='box-bottom'><span class='corner'></span></div>\n";
		iText += "</div>\n";

		$(document).ready(function(){
			$(".adsense-container").prepend(iText);
		});
	}
}
//**************************************************
function fnAddInquiryStrip(idI, idIS, answer, clicks){
	if(this.items==null){
		this.items = new Array();
	}
	this.items.push(new arInquiryStrip(idI, idIS, answer, clicks));
}
//**************************************************
function fnAddInquiryFooter(desc){
	this.footer = "<div class=\"inq-summary\">" + desc + "</div>\n";	
	this.footer += "<div class=\"inq-summary\"><a href=\"/Archiv-anket/default.aspx?ireport=1\">Starší ankety</a></div>\n";	
}
//**************************************************
function arInquiryStrip(idI, idIS, answer, clicks){
	this.idInquiry 	= idI;
	this.idAnswer	= idIS;
	this.answer	= answer;
	this.clicks	= clicks;

	return this;
}



//**************************************************
// COMMENTS
//**************************************************
var tAreaActive = false;
var tMailActive	= false;

function handleAreaFocus(oObj, which){
	if(!which){
		oObj.value = "";
	}	
	return true;
}



//**************************************************
// VIDEOGALLERY
//**************************************************
function getStream(oUrl, w, h, id_item){
	var cUrl	= "/showStream.aspx?f=" + oUrl.replace("http://video.zive.superhosting.cz/player.swf?idname=", "") + "&w=" + w + "&h=" + h + "&id_item=" + id_item;
	var mW = screen.availWidth;
	var mH = screen.availHeight;
	var leftPos = parseInt((mW-w)/2);
	var topPos = parseInt((mH-h-60)/2);
	var ucw = window.open(cUrl, "vpreview", "width="+w+",height="+parseInt(parseInt(h)+60)+",top="+topPos+",left="+leftPos+",resizable=0,status=yes,address=0");
  	ucw.focus();
}




//**************************************************
// OLD CORE
//**************************************************
function BigImg1(ARI,IMI)
{
	var rndm = "thumb" + Math.floor(1000000*Math.random());
	var wa = window.open("/ShowFullThumbNailOldDigi2.aspx?ari=" + ARI + "&imi=" + IMI.replace("x","/"), rndm,'status=1, tollbar=0');
}
function BigImg(ARI,IMI)
{
	var rndm = "thumb" + Math.floor(1000000*Math.random());
	var img = IMI;
	if (img.indexOf("x") == 0){
		img = img.replace("x", "/");
	}
	var wa = window.open("/ShowFullThumbNailOldDigi.aspx?ari=" + ARI + "&imi=" + ARI + img, rndm,'status=1, tollbar=0');
}
function BigImgGal(IMI)
{
	var rndm = "thumb" + Math.floor(1000000*Math.random());
	var wa = window.open("/ShowFullThumbNailOldDigi.aspx?imi=" + IMI, rndm,'status=1, tollbar=0');
}




//**************************************************
// FULL SIZE IMAGE HANDLER
//**************************************************
function ShowFullThumbNail(id_file, width, height, title, action){
  var art = gObject("article-main-data").getAttribute("article");
  window.open("/ShowArticleImages.aspx?id_file=" + id_file + "&article=" + art,"fullImage" + art, "resizable=yes,scrollbars=no,status=yes,width=800,height=640");
  return false;
}
//**************************************************
function ShowBazarImage(title){
	window.open("/ShowFullThumbNail.aspx?bazar=" + title,"fullImage", "scrollbars=no,status=yes,width=800,height=600");
	return false;
}
//**************************************************
function ShowArticleImage(id_file, width, height, title, action){
  ShowFullThumbNail(id_file, width, height, title, action);
  return false;
}
//**************************************************
function ShowArticleImageMM(id_file) {
    window.open("/ShowArticleImagesMM.aspx?id_file=" + id_file , "fullImage", "resizable=yes,scrollbars=no,status=yes,width=800,height=640");
    return false;
}
//**************************************************
function ShowCatalogThumbNail(fname, ftitle){
	var rnd = Math.floor(1000000*Math.random());
	window.open("/ShowFullThumbNail.aspx?file=" + fname + "&title=" + ftitle, "fullImage" + rnd, "scrollbars=no, status=yes");
	return false;
}


//**************************************************
function ShowGalleryImages(id_file)
{
	var oImg  = $("#image-gallery-container a img");
	var oIds  = new Array();
	var oDims = new Array();
	var oAct  = "";

	oImg.each(function(index, item){
		var oThis = $(this);
		var oSrc  = oThis.attr("src");
		var oDim  = oThis.attr("alt");
		var oId	  = oSrc.substring(oSrc.lastIndexOf("=")+1, oSrc.length);
		if(index==0 && typeof(id_file)=="undefined")
		{
			oAct = oId;	
		}
		oIds.push(oId);
		oDims.push(oDim)
	});

	var wa = window.open("/ShowGalleryImages.aspx?title=&active=" + (oAct == "" ? id_file : oAct) + "&dim=" + oDims.join("|") + "&list=" + oIds.join("|"), "fullGalleryImage", "resizable=yes,scrollbars=no,status=yes,width=800,height=640");
	wa.focus();
	return false;
}




//**************************************************
// CATALOG PANES
//**************************************************
function ShowHidePane(oId, oShow, oHide, oReplace){
	var oObj 	= document.getElementById(oId);
	var oObj2 	= document.getElementById(oId + "data");
	if(oObj2.style.display=="block"){
		oObj.innerHTML = oShow;
		oObj2.style.display = "none";
		if(ShowHidePane.arguments.length==4) document.getElementById(oReplace).style.display = "block";
	}else{
		oObj.innerHTML = oHide;
		oObj2.style.display = "block";
		if(ShowHidePane.arguments.length==4) document.getElementById(oReplace).style.display = "none";
	}
}


//**************************************************
// CATALOGS
//**************************************************
function chckClick(e)
{
	var id
	if(e)
		id=e.target.id
	else
		id=event.srcElement.id			
	var n=parseInt(id.substring(id.lastIndexOf("_")+1,id.length));
	if(n>0 && document.getElementById(id).checked){
		document.getElementById(id.substring(0, id.lastIndexOf("_"))+"_0").checked=false;
	}
	if(n==0 && document.getElementById(id).checked){
		for(var i = 0; i < document.forms[0].length; i++){
			var elm = document.forms[0].elements[i];					
			if (elm.type == "checkbox" && elm.id!=id && elm.id.indexOf(id.substring(0, id.lastIndexOf("_")))!=-1){
				elm.checked=false;
    			}
		}
	}			
}



//**************************************************
// XML HTTP REQUEST
//**************************************************
function GetXmlHttpObject()
{ 
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}




//**************************************************
// PASSPORT
//**************************************************
function DisplayAutomate(){
	var oDetail 	= gObject("logon-detail");
	var oInpPwd 	= gObject("inp-pwd");
	var oInpUid 	= gObject("inp-uid");

	if(oDetail && oInpPwd){
		oDetail.style.width 	 = (oInpPwd.offsetWidth+oInpPwd.offsetLeft-oInpUid.offsetLeft) + "px"; 
		oDetail.style.left 	 = (oInpUid.offsetLeft) + "px"; 
		oDetail.style.top 	 = (-oDetail.offsetHeight) + "px"; 
		oDetail.style.visibility = "visible";
	}
	return
}



//**************************************************
// ENTER HANDLER
//**************************************************
function AttachEventByButton(o, b)
{
	gObject(o).setAttribute("ButtonToClick", b)
	AttachKeyDownEvent(o, EnterByButton);
};
//**************************************************
function AttachKeyDownEvent(o, fn)
{
	var oObj = gObject(o);
	if(!oObj)
	{
		return;
	}
	if(oObj.addEventListener)
	{
		if(typeof(window.opera)!="undefined")
		{
			oObj.addEventListener('keyup', fn, false);
		}
		else
		{
			oObj.addEventListener('keydown', fn, true);
		}
	}
	else if(oObj.attachEvent)
	{
		oObj.attachEvent('onkeydown', fn);
	}
	else
	{
		oObj.onkeydown = fn;
	}
}
//**************************************************
function EnterPressed(e)
{
	var wkey = 0;

	if(e.keyCode)
	{
		wkey = e.keyCode;
	}
	else if(e.which)
	{
		wkey = e.which;
	}

	return wkey;
}
//**************************************************
function StopEvents(e)
{
	if(typeof(e.stopPropagation)!="undefined")
	{
		e.stopPropagation();
	}
	if(typeof(e.preventDefault)!="undefined")
	{
		e.preventDefault();
	}  
	if(e.cancelBubble || e.cancelBubble==false)
	{
		e.cancelBubble = true;
	}
}
//**************************************************
function EventButton(e)
{
	var targ;
	if(e.target)
	{
		targ = e.target;
	}
	else if(e.srcElement)
	{
		targ = e.srcElement;
	}
	if(targ.nodeType == 3)
	{
		// defeat Safari bug
		targ = targ.parentNode;
	}
	return gObject(targ.getAttribute("ButtonToClick"));
}
//**************************************************
//advanced search, consult browser
function EnterByButton(e)
{
	if(!e)
	{
		e = window.event;
	};

	if(EnterPressed(e)==13)
	{
		StopEvents(e);
		try
		{
			eval(unescape(EventButton(e).getAttribute("href")).replace("javascript:", ""));
		}
		catch(ex)
		{
			//empty catch
		}
		return false;
	}
	else
	{
		return true;
	}
}
//**************************************************
//bazar search
function SearchBazarEnter(e)
{
	if(!e)
	{
		e = window.event;
	};

	if(EnterPressed(e)==13)
	{
		StopEvents(e);
		doSearchBazar(true);
		return false;
	}
	return true;
}


//**************************************************
// BAZAR
//**************************************************
function doFilterBazar(sender, adParam, activeBazarFilter){
	var url = window.location.pathname;
	var qs = "";
	var adValue = "";
	if(!sender.type){
		qsParams[sender] = adParam;
	}else{
		if (sender.type == "select-one"){
		  if (sender.selectedIndex == -1){
		    sender.selectedIndex = 0;
		  }
		  qsParams[adParam] = sender.options[sender.selectedIndex].value;
		}else if (sender.type == "checkbox"){
		  if (sender.checked){
			 qsParams[adParam] = "1";
		  }else{
			 qsParams[adParam] = "";
		  }
		}
	}

	if (document.forms[0].ddlPageSize != null){
		qsParams["PageSize"] = document.forms[0].ddlPageSize.options[document.forms[0].ddlPageSize.selectedIndex].value;
	}
	
	for(var property in qsParams) {
		if ((qsParams[property] == null) || (qsParams[property] == "" && (sender.type == "select-one"))){
			continue;
		}
		if (qs.length == 0){
		  qs += (property + "=" + qsParams[property]);
		}else{
		  qs += ("&" + property + "=" + qsParams[property]);
		}
	}
	if (qs.length > 0){
		url += ("?" + qs);
	}
	if (activeBazarFilter){
		window.location = url.replace("&newsearch=1", "");
	}
}
//**************************************************
function doSearchBazar(simplesearch){
	var url = window.location.pathname;
	var qs = "";
	if(typeof(simplesearch)=="undefined" || !simplesearch){
		qsParams["sText"] = document.forms[0].sText.value;
		qsParams["sPriceFrom"] = getOnlyNum(document.forms[0].sPriceFrom.value);
		qsParams["sPriceTo"] = getOnlyNum(document.forms[0].sPriceTo.value);
		qsParams["sCity"] = document.forms[0].sCity.value;
	}else{
		qsParams["sText"] = document.forms[0].sBazText.value;
	}
	if (document.forms[0].ddlPageSize != null){
		qsParams["PageSize"] = document.forms[0].ddlPageSize.options[document.forms[0].ddlPageSize.selectedIndex].value;
	}
	for(var property in qsParams) {
		if ((qsParams[property] == null) || (property == "section") || (qsParams[property] == "")){
			continue;
		}
		if (qs.length == 0){
		  qs += ("?" + property + "=" + encodeURI(qsParams[property]));
		}else{
		  qs += ("&" + property + "=" + encodeURI(qsParams[property]));
		}
	}
	window.location = (url + qs).replace("&newsearch=1", "");
}
//**************************************************
function getOnlyNum(value){
  var valid = "0123456789"
  var numChar = "";
  var temp = "";
  for (var i=0; i<value.length; i++) {
	numChar = value.substring(i, i+1);
    if (valid.indexOf(numChar) == "-1"){
      continue;
    }
    temp += numChar;
  }
  return temp;
}



//**************************************************
// BAZAR RSS
//**************************************************
var bazarRSSParams = new Array("", "", "", "rss=bazar");

//**************************************************
function doBazarRSSParam(oSelect, pName, pos){
	if(oSelect.type == "select-one"){
		if(oSelect.selectedIndex<1){
			bazarRSSParams[pos] = "";
		}else{
			bazarRSSParams[pos] = pName + "=" + oSelect.value;
		}
	}else{
		if(oSelect.type == "checkbox"){
			bazarRSSParams[pos] = oSelect.checked ? pName + "=1" : "";
		}
	}
	return true
}
//**************************************************
function doBazarRSS(){
	var bUrl = "";
	for(var i=0; i<bazarRSSParams.length; i++){
		if(bazarRSSParams[i]!=""){
			bUrl += ((bUrl=="") ? "" : "&") + bazarRSSParams[i];
		}
	}
	document.forms[0].sRssUrl.value = "http://www.zive.cz/RSS/sc-47/default.aspx?" + bUrl;
}
//**************************************************
function taCount(taObj, visCntID, maxlength) {  
	if (taObj.value.length>maxlength*1) taObj.value=taObj.value.substring(0,maxlength*1); 
	visCnt=document.getElementById(visCntID);
	if (visCnt) visCnt.innerHTML=maxlength-taObj.value.length;
}




//**************************************************
// FIELDINFO
//**************************************************
var xmlHttp = GetXmlHttpObject();

//**************************************************
function GetFieldInfo(id){		
	if (xmlHttp==null){
		alert ("Browser does not support HTTP Request");
		return
	} 
	xmlHttp.onreadystatechange = StateInfoChanged;
	xmlHttp.open("GET", "/simple.aspx?fieldinfo=1&consultanswer=1&question=" + id, true);
	xmlHttp.send(null);
}
//**************************************************
function StateInfoChanged(){
 	if(xmlHttp==null){
		return;
	}
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ 
		document.getElementById("finfoframe").style.display = "block";
		document.getElementById("finfoframe").innerHTML = parsePlainHTML(xmlHttp.responseText);
	} 
}
//**************************************************
function ShowFieldInfo(event, id){
	if(document.getElementById("finfoframe")){
		if (xmlHttp==null){
			xmlHttp = GetXmlHttpObject();	
		}
		var scrollYcoord = 0;
		if (document.documentElement.clientWidth || document.body.clientWidth) {
			scrollYcoord = (document.documentElement.scrollTop    != 0 ? document.documentElement.scrollTop    : document.body.scrollTop)
		}else{
			if(window.innerHeight){
				scrollYcoord = window.scrollY;
  			}
		}
		var removeX = 0;
		if (document.documentElement.clientWidth || document.body.clientWidth) {
			removeX = parseInt((document.documentElement.clientWidth ? document.documentElement.clientWidth-1000 : document.body.clientWidth-1000)/2);
		}else{
			if(window.innerHeight){
				removeX = parseInt((window.innerHeight-1000)/2);
  			}
		}
		document.getElementById("finfoframe").style.top = ((!event ? window.event.clientY : event.clientY)+scrollYcoord-400) + "px";
		//document.getElementById("finfoframe").style.left = ((!event ? window.event.clientX : event.clientX)-removeX) + "px";
		document.getElementById("finfoframe").innerHTML = "načítání ..."
		GetFieldInfo(id);
	}	
}
//**************************************************
function HideFieldInfo(){
	if(document.getElementById("finfoframe")){
		xmlHttp = null;
		document.getElementById("finfoframe").style.display = "none"
		document.getElementById("finfoframe").innerHTML = "";
	}	
}
//**************************************************
function parsePlainHTML(oHTML){
	var oStart 	= oHTML.indexOf('maindata">');
	var oEnd	= oHTML.lastIndexOf("</div>");
	var oText 	= oHTML.substring(oStart, oEnd);

	oText = oText.substring(oText.indexOf(">")+1, oText.length);	
	return oText;
}


//**************************************************
// MODAL DIALOG
//**************************************************
var AdSpots 	= new Array("banner_ahead", "banner_text_links", "banner_sky", "banner_square", "banner_x_computer");

//**************************************************
function ShowModalInfo(ModalText, SwapObject, RunFn)
{

	if(ModalText!=null)
	{

		SetAdvertVisibility("hidden");

		if(gObject("modal-zive")==null)
		{
			var oDiv = document.createElement("div");
			oDiv.setAttribute("id", "modal-zive");
			oDiv.setAttribute("class", "arforum-security");
			oDiv.setAttribute("className", "arforum-security");
			gObject("page-navigation").parentNode.insertBefore(oDiv, gObject("page-navigation"));
		
		}
		else
		{
			gObject("modal-zive").style.display = "block";
		}

		try
		{
			//gObject("modal-zive").style.height = document.documentElement.scrollHeight + "px";
		}
		catch(e)
		{
			//height not  set
		}

		SetModalContent(ModalText, SwapObject, RunFn);
	}

}
//**************************************************
function HideModal(logOn)
{
	SetAdvertVisibility("");
	gObject("modal-zive").style.display = "none";
	if(logOn===true)
	{
		
		document.location = $(".block-auth .btn").attr("href");
	}
}
//**************************************************
function SetModalContent(ModalText, SwapObject, RunFn)
{
	var oDiv = gObject("modal-zive");

	if(!SwapObject)
	{
		if(gObject("modal-zive-inner")==null)
		{
			var oDivInner 		= document.createElement("div");
			if(SwapObject==false)
			{
				oDivInner.innerHTML 	= ModalText + "<p align='center'><input type='button' onclick=\"HideModal(true)\" value='Přihlásit se' />&nbsp;<input type='button' onclick=\"HideModal()\" value='Zavřít upozornění' /></p>";
			}
			else
			{
				oDivInner.innerHTML 	= ModalText;
			}

			oDivInner.setAttribute("id", "modal-zive-inner");
			oDiv.appendChild(oDivInner);
		}
		else
		{
			if(SwapObject==false)
			{
				gObject("modal-zive-inner").innerHTML 	= ModalText + "<p align='center'><input type='button' onclick=\"HideModal(true)\" value='Přihlásit se' />&nbsp;<input type='button' onclick=\"HideModal()\" value='Zavřít upozornění' /></p>";
			}
			else
			{
				gObject("modal-zive-inner").innerHTML 	= ModalText;
			}
		}
	}
	else if(SwapObject && gObject(ModalText)!=null)
	{
		if(gObject(ModalText).innerHTML!="")
		{
			if(gObject("modal-zive-inner")==null)
			{
				var oDivInner 			= document.createElement("div");
				oDivInner.innerHTML 		= gObject(ModalText).innerHTML;
				gObject(ModalText).innerHTML 	= "";

				oDivInner.setAttribute("id", "modal-zive-inner");
				oDiv.appendChild(oDivInner);
			}
			else
			{
				gObject("modal-zive-inner").innerHTML 	= gObject(ModalText).innerHTML;
				gObject(ModalText).innerHTML 		= "";
			}
		}
	}

	try
	{
		//gObject("modal-zive-inner").style.top = (parseInt(document.documentElement.offsetHeight/3) + document.documentElement.scrollTop) + "px";
	}
	catch(e)
	{
		//top not set
	}

	if(RunFn)
	{
		eval(RunFn +"()");
	}
}
//**************************************************
function SetAdvertVisibility(VisibilityType)
{
	for(var i=0; i<AdSpots.length; i++)
	{
		if(gObject(AdSpots[i])!=null)
		{
			gObject(AdSpots[i]).style.visibility = VisibilityType;
		}
	}

}



(function($) {
    $.fn.extend({
        SetUrlQuery: function(){
		if(arguments && arguments.length>0)
		{
			var oSearch	= new Object();
			for(var i=0; i<arguments.length; i++)
			{
				var oQuery = arguments[i].split("=");
				oSearch[oQuery[0]] = oQuery[1];
			}

			var oUrl = "";//window.location.protocol + "//" + window.location.hostname;
			if(window.location.pathname!="")
			{
				oUrl += window.location.pathname.replace(new RegExp("(\/$)|(\/\?$)|(\/default\.aspx$)|(\/default\.aspx\?$)", "g" ), "");
			}

			var oQS = "/?"
			for(var QS in oSearch)
			{
				oQS += QS + "=" + oSearch[QS] + "&";
			}
			return oUrl + oQS;
		}
		else
		{
			return document.URL;
		}
        },
        AppendUrlQuery: function(){
		if(arguments && arguments.length>0)
		{
			var oSearch	= new Object();
			window.location.search.replace(new RegExp("([^?=&]+)(=([^&]*))?", "g"), function($0, $1, $2, $3){
				oSearch[$1] = $3;
			});
			for(var i=0; i<arguments.length; i++)
			{
				var oQuery = arguments[i].split("=");
				oSearch[oQuery[0]] = oQuery[1];
			}

			var oUrl = window.location.protocol + "//" + window.location.hostname;
			if(window.location.pathname!="")
			{
				oUrl += "";//window.location.pathname.replace(new RegExp("(\/$)|(\/\?$)|(\/default\.aspx$)|(\/default\.aspx\?$)", "g" ), "");
			}

			var oQS = "/?"
			for(var QS in oSearch)
			{
				oQS += QS + "=" + oSearch[QS] + "&";
			}
			return oUrl + oQS;
		}
		else
		{
			return document.URL;
		}
        },
	RedirToUrl:	function(url){
		if($.browser.msie)
		{
			var oLink = $('<a>&nbsp;</a>');
               		oLink.attr("href", url);

	                $("body").append(oLink);
			oLink.bind("click", function(){return true;});
			oLink.get(0).click();
		}
		else
		{
			location.href = url;
		}
	}
   });
})(jQuery);