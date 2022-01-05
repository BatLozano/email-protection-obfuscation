document.addEventListener("DOMContentLoaded", function(event) {
    
    var classname = document.querySelectorAll("[data-empbo]");
	for (var i = 0; i < classname.length; i++) {
        console.log(classname[i]);
		classname[i].addEventListener('click', empbo_open_link, false);
		classname[i].addEventListener('contextmenu', empbo_open_link, false);
    }
    
});

    
var empbo_open_link = function(event) {
    console.log(this);
    var attribute       = this.getAttribute("data-empbo");   

    var chars_encoded   = atob(attribute);
    chars_encoded       = chars_encoded.match(/.{1,2}/g);

    var chars_mt        = []
    chars_encoded.forEach(function(element) {
        chars_mt.push("MT"+element);
    });

    var chars_decoded   = [];
    chars_mt.forEach(function(element) {
        chars_decoded.push(atob(element));
    });

    chars_decoded = chars_decoded.reverse();


    var url = "";
    chars_decoded.forEach(function(element) {
        url += String.fromCharCode(element - empbo_special_number);
    });

    url = "mailto:"+url;
                   
    var newWindow = window.open(url);            

} 