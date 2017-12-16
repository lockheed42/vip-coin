//const common_url = 'http://127.0.0.1:8020/vip-cion/static' 
//const common_url = 'http://api.vip-coin.com'
const common_url = 'http://apim.yue-me.com'

const mobile_test = /^1\d{10}$/; //手机格式

function jumpTo(name) {
	let jumpUrl = 'http://' + window.location.host + '/vip-cion/pages/'
	if(name) {
		jumpUrl = jumpUrl + name
		window.location.href = jumpUrl
	} else {
		window.history.back();
	}
}

/**
 * 在参数中添加用户身份
 */
function extendToken(params, token) {
	const timestamp = new Date().getTime();
	return token ?
		Object.assign({}, params, {
			_platform: 'Web',
			_timestamp: timestamp,
			api_key: getCookie('api_key'),
			api_security: getCookie('api_security'),
			_version: '1.0'
		}) :
		params
}

function parseParam(param) {
	let middleStr = ''
	for(var Key in param) {
		middleStr = middleStr + '&' + '' + Key + '=' + param[Key] + '';
	}
	return middleStr;
};

function apiGet(url, params = null, token = true) {
	let requestUrl = common_url;
	const paramUrl = '?c=' + url.control + '&a=' + url.action;
	requestUrl = requestUrl + paramUrl;
	console.log(requestUrl);
	return axios({
			method: 'get',
			url: requestUrl,
			params: extendToken(params, token),
			timeout: 30000,
			//			withCredentials: true,
			headers: {
				//				'X-Requested-With': 'XMLHttpRequest',
				//				'Content-Type': 'application/json; charset=UTF-8'
			}
		})
		.then(checkStatus)
		.then(checkCode)
}

function setUrl(item, index) {
	return 'c='
}

/**
 * Post 请求
 *
 * @method post
 * @param  {String}       url              请求地址的 pathname
 * @param  {Object,Null}  [payload=null]   POST 参数
 * @param  {Boolean}      [token=true]     是否需要添加 token 信息
 * @return {Promise}                       Promise] -> [Any]
 */
function apiPost(url, params = null, token = true) {
	let requestUrl = common_url;
	const paramUrl = '?c=' + url.control + '&a=' + url.action;
	requestUrl = requestUrl + paramUrl;
	if(token) {
		const fixedObj = extendToken({}, token);
		const middleStr = parseParam(fixedObj);
		requestUrl = requestUrl + middleStr;
	}
	return axios({
			method: 'post',
			url: requestUrl,
			data: params,
			timeout: 30000,
			//			withCredentials: true,
			headers: {
//				'X-Requested-With': 'XMLHttpRequest',
//				'Content-Type': 'application/json; charset=UTF-8'
//				'Content-Type': ' x-www-form-urlencoded'
			}
		})
		.then(checkStatus)
		.then(checkCode)
}

/**
 * 判断 response 状态
 */
function checkStatus(response) {
	if(!response) {
		return {
			error: '接口异常，请求失败',
			code: 500,
			data: ''
		}
	}
	if((response.status !== 200)) {
		return {
			error: response.statusText || '数据异常，解析失败',
			code: response.status || 400,
			data: ''
		}
	}
	return response.data
}

/**
 * 判断 data 状态
 */
function checkCode(res) {
	if(res.code === 200 && res.data) {
		return res.data
	} else {
		//		alert(res.error)
		console.log(this)
		this.ELEMENT.Message({
			message: res.error,
			type: 'error'
		});
		setTimeout(function () {
			if (res.error === '用户未登录') {
				jumpTo('account/login.html')
			}
		}, 5000);
		//		this.$message({
		//			message: res.error,
		//			type: 'error'
		//		});
		//		const errList = {
		//			460: '您的账号已在其他设备上登录',
		//			461: '登录信息已过期，请重新登录'
		//		}
		//		const err = _.get(errList, res.code)
		//		const msg = err || res.error
		//		if(err || msg === '身份授权错误，请重新进入！') {
		//			store.commit('message/setMsg', msg)
		//			if(process.browser) {
		//				app.$cookie.del('__currentUser')
		//				app.$cookie.del('__loginFlag')
		//			}
		//			redirect('/login')
		//		} else {
		//			showError(msg, res.code)
		//		}
	}
}

/**
 * 显示错误信息
 */
function showError(msg, code = null) {
	if(process.browser) {
		// 浏览器端
		const getRegex = (isGlobal = true) => {
			return new RegExp(/\(\{##(Q\d+)##\}\)/, isGlobal ? 'g' : '')
		}
		if(getRegex(true).test(msg)) {
			msg = msg.replace(getRegex(true), v => {
				const matchNumber = v.match(getRegex(false))[1]
				const topicNumber = _.get(store.state.topicNumbers, matchNumber)
				return topicNumber || matchNumber
			})
		}
		if(!msg) return
		Message({
			message: msg,
			iconClass: 'icon icon-error',
			customClass: 'msg msg-error',
			duration: 2000
		})
	} else {
		// 服务端
		error({
			statusCode: code,
			message: msg
		})
	}
}

function params(key, defaultvalue) {
	if(!window._params) {
		window._params = [];
		var query = document.location.href.split("?");
		if(query.length > 1) {
			query = query[1];
			var paramItems = query.split("&");
			for(var i = 0; i < paramItems.length; i++) {
				var item = paramItems[i].split("=");
				window._params[item[0]] = decodeURIComponent(item[1]);
			}
		}
	}
	return window._params[key] || defaultvalue;
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + expires + '; path=/';
}

function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i].trim();
		if(c.indexOf(name) == 0) return c.substring(name.length, c.length);
	}
	return "";
}

function delCookie(name) {
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if(cval != null)
		document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
}