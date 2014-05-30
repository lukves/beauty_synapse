//<script type="text/javascript"><!--
var synapse_locale_eng = {
	Login: "Login",
	Logout: "Logout",
	Register: "Register",
	Reply: "Reply",
    Create: "Create Message",
	CreateReply: "Create Reply Message",
	Search: "Search",
	Share: "Share",
	FindFriends: "Find Friends",
	ContactUs: "Contact us",
	MediaManager: "Media Manager",
	Settings: "Settings"
};

var synapse_locale_sk = {
	Login: "Prihlasit",
	Logout: "Odhlasit",
	Register: "Registrovat",
	Reply: "Odpovedať",
    Create: "Vytvor Správu",
	CreateReply: "Zanechať Správu",
	Search: "Hľadať",
	Share: "Zdieľať",
	FindFriends: "Priatelia",
	ContactUs: "Kontaktovat",
	MediaManager: "Manažér Zdrojov",
	Settings: "Nastavenia"
};

function synapse_locale_print(str, choice)
{
    if((str != null)&&(choice != null))
    {
		if (choice=="sk") {
			return synapse_locale_sk[str];
		} else 
		if (choice=="en") {
			return synapse_locale_eng[str];
		}
    }
    // when nothing, then english language..
    return synapse_locale_eng[str];
}

//--></script>
