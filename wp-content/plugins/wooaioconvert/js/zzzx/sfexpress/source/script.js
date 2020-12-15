var bgImageArray = ["https://www.sf-express.com/cn/sc/download/IMG20190905_171924.jpg", "https://s29755.pcdn.co/wp-content/uploads/2018/07/SF_Express_Taiwan_KPA-1063_20180126-1.jpg", "https://www.sf-express.com/cn/sc/download/SF-CN-Logistics-Warehousing-Service-633x255.jpg", "https://www.joc.com/sites/default/files/field_feature_image/SFExpress.jpg", "https://www.sf-express.com/.gallery/gb/index/HP-banner-new-web-en-1349x487.jpg", "https://www.sf-express.com/.gallery/index/PCkuaidifuwu-0213.jpg", "https://www.sf-express.com/.gallery/de/index/HP-banner-SF-Direct-en-1349x487.jpg", "http://www.sf-airlines.com/sfaImage/2019/09/1909100944581164.jpg", "https://www.sf-express.com/.gallery/us/news/IRCE-1.jpg", "https://www.hino.com.hk/sites/default/files/content/photos/share-00-sf-hero.jpg", "https://www.joc.com/sites/default/files/field_feature_image/SF%20Express%20couriers%20loading%20packages%20in%20a%20van-700x464.JPG",],
base = "",
secs = 5;
bgImageArray.forEach(function(img){
    new Image().src = base + img; 
    // caches images, avoiding white flash between background replacements
});

function backgroundSequence() {
	window.clearTimeout();
	var k = 0;
	for (i = 0; i < bgImageArray.length; i++) {
		setTimeout(function(){ 
			document.getElementById('animated-bg').style.background = "url(" + base + bgImageArray[k] + ") no-repeat center center";
			document.getElementById('animated-bg').style.backgroundSize ="cover";
		if ((k + 1) === bgImageArray.length) { setTimeout(function() { backgroundSequence() }, (secs * 1000))} else { k++; }			
		}, (secs * 1000) * i)	
	}
}
backgroundSequence();