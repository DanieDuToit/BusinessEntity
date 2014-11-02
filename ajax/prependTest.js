/**
 * path:       web/js/
 * filename:   prependTest.js
 *
 * @package
 * @author     Robert Steyn
 *
 *
 */
$(document).ready(function () {

    $("#doInsert").click(function () {
        var fieldValue = $("#InputField").val();
        $("#InputField_td").prepend(fieldValue);
    });

    $("#doInsert1").click(function () {
        $("#title h1").html("It Works");
    });

});


