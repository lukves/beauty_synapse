
function check_regform() {
if (document.formular.reg_username.value=="") {
alert('Please, enter a login name..');
document.formular.reg_username.focus();
return false;
}
if (document.formular.reg_username.value=="'") {
alert('Please, enter a login name..');
document.formular.reg_username.focus();
return false;
}
if (document.formular.reg_username.value=="(") {
alert('Please, enter a login name..');
document.formular.reg_username.focus();
return false;
}
if (document.formular.reg_username.value==")") {
alert('Please, enter a login name..');
document.formular.reg_username.focus();
return false;
}
if (document.formular.reg_email.value=="") {
alert('Please, enter email..');
document.formular.login_email.focus();
return false;
}
if (document.formular.reg_password.value=="") {
alert('Please, enter a password..');
document.formular.reg_password.focus();
return false;
}
if (document.formular.reg_repassword.value=="") {
alert('Please, enter repassword..');
document.formular.reg_repassword.focus();
return false;
}
if (document.formular.reg_password.value!=document.formular.reg_repassword.value) { 
alert('Password and RePassword must be the equal..');
document.formular.reg_password.focus();
return false;
}
}

function check_loginform() {
if (document.formular.login_username.value=="") {
alert('Please, enter a login name..');
document.formular.login_name.focus();
return false;
}
if (document.formular.login_password.value=="") {
alert('Please, enter a password..');
document.formular.login_password.focus();
return false;
}  
}


function check_messageform() {
if (document.formular.msg_title.value=="") {
alert('Please, enter a TITLE..');
document.formular.msg_title.focus();
return false;
}
if (document.formular.msg_bodytext.value=="") {
alert('Please, enter a BODYTEXT..');
document.formular.msg_bodytext.focus();
return false;
}
 
}

function check_findform() {
if (document.formular.find_input.value=="") {
alert('Please, enter a Find..');
document.formular.find_input.focus();
return false;
}
}

function check_searchform() {
if (document.formular.search_input.value=="") {
alert('Please, enter a Search..');
document.formular.search_input.focus();
return false;
}
}
