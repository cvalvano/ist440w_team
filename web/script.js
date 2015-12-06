// Parse URL Queries Method
(function($)
{
    $.getQuery = function( query ) {
        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var expr = "[\\?&]"+query+"=([^&#]*)";
        var regex = new RegExp( expr );
        var results = regex.exec( window.location.href );
        if( results !== null ) {console.log(results[1]);
            return results[1];
        } else {
            return false;
        }
    };
})(jQuery);