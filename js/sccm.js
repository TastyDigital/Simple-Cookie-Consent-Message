(function($){
    if ( navigator.cookieEnabled === true && (phpVars.rightContext || document.cookie.indexOf("consented") === -1))
    {
        $('body').append('<div id="cookie"><div id="wrapper"><h2>'+ phpVars.title +'</h2><p>'+ phpVars.message +'</p><div id="close"><a href="#" id="closecookie">'+ phpVars.closeMsg +'</a></div><div style="clear:both"></div></div></div>');
        $('head').append('<style type="text/css">#cookie {position:fixed;left:0;bottom:0;width:100%;height:100%;background:rgb('+ phpVars.backgroundColour +');background:rgba('+ phpVars.backgroundColour +','+ phpVars.backgroundTransparency +');z-index:99999;}#cookie #wrapper {padding:'+ phpVars.padding +'}#cookie h2 {color:'+ phpVars.titleColour +';display:block;font-family:'+ phpVars.titleFont +';font-size:'+ phpVars.titleSize +';width:18%;margin-top:0;margin-right:2%;float:left;text-align:right;}#cookie p {color:'+ phpVars.messageColour +';display:block;font-family:'+ phpVars.messageFont +';font-size:'+ phpVars.messageSize +';width:68%;margin:0 1%;float:left;}#cookie p a {color:'+ phpVars.titleColour +';}#cookie #close{text-align:center;}#closecookie{color:'+ phpVars.closeColour +';font-family:'+ phpVars.closeFont +';font-size:'+ phpVars.closeSize +';text-decoration:none}@media only screen and (min-width: 480px) {#cookie {height:auto;}#cookie #wrapper{max-width:'+ phpVars.maxWidth +';margin-left:auto;margin-right:auto;}#cookie #close{width:9%;float:right;}}</style>');
        $('#cookie').slideDown("fast");
        $('#closecookie').on('click', function(e) {
            e.preventDefault();
            this.blur();
            $('#cookie').slideUp("fast");
            if (phpVars.rightContext){ 
                var date = new Date();
                date.setTime(date.getTime()+(10*365*24*60*60*1000));
                document.cookie='consented=yes; path=/; expires=' + date.toGMTString();
            } 
        });
    }
})(jQuery);
