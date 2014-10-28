/**
 * Created by dutoitd1 on 2014/10/28.
 */

var initId;
function setTimer() {
    "use strict";
    return setInterval(startTimer, 100);
}
function startTimer() {
    "use strict";
    $("#Company").change();
    console.log("StartTimer()");
    stopTimer();
}
function stopTimer() {
    "use strict";
    clearInterval(initId);
}
$(document).ready(function () {
    "use strict";
    var displayType = $("#displayType").val();
    var divisionId = $("#divisionId").val();
    $("#Company").change(function () {
        var params = {};
        params.company = $(this).val();
        params.divisionId = divisionId;
        params.displayType = displayType;
        $.get("getDivisionsForCompany.php", params, function (data) {
            $("#Division").html(data);
        });
    });
    console.log("settimer called");
    initId = setTimer();
});

