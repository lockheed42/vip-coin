//const common_url = 'http://127.0.0.1:8020/vip-cion/static' 
const common_url = 'http://api.vip-coin.com' 


const mobile_test = /^1\d{10}$/;	//手机格式

function jumpTo (name) {
	let jumpUrl = 'http://' + window.location.host + '/vip-cion/pages/'
	if (name) {
		jumpUrl = jumpUrl + name
		window.location.href = jumpUrl
	} else {
		window.history.back();
	}
}

function params(key, defaultvalue) {
	if (!window._params) {
		window._params = [];
		var query = document.location.href.split("?");
		if (query.length > 1) {
			query = query[1];
			var paramItems = query.split("&");
			for (var i = 0; i < paramItems.length; i++) {
				var item = paramItems[i].split("=");
				window._params[item[0]] = decodeURIComponent(item[1]);
			}
		}
	}
	return window._params[key] || defaultvalue;
}

function setCookie(cname, cvalue, exdays){
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires + '; path=/';
}

function getCookie(cname){
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	}
	return "";
}