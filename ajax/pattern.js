/**
 * path:       web/js/
 * filename:   pattern.js
 *
 * @package
 * @author     Robert Steyn
 * @version    0.1
 *
 *
 */
$(document).ready(function () {
    $("#pattern").val("");
    $("#pattern").focus();
    //$("body").focus();

    $("body").keydown(function (event) {
        var aKey = event.which;
        if (aKey == 46) {
            $("#clear").click();
        }
        $("#keys").html(event.which);
    });

    $("#clear").click(function () {
        $("#pattern").val("");
    });

});

$(function () {
    var pattern = $("#pattern"),
        minPattern = $("#minPattern");

    pattern.keyup(function () {
        var stc = pattern.val();
        var mp = $().checkRepeatPattern(stc);
        minPattern.html(mp);
    });
});

(function ($) {

    $.fn.checkRepeatPattern = function (stringToCheck) {
        var len = stringToCheck.length,
            minPattern = "",
            paternToCheck = "",
            restOfString = "",
            maxPatLength,
            i;

        if (len != 1) {
            maxPatLength = (len - len % 2) / 2;
            minPattern = "";
            for (i = 1; i <= maxPatLength; i++) {
                /*
                 * First check if repeat possible ie len mod 1 == 0
                 */
                if (len % i == 0) {
                    paternToCheck = stringToCheck.slice(0, i);
                    restOfString = stringToCheck.slice(i);
                    if (doesPatternRepeat(paternToCheck, restOfString)) {
                        return paternToCheck;
                    }
                }
            }
        }
        return minPattern;
    };

    /*
     * This funcrtion checks if pattern p is repeated in string s
     * returns true or false. 
     */
    function doesPatternRepeat(p, s) {
        var lenPattern = p.length;
        do {
            if (p == s.slice(0, lenPattern)) {
                s = s.slice(lenPattern);
                //alert("s=" + s);
            } else {
                return false;
            }
        }
        while (s.length > 0);
        return true;
    };

})(jQuery);

