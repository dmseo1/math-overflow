function $(Str) { return document.getElementById(Str); }

function $$(Str) { return document.getElementsByName(Str); }

if (window.attachEvent) {
	var addEvent = function (Element,Handle,Action) { return Element.attachEvent(Handle,Action); }
} else if (window.addEventListener) {
	var addEvent = function (Element,Handle,Action) { return Element.addEventListener(Handle.replace(/^on/i,""),Action,false); }
}

function is_Email(Values) {
	if (!Values.length) { return false; }
	//var MailChk = new RegExp("^([0-9a-zA-Z]|_|-)+@([0-9a-zA-Z]|_|-)+(\\.[a-zA-Z]+){1,2}$");
	var MailChk = new RegExp("^([0-9a-zA-Z]|_|-)+@([0-9a-zA-Z]|_|-)+(\\.com|\\.net|\\.org|\\.biz|\\.info|\\.co\\.kr|\\.or\\.kr|\\.pe\\.kr|\\.ne\\.kr|\\.kr|\\.cc|\\.jp|\\.tv|\\.cn)$");
	return MailChk.test(Values);
}

function is_Chinese(Values) {
	if (!Values.length) { return false; }
	var tests = false;
	for (var i = 0; i < Values.length; i++) {
		if (escape(Values.substr(i,1)).substr(0,2) == "%u" && escape(Values.substr(i,1)).substr(2,1) >= 4) {
			tests = true;
		}
	}
	return tests;
}

function windowOpen(urls,thisid,features) {
	window.open(urls,thisid,features);
}
