(function($){
    if ( navigator.cookieEnabled === true && (phpVars.rightContext || document.cookie.indexOf("consented") === -1))
    {
        $('body').append('<div id="cookie"><div id="wrapper"><h2>'+ phpVars.title +'</h2><p>'+ phpVars.message +'</p><div id="close"><a href="#" id="closecookie">'+ phpVars.closeMsg +'</a></div><div style="clear:both"></div></div></div>');
        $('head').append('<style type="text/css">#cookie {position:fixed;left:0;bottom:0;width:100%;background:rgb('+ phpVars.backgroundColour +');background:rgba('+ phpVars.backgroundColour +','+ phpVars.backgroundTransparency +');z-index:99999;}#cookie #wrapper {padding:'+ phpVars.padding +'}#cookie h2 {color:'+ phpVars.titleColour +';display:block;font-family:'+ phpVars.titleFont +';font-size:'+ phpVars.titleSize +';width:100%;margin-top:0;margin-right:2%;}#cookie p {color:'+ phpVars.messageColour +';display:block;font-family:'+ phpVars.messageFont +';font-size:'+ phpVars.messageSize +';float:left;}#cookie p a {color:'+ phpVars.titleColour +';}#closecookie{color:'+ phpVars.closeColour +';font-family:'+ phpVars.closeFont +';font-size:'+ phpVars.closeSize +';}@media only screen and (min-width: 480px) {#cookie {height:auto;}#cookie #wrapper{max-width:'+ phpVars.maxWidth +';margin-left:auto;margin-right:auto;}}</style>');
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