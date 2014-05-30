function changePocket(id)
{
	for (var i=1;i<=5;i++)
	{
		document.getElementById('cap'+i).className = "";
		document.getElementById('pocket'+i).style.display = "none";
	}
	document.getElementById('cap'+id).className = "active";
	document.getElementById('pocket'+id).style.display = "block";
}

function changePocket2(id)
{
	for (var i=1;i<=3;i++)
	{
		document.getElementById('cap1'+i).className = "";
		document.getElementById('pocket1'+i).style.display = "none";
	}
	document.getElementById('cap1'+id).className = "active";
	document.getElementById('pocket1'+id).style.display = "block";
}

var smile = [
    {'img':'regular_smile','smile':':)'},
    {'img':'sad_smile','smile':':('},
    {'img':'wink_smile','smile':';)'},
    {'img':'tounge_smile','smile':':P'},
    {'img':'angry_smile','smile':':E'},
    {'img':'kiss','smile':':kiss:'},
    {'img':'heart','smile':':heart:'}
]

function htmlspecialchars(text) {
  text = text.replace(eval('/<BR([^\>])*>/gi'),"");
  text = text.replace(eval('/&amp;/gi'),"&");
  text = text.replace(eval('/&lt;/gi'),"<");
  text = text.replace(eval('/&gt;/gi'),">");
  var re = /<a[^>]+href="([^"]*)"[^>]*>([^<]*)<\/a>/gi;
  text = text.replace(re,"[url=$1]$2[/url]");
  var re = /<div class="?quote"?>(([^\<]|\n|\r)*)<\/div>/mgi;
  text = text.replace(re,"[quote]$1[/quote]");
  text = text.replace(re,"[quote]$1[/quote]");
  text = text.replace(re,"[quote]$1[/quote]");
  text = text.replace(re,"[quote]$1[/quote]");
  text = text.replace(re,"[quote]$1[/quote]");
  var re = /\<(\/?)s\>/gi;
  text = text.replace(re,"[$1s]");
  var re = /\<(\/?)b\>/gi;
  text = text.replace(re,"[$1b]");
  var re = /\<(\/?)i\>/gi;
  text = text.replace(re,"[$1i]");
  var re = /\<(\/?)u\>/gi;
  text = text.replace(re,"[$1u]");
  for (var i = 0; i < smile.length; i++)
    text = text.replace(eval('/<img([^>]+)'+smile[i].img+'([^>]+)>/gi'),smile[i].smile);
  return text;
}


var saved_content = [];
function edit_comment(id) {
    if (!$('textc'+id)) return;
    var content = $('textc'+id).innerHTML;
    saved_content[id] = content;
    content = htmlspecialchars(content);
    $('textc'+id).update('<div class="toolbar">'
         + '<button class="fbutton" accesskey="b" id="addbbcode0_e'+id+'"  style="width: 30px" onClick="bbstyle(0, \'e'+id+'\')"><span style="font-weight: bold"> B </span></button> '
         + '<button class="fbutton" accesskey="i" id="addbbcode2_e'+id+'"  style="width: 30px" onClick="bbstyle(2, \'e'+id+'\')"><span style="font-style: italic"> i </span></button> '
         + '<button class="fbutton" accesskey="u" id="addbbcode4_e'+id+'"  style="width: 30px" onClick="bbstyle(4, \'e'+id+'\')"><span style="text-decoration: underline"> U </span></button> '
         + '<button class="fbutton" accesskey="s" id="addbbcode8_e'+id+'"  style="width: 30px" onClick="bbstyle(8, \'e'+id+'\')"><span style="text-decoration: line-through"> S </span></button> '
         + '<button class="fbutton" style="width: 30px" onClick="input_url(\'e'+id+'\')"><span> URL </span></button> '
         + '<button class="fbutton" id="addbbcode6_e'+id+'"  style="width: 60px" onClick="bbstyle(6, \'e'+id+'\')"><span> QUOTE </span></button> '

         + '</div><textarea id="texte'+id+'">'+content+'</textarea><input type="button" class="button" value="Save" onclick="save_edit('+id+')" /><input type="button" class="button" value="Cancel" onclick="cancel_edit('+id+')" /><br /><br />');
    $('action'+id).hide();
}

function cancel_edit(id) {
    if (!$('textc'+id)) return;
    $('textc'+id).innerHTML = saved_content[id];
    $('action'+id).show();
}

function save_edit(id) {
    var text = $('texte'+id).value;
    var hm = $('textc'+id).up().hasClassName('my'); 
    if (hm) $('textc'+id).up().removeClassName('my');
    $('textc'+id).innerHTML = '<img src="/pics/ajax-loader.gif" />';
    new Ajax.Request('/ajax?action=edit_comment&id='+id, {
      parameters: { text: text },
      onSuccess: function(transport) {
        if (hm) $('textc'+id).up().addClassName('my');
        $('textc'+id).innerHTML = transport.responseText;
        $('action'+id).show();
      }  
    });
}

function preview(id) {
    $('preview'+id).down().next().removeClassName('my').innerHTML = '<img src="/pics/ajax-loader.gif" />';
    $('preview'+id).show();
    new Ajax.Request('/ajax?action=preview', {
      parameters: { text: $('text'+id).value },
      onSuccess: function(transport) {
        $('preview'+id).down().next().addClassName('my').innerHTML = transport.responseText;
      }  
    });
}

function delete_comment(id) {
    if (!$('textd'+id)) return;
    if (confirm('Really delete this comment?')) {
        new Ajax.Request('/ajax?action=delete_comment&id='+id, {
          onSuccess: function(transport) {
            $('textd'+id).remove();
            $('currently').update(parseInt($('currently').innerText) - 1);
          }  
        });
    }
}

var prevform = 0;
function showform(fid) {
    if (prevform) prevform.style.display = 'none';
    prevform = document.getElementById('form'+fid);
    prevform.style.display = 'block';
}

function expand_thread(trid) {
    document.getElementById('thread'+trid).style.display = 'block';
    document.getElementById('thread_e'+trid).style.display = 'none';
}
function collapse_thread(trid) {
    document.getElementById('thread'+trid).style.display = 'none';
    document.getElementById('thread_e'+trid).style.display = 'block';
}

function expand_all() {
    $$('a.plus').each(function(s) {
        s.hide();
        s.next().show();
    });
}

function collapse_all() {
    $$('div.thread').each(function(s) {
        s.hide();
		s.previous().show();
    });
}

// bbCode control by
// subBlue design
// www.subBlue.com

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[br]','[/br]','[s]','[/s]','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
//bbtags = new Array('<b>','</b>','<i>','</i>','<u>','</u>','<br>','</br>','<s>','</s>','[list]','[/list]','[list=]','[/list]','[img]','[/img]','[url]','[/url]');
imageTag = false;

// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function inputimgenc_url(id) {
     var txtarea = document.getElementById('text'+id);
    if (!txtarea) return false;
    
    var v = prompt('Enter IMAGE URL');
    if (v) {
        txtarea.value += '<img src="'+v+'">';
    }
}

function inputimg_url(id) {
     var txtarea = document.getElementById('text'+id);
    if (!txtarea) return false;
    
    var v = prompt('Enter IMAGE URL');
    if (v) {
        txtarea.value += '[img]'+v+'[/img]';
    }
}

function input_url(id) {
     var txtarea = document.getElementById('text'+id);
    if (!txtarea) return false;
    
    var v = prompt('Enter URL');
    if (v) {
        txtarea.value += '[url]'+v+'[/url]';
    }
}

function input_youtube(id) {
     var txtarea = document.getElementById('text'+id);
    if (!txtarea) return false;
    
    var v = prompt('Enter URL');
    if (v) {
       // txtarea.value += '<iframe width=\"560\" height=\"315\" src=\"'+v+'\" frameborder=\"0\" allowfullscreen></iframe>';
	    txtarea.value += '[iframe]'+v+'[/iframe]';
    }
}

function bbstyle(bbnumber, id) {

 var txtarea = document.getElementById('text'+id);
 if (!txtarea) return false;


	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];

            buttext = eval('document.getElementById("addbbcode'+bbnumber+'_'+id+'").value');
            eval('document.getElementById("addbbcode'+bbnumber+'_'+id+'").value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return false;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return false;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return false;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
                //buttext = eval('document.getElementById("addbbcode'+bbnumber+'_'+id+'").value');
                //eval('document.getElementById("addbbcode'+bbnumber+'_'+id+'").value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return false;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			//document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		//eval('document.post.addbbcode'+id+'_'+bbnumber+'.value += "*"');
		txtarea.focus();
        return false;
	}
	storeCaret(txtarea);
	return false;
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = (typeof(txtarea.textLength) == 'undefined') ? txtarea.value.length : txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	var scrollTop = txtarea.scrollTop;

	if (selEnd == 1 || selEnd == 2) 
	{
		selEnd = selLength;
	}

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);

	txtarea.value = s1 + open + s2 + close + s3;
	txtarea.selectionStart = selEnd + open.length + close.length;
	txtarea.selectionEnd = txtarea.selectionStart;
	txtarea.focus();
	txtarea.scrollTop = scrollTop;

	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

var selection = false; // Selection data

// Catching selection
function catchSelection()
{
	if (window.getSelection)
	{
		selection = window.getSelection().toString();
	}
	else if (document.getSelection)
	{
		selection = document.getSelection();
	}
	else if (document.selection)
	{
		selection = document.selection.createRange().text;
	}
}

function fixShadow() {
    $('shadow').setStyle({
        width : document.viewport.getWidth()+document.viewport.getScrollOffsets().left+'px', 
        height: document.viewport.getHeight()+document.viewport.getScrollOffsets().top+'px'
    });
    
  $('welcome').setStyle({
    left: parseInt((document.viewport.getWidth() - $('welcome').getWidth())/2)+'px',
    top: document.viewport.getScrollOffsets().top + parseInt((document.viewport.getHeight() - $('welcome').getHeight())/2)+'px'
  });

  $('shadow2').setStyle({
        width : $('welcome').getWidth()+'px', 
        height: $('welcome').getHeight()+'px',
        left: parseInt((document.viewport.getWidth() - $('welcome').getWidth())/2)+5+'px',
        top: document.viewport.getScrollOffsets().top + parseInt((document.viewport.getHeight() - $('welcome').getHeight())/2)+5+'px'

  });
}

function hideWelcome() {
    $('welcome_container').hide();
    Event.stopObserving(window, 'scroll', fixShadow);
    Event.stopObserving(window, 'resize', fixShadow);
}

// ÐŸÑ€ÐµÐ´Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€ ÐºÐ¾Ð¼Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ñ
function preview(id) {

    if (!$('authorized').visible()) {
        $('login-form-error').update('You must log in to add comments');
        $('login-form-error').up().show();
        login_callback = 'preview('+id+')';
        showForm($('login-form'));
        return;
    }    

    $('preview'+id).down().next().removeClassName('my').innerHTML = '<img src="/pics/ajax-loader.gif" />';
    $('preview'+id).show();
    
    new Ajax.Request('/ajax?action=preview', {
      parameters: { text: $('text'+id).value },
      onSuccess: function(transport) {
        $('preview'+id).down().next().addClassName('my').innerHTML = transport.responseText;
      }  
    });
}

// ÐžÑ‚Ð²ÐµÑ‚ Ð½Ð° ÐºÐ¾Ð¼Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ð¹
function reply(id) {
    if (!$('authorized').visible()) {
        $('login-form-error').update('You must log in to add comments');
        $('login-form-error').up().show();
        login_callback = '$(\'comment'+id+'\').submit()';
        showForm($('login-form'));
        return;
    }
    
    $('comment'+id).submit();
}

var active_form = false;
function showForm(form) {

    if (!form) return;

    showShadow();

    form.setStyle({
        top  : document.viewport.getScrollOffsets().top + parseInt((document.viewport.getHeight() - form.getHeight())/2)+'px',
        left : parseInt((document.viewport.getWidth() - form.getWidth())/2)+'px'
    }).show();
    
    active_form = form;
    
}

function hideForm() {
    if (!active_form) return;
    active_form.hide();
    $('shadow-ex').hide();
    active_form = false;
}

function setBusy(elm) {
    $('busy-box').setStyle({
        width : elm.getWidth()-2+'px', 
        height: elm.getHeight()-2+'px',
        left: elm.cumulativeOffset().left+1+'px',
        top: elm.cumulativeOffset().top+1+'px'
    }).show();
}

function showShadow() {
    $('shadow-ex').setStyle({
        width : document.viewport.getWidth()+document.viewport.getScrollOffsets().left+'px', 
        height: document.body.getHeight()+'px'
    }).setOpacity(0.4).show();
}

var login_callback = '';

// Ð’Ñ‹Ð¿Ð¾Ð»Ð½Ð¸Ñ‚ÑŒ Ð°Ð²Ñ‚Ð¾Ñ€Ð¸Ð·Ð°Ñ†Ð¸ÑŽ
function doLogin(event) {

    Event.stop(event);
    
    $('login-form-error').up().hide();
    setBusy($('login-form'));
    
    new Ajax.Request('/ajax?action=login', {
      parameters: $('login-form-form').serialize(true),
      onSuccess: function(transport) {
        $('busy-box').hide();
        $('login-form').hide();
        $('shadow-ex').hide();
        $('no-auth').hide();
        $('authorized').show();
        if (login_callback) {
            eval(login_callback);
            login_callback = '';
        } else {
            location.reload();
        }
      },
      onFailure: function(transport) {
        $('login-form-error').update(transport.responseText);
        $('login-form-error').up().show();
        $('busy-box').hide();
      }
    });

}

// ÐÐ°Ð¿Ð¾Ð¼Ð½Ð¸Ñ‚ÑŒ Ð¿Ð°Ñ€Ð¾Ð»ÑŒ
function doRecoverPassword(event) {
    Event.stop(event);
    
    $('password-form-error').up().hide();
    setBusy($('password-form'));
    
    new Ajax.Request('/ajax?action=recover', {
      parameters: $('password-form-form').serialize(true),
      onSuccess: function(transport) {
        $('busy-box').hide();
        $('password-form-form').hide();
        $('password-form-form').previous().update(transport.responseText).show();
        $('password-form-form').previous(2).hide();
      },
      onFailure: function(transport) {
        $('password-form-error').update(transport.responseText);
        $('password-form-error').up().show();
        $('busy-box').hide();
      }
    });
}

function voteUp(event) {
    Event.stop(event);
    var element = Event.findElement(event, 'A');
    doVote(element.id.substr(6),'up');
}

function voteDown(event) {
    Event.stop(event);
    var element = Event.findElement(event, 'A');
    doVote(element.id.substr(8),'down');
}

function doVote(id, action) {

    if (!$('authorized').visible()) {
        $('login-form-error').update('You must log in to vote for comments');
        $('login-form-error').up().show();
        login_callback = 'doVote(\''+id+'\', \''+action+'\')';
        showForm($('login-form'));
        return;
    }

    $('voteup'+id).stopObserving('click', voteDown).stopObserving('mouseover', voteOver).stopObserving('mouseout', voteOut).observe('click', stopEvent);
    $('votedown'+id).stopObserving('click', voteDown).stopObserving('mouseover', voteOver).stopObserving('mouseout', voteOut).observe('click', stopEvent);
    $('vote'+action+id).className = 'loading';
    new Ajax.Request('/ajax?action=vote'+action+'&id='+id, {
      onSuccess: function(transport) {
        $('vote'+action+id).className = 'vote-'+action+'2';
        $('vote'+action+id).next().update(transport.responseText);
      }
    });
}

function stopEvent(event) {
    Event.stop(event);
}

function voteOver(event) {
    var element = Event.findElement(event, 'A');
    element.className = element.className + '2';
}

function voteOut(event) {
    var element = Event.findElement(event, 'A');
    element.className = element.className.substr(0, element.className.length-1);
}

Event.observe(window, 'keypress', function(event) { 
    if (event.keyCode == Event.KEY_ESC) hideForm();
});

Event.observe(window, 'load', function() { 

    // Ð“Ð¾Ð»Ð¾ÑÐ¾Ð²Ð°Ð½Ð¸Ðµ Ð·Ð° ÐºÐ¾Ð¼ÐµÐ½Ñ‚Ð°Ñ€Ð¸Ð¸
    $$('a.vote-down').each(function(s) {
        s.observe('click', voteDown).observe('mouseover', voteOver).observe('mouseout', voteOut);
    });
    $$('a.vote-up').each(function(s) {
        s.observe('click', voteUp).observe('mouseover', voteOver).observe('mouseout', voteOut);
    });

    // ÐÐ²Ñ‚Ð¾Ñ€Ð¸Ð·Ð°Ñ†Ð¸Ñ
    if ($('login-button')) {
        $('login-button').observe('click', function(event) {
            $('login-form-error').up().hide();
            showForm($('login-form'));
            login_callback = '';
            Event.stop(event);
        });
        $('login-form-form').observe('submit', doLogin);
        
        $('login-form-close').observe('click', function(event) {
            $('login-form').hide();
            $('shadow-ex').hide();
            Event.stop(event);
        });
    }

    // ÐÐ°Ð¿Ð¾Ð¼Ð½Ð¸Ñ‚ÑŒ Ð¿Ð°Ñ€Ð¾Ð»ÑŒ  
    $$('.password-button').each(function(s) {
        s.observe('click', function(event) {
            $('password-form-form').show();
            $('password-form-form').previous().hide();
            $('password-form-form').previous(2).show();
            hideForm();
            showForm($('password-form'));
            Event.stop(event);
        });
    });
	if ($('password-form-close'))
	    $('password-form-close').observe('click', function(event) {
	        $('password-form').hide();
	        $('shadow-ex').hide();
	        Event.stop(event);
	    });
	if ($('password-form-form'))
    	$('password-form-form').observe('submit', doRecoverPassword);


    // Welcome banner
    if ($('welcome_container')) {
    
      $('shadow').setOpacity(0.4); 
      $('shadow2').setOpacity(0.5); 
      
      Event.observe(window, 'scroll', fixShadow);
      Event.observe(window, 'resize', fixShadow);
    
      Event.observe($('shadow'), 'click', hideWelcome);
      Event.observe($('skip'), 'click', hideWelcome);
      
      $('welcome_container').show();
      fixShadow();
      
      var hide = parseInt($('shadow2').innerHTML);
      if (!isNaN(hide) && hide) setTimeout('hideWelcome()', hide*1000);
    }
    
    if ($('ess_container')) $('ess_container').show();
    
    $$('.essentials .container .no').each(function(s) {
        s.observe('click', function(event) {
            var element = Event.element(event); 
            var a = element.id.split('_');
            ess_activate(a[1]);
            Event.stop(event);
        });
    });
    
    if ($$('.essentials .container .no')[0]) {
        var no = $$('.essentials .container .no')[0];
        var a = no.id.split('_');
        ess_id = a[1];
        ess_activate(ess_id);
    }
    
    $$('.gallery .item').each(function(s) {
        s.observe('mouseover', function(event) {
            var element = Event.findElement(event, 'DIV'); 
            if (element == gprev) return;
            if (gprev) gprev.removeClassName('active');
            element.addClassName('active');
            gprev = element;
            Event.stop(event);
        });
    });
            
});

var ess_id, gprev, ess_interval;

function ess_activate(id) {
    if (ess_id != id) {
		var old_ess = ess_id;
        $('content_'+ess_id).fade({ 
			duration: 0.3, 
			queue: 'end', 
			limit:1, 
			afterFinish: function() {
				$('no_'+old_ess).removeClassName('active');
			} 
		});
    }

    $('content_'+id).appear({ 
		duration: 0.3, 
		queue: 'end', 
		limit:1,
		afterSetup: function() {
			$('no_'+id).addClassName('active');
			$('pic_'+id).setStyle({
				height: (270-$('short_'+id).getHeight()) + 'px'
			});
		} 
	});
	
	ess_id = id;
    clearTimeout(ess_interval);
    ess_interval = setTimeout('changeESS()', 15000);
}

function changeESS() {
    var no = $$('.essentials .container .active')[0].next();
    if (!no) no = $$('.essentials .container .no')[0];
    var a = no.id.split('_');
    ess_activate(a[1]);
}
