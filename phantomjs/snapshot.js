var webpage = require('webpage');
var page = webpage.create();
var system = require('system');
var address = 'http://www.hcharts.cn';
var filename = 'tmp.png';

// if (system.args.length === 2) {
//     address = system.args[1];
// } else

if (system.args.length === 3) {
    address = system.args[1];
    filename = system.args[2];
} else {
    console.log("用法：phantomjs snapshot.js url file.png");
}


page.viewportSize = {
    width: 1024,
    height: 800
};
page.clipRect = {
    top: 0,
    left: 0,
    width: 1024,
    height: 800
};
page.settings = {
    javascriptEnabled: false,
    loadImages: true,
    userAgent: 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.31 (KHTML, like Gecko) PhantomJS/19.0'
};

page.open(address, function(status) {
    console.log(address + "\t" + filename);
    if (status === 'fail') {
        console.log('open page fail!');
    } else {
        window.setTimeout(function() {
            page.render('./snapshot/'+filename);
            page.close();
            phantom.exit();
        }, 200);
    }
});