//----------------------------------------------
//Resize v1.0 Source By Bermann
//dobermann75@gmail.com
//----------------------------------------------

//new Resize(ResizableNodeAttributeName , ResizableZoneDistance , ResizableMaxWidth , ResizableMaxHeight , eachResizableNodeDefaultCursorAttributeName);

function Resize(Name,distance,maxWidth,maxHeight,defaultCursor)
{
	this.Name = Name;
	this.distance = distance;
	this.maxWidth = maxWidth;
	this.maxHeight = maxHeight;
	this.defaultCursor = defaultCursor;
	this.resizeMode = false;
	this.element = null;
	this.direction = 0;
	this.saveLeft = 0;
	this.saveTop = 0;
	this.saveWidth = 0;
	this.saveHeight = 0;
	this.Body = document.documentElement;
	if (window.attachEvent) {
		this.addEvent = function (Element,Handle,Action) { return Element.attachEvent(Handle,Action); }
	} else if (window.addEventListener) {
		this.addEvent = function (Element,Handle,Action) { return Element.addEventListener(Handle.replace(/^on/i,""),Action,false); }
	}
	var This = this;
	this.addEvent(this.Body,"onmousedown",function (event) {
		This.element = event.target || event.srcElement;
		if (This.element.getAttribute(This.Name) == "true" && (event.button == 0 || event.button == 1)) {
			This.resizeMode = true;
			This.saveLeft = This.element.offsetLeft;
			This.saveTop = This.element.offsetTop;
			This.saveWidth = This.element.offsetWidth;
			This.saveHeight = This.element.offsetHeight;
		}
	});
	this.addEvent(this.Body,"onmousemove",function (event) {
		var element = event.target || event.srcElement;
		var x = document.documentElement.scrollLeft + document.body.scrollLeft + event.clientX - element.offsetLeft;
		var y = document.documentElement.scrollTop + document.body.scrollTop + event.clientY - element.offsetTop;
		if (element.getAttribute(This.Name) == "true" && This.resizeMode == false) {
			var distance = element.getAttribute(This.distance);
			if (x <= distance && y <= distance) {
				This.direction = 1;
				element.style.cursor = "nw-resize";
			} else if (x >= element.offsetWidth - distance && y <= distance) {
				This.direction = 3;
				element.style.cursor = "ne-resize";
			} else if (x >= element.offsetWidth - distance && y >= element.offsetHeight - distance) {
				This.direction = 5;
				element.style.cursor = "se-resize";
			} else if (x <= distance && y >= element.offsetHeight - distance) {
				This.direction = 7;
				element.style.cursor = "sw-resize";
			} else if (y <= distance) {
				This.direction = 2;
				element.style.cursor = "n-resize";
			} else if (x >= element.offsetWidth - distance) {
				This.direction = 4;
				element.style.cursor = "e-resize";
			} else if (y >= element.offsetHeight - distance) {
				This.direction = 6;
				element.style.cursor = "s-resize";
			} else if (x <= distance) {
				This.direction = 8;
				element.style.cursor = "w-resize";
			} else {
				This.direction = 0;
				element.style.cursor = (element.getAttribute(This.defaultCursor)) ? element.getAttribute(This.defaultCursor) : "default";
			}
		}
		if (This.resizeMode == true && (This.direction >= 1 && This.direction <= 8)) {
			var X = document.documentElement.scrollLeft + document.body.scrollLeft + event.clientX;
			var Y = document.documentElement.scrollTop + document.body.scrollTop + event.clientY;
			var widthFromLeft = ((This.saveLeft - X) + This.saveWidth);
			var widthFromRight = (X - This.element.offsetLeft);
			var heightFromUp = ((This.saveTop - Y) + This.saveHeight);
			var heightFromDown = (Y - This.element.offsetTop);
			var maxWidth = (This.element.getAttribute(This.maxWidth)) ? Number(This.element.getAttribute(This.maxWidth)) : 0;
			var maxHeight = (This.element.getAttribute(This.maxHeight)) ? Number(This.element.getAttribute(This.maxHeight)) : 0;
			var positioning = true;
			if (widthFromLeft < maxWidth) { X = This.saveLeft + (This.saveWidth - maxWidth); widthFromLeft = maxWidth; }
			widthFromRight = (widthFromRight < maxWidth) ? maxWidth : widthFromRight;
			if (heightFromUp < maxHeight) { Y = This.saveTop + (This.saveHeight - maxHeight); heightFromUp = maxHeight; }
			heightFromDown = (heightFromDown < maxHeight) ? maxHeight : heightFromDown;
			switch (This.direction) {
				case 1:
					This.element.style.left = X + "px";
					This.element.style.top = Y + "px";
					This.element.style.width = widthFromLeft + "px";
					This.element.style.height = heightFromUp + "px";
					break;
				case 2:
					This.element.style.top = Y + "px";
					This.element.style.height = heightFromUp + "px";
					break;
				case 3:
					This.element.style.top = Y + "px";
					This.element.style.width = widthFromRight + "px";
					This.element.style.height = heightFromUp + "px";
					break;
				case 4:
					This.element.style.width = widthFromRight + "px";
					break;
				case 5:
					This.element.style.width = widthFromRight + "px";
					This.element.style.height = heightFromDown + "px";
					break;
				case 6:
					This.element.style.height = heightFromDown + "px";
					break;
				case 7:
					This.element.style.left = X + "px";
					This.element.style.width = widthFromLeft + "px";
					This.element.style.height = heightFromDown + "px";
					break;
				case 8:
					This.element.style.left = X + "px";
					This.element.style.width = widthFromLeft + "px";
					break;
				default :;
			}
		}
	});
	this.addEvent(this.Body,"onmouseup",function () {
		This.direction = 0;
		This.saveLeft = 0;
		This.saveTop = 0;
		This.saveWidth = 0;
		This.saveHeight = 0;
		This.resizeMode = false;
	});
}