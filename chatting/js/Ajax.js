//----------------------------------------------
//Ajax v1.0 Source By Bermann
//dobermann75@gmail.com
//----------------------------------------------

function Ajax(Method,Url,Async,Type,Params,userAction)
{
	this.Req;
	this.Method = Method;
	this.Url = Url;
	this.Async = Async;
	this.Type = Type;
	this.Params = Params;
	this.userAction = userAction;
	this.Result = null;
	this.initialize();
	this.execute();
}

Ajax.prototype =
{
	initialize: function () {
		if (window.ActiveXObject) {
			try {
				this.Req = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					this.Req = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e1) {
					return null;
				}
			}
		} else if (window.XMLHttpRequest) {
			try {
				this.Req = new XMLHttpRequest();
			} catch (e) {
				return null;
			}
		}
	},
	callBack: function () {
		if (this.Req.readyState == 4) {
			if (this.Req.status == 200) {
				if (this.Type == "TEXT") {
					this.Result = this.Req.responseText;
				} else if (this.Type == "XML") {
					this.Result = this.Req.responseXML;
				}
				if (typeof this.userAction == "function") { this.userAction(); }
			} else {
				this.Result = this.Req.statusText;
			}
		} else {
			this.Result = "LOADING...";
		}
	},
	execute: function () {
		var This = this;
		this.Req.onreadystatechange = function () { This.callBack(); };
		this.Method = (this.Method != "POST" && this.Method != "GET") ? "GET" : this.Method;
		this.Url = (this.Method == "GET" && this.Params) ? this.Url + "?" + encodeURI(this.Params) : this.Url;
		this.Async = (this.Async != true && this.Async != false) ? true : this.Async;
		this.Type = (this.Type != "TEXT" && this.Type != "XML") ? "TEXT" : this.Type;
		this.Params = (this.Method == "POST") ? this.Params : "''";
		try {
			this.Req.open(this.Method,this.Url,this.Async);
			if (this.Method == "POST") this.Req.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			this.Req.send(this.Params);
		} catch (e) {}
	}
}
