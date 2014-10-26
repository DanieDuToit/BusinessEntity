/**
 * path:       web/js/
 * filename:   inputClear.js
 *
 * @package    
 * @author     Robert Steyn
 * @version    1.0
 * 
 * 
 */
$(document).ready(function(){
    
    $("body").keydown(function(event){
        var aKey = event.which;
        $("#keys").html(aKey);
    });
    
    $("#clear").click(function(){
        $("input").val("");
    });

});

