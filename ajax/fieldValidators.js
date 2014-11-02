/**
 * filename:   fieldValidators.js
 *
 * @package
 * @author     Robert Steyn
 * @version    1.0
 *
 * This javascript is for field validation, these validators are designed to
 * work with the keyup event.
 * fieldValidatorDouble - does validation for a double number
 *    eg: usage <input type="text" id="fieldName" onKeyUp="$().fieldValidatorDouble(event, 'fieldName', 5);" />
 *    An error message is put into element with id = "fieldNameError"
 *    Only the second and third parameters can be changed by the user
 *    The precision ie number of decimal places is the third parameter.
 *
 * fieldValidatorMoney - does validation for a money number ie 2 decimal places
 *    eg: usage <input type="text" id="fieldName" onKeyUp="$().fieldValidatorMoney(event, 'fieldName');" />
 *    An error message is put into element with id = "fieldNameError"
 *
 * fieldValidatorInteger - does validation for a positive integer number
 *    eg: usage <input type="text" id="fieldName" onKeyUp="$().fieldValidatorInteger(event, 'fieldName');" />
 *    An error message is put into element with id = "fieldNameError"
 *
 * fieldValidatorPattern - Checks if there is a repeating patern in the input field
 *    eg: usage <input type="text" id="fieldName" onKeyUp="$().fieldValidatorPattern(event, 'fieldName');" />
 *    if there is it displays it in element with id = "fieldNamePattern"
 */

(function ($) {

    $.fn.fieldValidatorDouble = function (event, name, precision) {
        var aKey = event.keyCode;
        var errorid = name + "Error";
        $("#" + errorid).html("");
        var number = $("#" + name).val();
        if (isNaN(number) || !validkey(aKey, name, false)) {
            $("#" + errorid).html("Not a valid Key " + number.slice(number.length - 1));
            $("#" + name).val(number.slice(0, (number.length - 1)));
        } else {
            if (number.indexOf(".") >= 0) {
                var numPieces = number.split(".");
                if (numPieces[1].length > precision) {
                    $("#" + errorid).html("Precision not correct.");
                    $("#" + name).val(number.slice(0, (number.length - 1)));
                }
            }
        }
    };

    $.fn.fieldValidatorMoney = function (event, name) {
        $().fieldValidatorDouble(event, name, 2);
    };

    $.fn.fieldValidatorInteger = function (event, name) {
        var aKey = event.keyCode;
        var errorid = name + "Error";
        $("#" + errorid).html("");
        var number = $("#" + name).val();
        if (isNaN(number) || !validkey(aKey, name, true)) {
            $("#" + errorid).html("Not a valid Key " + number.slice(number.length - 1));
            $("#" + name).val(number.slice(0, (number.length - 1)));
        }
    };

    /*
     * This funcrtion checks if key is a number or .
     * It also checks for Delete, tabs and Backspace and returns true in those cases.
     * Delete also clears the field.
     * returns true or false. 
     */
    function validkey(aKey, name, aInt) {
        if (aKey == 8 || aKey == 9 || aKey == 16) {
            return true;
        }
        if (aKey == 46) {
            $("#" + name).val("");
            return true;
        }
        if (aKey < 48) {
            return false;
        }
        if (aKey > 57 && aKey < 96) {
            return false;
        }
        if (aKey < 58) {
            return true;
        }
        if (aKey < 106) {
            return true;
        }
        if (aInt) {
            return false;
        }
        if (aKey == 110 || aKey == 190) {
            return true;
        }
        return false;
    };

    $.fn.fieldValidatorPattern = function (event, name) {
        var aKey = event.keyCode;
        if (aKey == 46) {
            $("#" + name).val("");
        }
        var stringToCheck = $("#" + name).val();
        var patternid = name + "Pattern";
        var len = stringToCheck.length,
            paternToCheck = "",
            restOfString = "",
            maxPatLength,
            i;

        if (len != 1) {
            maxPatLength = (len - len % 2) / 2;
            for (i = 1; i <= maxPatLength; i++) {
                /*
                 * First check if repeat possible ie len mod 1 == 0
                 */
                if (len % i == 0) {
                    paternToCheck = stringToCheck.slice(0, i);
                    restOfString = stringToCheck.slice(i);
                    if (doesPatternRepeat(paternToCheck, restOfString)) {
                        $("#" + patternid).html("Pattern Repeated: " + paternToCheck);
                        return;
                        //return paternToCheck;
                    }
                }
            }
        }
        $("#" + patternid).html("");
        //return minPattern;
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
