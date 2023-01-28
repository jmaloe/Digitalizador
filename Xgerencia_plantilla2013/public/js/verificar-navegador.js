// JavaScript Document
function file_exists (url) {
    var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    if (!req) {throw new Error('XMLHttpRequest not supported');}
    req.open('HEAD', url, false);
    req.send(null);
    if (req.status == 200){
        return true;
    }
    return false;
}

var userAgent = navigator.userAgent.toLowerCase();
jQuery.browser = {
    version: (userAgent.match( /.+(?:rv|it|ra|ie|me)[\/: ]([\d.]+)/ ) || [])[1],
    chrome: /chrome/.test( userAgent ),
    safari: /webkit/.test( userAgent ) && !/chrome/.test( userAgent ),
    opera: /opera/.test( userAgent ),
    msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
    mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
};
	//Ejecutamos las condiciones si el fichero existe o no.
$(document).ready(function(){
    jQuery.each(jQuery.browser, 
	
	function(i, val) {
		
		if(file_exists("public/css/diagonaleswebkit.css") ){
            /*if(i=="msie" && jQuery.browser.version.substr(0,3)=="9.0"){
                $('head').append('<link rel="stylesheet" href="public/css/diagonaleswebkit.css" />');				
            }*/
			
			$('head').append('<link rel="stylesheet" href="public/css/diagonaleswebkit.css" />');
			    
        }				
        if(file_exists("public/css/diagonalIE_8.css") ){
            if(i=="msie" && jQuery.browser.version.substr(0,3)=="8.0"){
             $('head').append('<link rel="stylesheet" href="public/css/diagonalIE_8.css" />');				
            }        
            else if(i=="msie" && jQuery.browser.version.substr(0,3)=="7.0"){
              $('head').append('<link rel="stylesheet" href="public/css/app.css" />');
            }
			else if(i=="msie" && jQuery.browser.version.substr(0,3)=="6.0"){
                $('head').append('<link rel="stylesheet" href="public/css/app.css" type="text/css" />');
            }
        }
    });
});	  	  	  	