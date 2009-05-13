function process(val) {
	getval = 'ref='+encodeURIComponent(document.referrer)+'&page='+encodeURIComponent(location.href)+'&site_id='+val+'&browser='+encodeURIComponent(navigator.appName)+'&b_version='+encodeURIComponent(navigator.appVersion);
	//alert(getval);
	document.write('<img src="http://www.10000projects.info/traffic/process.php?'+getval+'">');
}
process(mkgxyCode);