const common_url = 'http://127.0.0.1:8020/vip-cion/static' 


function jumpTo (name) {
	let jumpUrl = 'http://' + window.location.host + '/vip-cion/pages/'
	if (name) {
		jumpUrl = jumpUrl + name
		window.location.href = jumpUrl
	} else {
		window.history.back();
	}
}
