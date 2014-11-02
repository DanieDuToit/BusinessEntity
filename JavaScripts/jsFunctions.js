"use strict";

$(document).ready(function () {
    $('.baseDate').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function (dateText) {
            if (typeof datePickerOnSelect === 'function') {
                datePickerOnSelect(dateText);
            }
        },
        onClose: function (dateText, callingObject) {
            if (typeof datePickerOnClose === 'function') {
                datePickerOnClose(dateText, callingObject);
            }
        }
    });//date picker

    /*
     * Some of this next section is commented out as it breaks the code.
     * When more functionality is needed from tinymce we can look into adding it.
     */
    tinymce.init({
        selector: "textarea",
        theme: "modern"//,
//    plugins: [
//              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
//              "searchreplace wordcount visualblocks visualchars code fullscreen",
//              "insertdatetime media nonbreaking save table contextmenu directionality",
//              "emoticons template paste textcolor moxiemanager"
//             ],
//    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
//    toolbar2: "print preview | forecolor backcolor emoticons",
//    image_advtab: true
        //,
//    templates: [ {title: 'Test template 1', content: 'Test 1'},
//                 {title: 'Test template 2', content: 'Test 2'}
//               ]
    });//timyMce

    $('.select2').select2({dropdownAutoWidth: "true"});
    //Have to manually set the Title of all the select2 objects because select2 does not copy the title attribute over
    //https://github.com/ivaynberg/select2/issues/642
    $('.select2').each(function () {
        var thisId = this.id;
        var thisTitle = $('#' + thisId).attr('title');
        $('#s2id_' + thisId).attr('title', thisTitle);
    });

    transformTitlesToHelpText();

    var maxHeight = 400;

    /*
     * Menu code. I would like to refactor this so it is less complex and I understand it
     */
    $(function () {
        $('#mlong').parent().hover(function () {
            var $container = $(this);
            $('#bom').css({
                display: "inherit"
            });
            $('#bom2').css({
                display: "inherit"
            });
        });
        $("#nav > li").hover(function () {
            var $container = $(this),
                $list = $container.find("ul"),
                $anchor = $container.find("a"),
                $header = $container.find("#navheader"),
                height = $list.height() * 1,       // make sure there is enough room at the bottom
                multiplier = height / maxHeight;     // needs to move faster if list is taller

            // need to save height here so it can revert on mouseout
            $container.data("origHeight", $container.height());

            // so it can retain it's rollover color all the while the dropdown is open
            $anchor.addClass("hover");
            $header.css({
                backgroundColor: '#efefef'

            });
            // make sure dropdown appears directly below parent list item
            $list
                .show('fast')
                .css({
                    paddingTop: '10px'
                });
            // don't do any animation if list shorter than max
            if (multiplier > 1) {
                $container
                    .css({
                        height: maxHeight,
                        overflow: "hidden"
                    })
                    .mousemove(function (e) {
                        var offset = $container.offset();
                        var relativeY = ((e.pageY - offset.top) * multiplier) - ($container.data("origHeight") * multiplier);
                        if (relativeY > $container.data("origHeight")) {
                            $list.css("top", -relativeY + $container.data("origHeight"));
                        }
                    });
            }
        }, function () {
            var $el = $(this);
            // put things back to normal
            $el
                .height("42px")
                .find("ul")
                .css({
                    top: 0,
                    overflow: "visible"
                })
                .hide('fast')
                .end()
                .find("a")
                .removeClass("hover")
            $header = $el.find("#navheader");
            $header.css({
                backgroundColor: 'transparent'
            });
        });
        // Add down arrow only to menu items with submenus
        $("#nav > li").each(function () {
        });
        $("#mlong").attr("height", '36px');
        $("#mlong").css({
            overflow: "hidden"
        });
    });
});//$(document).ready(function(){

//FRAMEWORK functions - similar to functions.php
////////////////////////////////////////////////

/**
 * Get jQuery to make the title into a cool popup div for the conext help
 * @returns {undefined}
 */
function transformTitlesToHelpText() {
    $('.helpText').tooltip({
        content: function () {
            var element = $(this);
            return element.attr('title');
        }
    });
}//transformTitlesToHelpText()

/**
 * Show a nice jQuery dialog instead of the default alert()
 * @param {text} text
 * @param {text} title
 * @returns {undefined}
 */
function alertBox(text, title) {
    title = typeof title !== 'undefined' ? title : 'The page says:';
    $("#alertDialog").
        dialog({
            title: title,
            modal: true,
            buttons: {
                'OK': function () {
                    $(this).dialog("close");
                }
            }
        });
    $("#alertDialog").html(text);
}//alertBox()

/**
 * Draw out a hidden input
 * @param {text} fieldIdName
 * @param {text} fieldValue
 * @param {boolean} show
 * @returns {html}
 */
function drawHiddenField(fieldIdName, fieldValue, show) {
    var retVal = '';
    var type = show ? "text" : "hidden";
    if (show) {
        retVal = fieldIdName + ':';
    }
    retVal = retVal + '<input type=' + type + ' id=' + fieldIdName + ' name=' + fieldIdName + ' value="' + fieldValue + '">';
    return retVal;
}//drawHiddenField()

/**
 * Ajax in the html for an input field based on the passed params
 * @param {text} fieldIdName
 * @param {text} fieldType
 * @param {text} fieldValue
 * @param {array} fieldParams
 * @param {text} footerText
 * @returns {html}
 */
function drawInputField(fieldIdName, fieldType, fieldValue, fieldParams, footerText) {
    var urlParams = 'functionName=drawInputField';
    urlParams = urlParams + '&fieldIdName=' + encodeURIComponent(fieldIdName);
    urlParams = urlParams + '&fieldType=' + encodeURIComponent(fieldType);
    urlParams = urlParams + '&fieldValue=' + encodeURIComponent(fieldValue);
    urlParams = urlParams + '&fieldParams=' + encodeURIComponent(fieldParams);
    urlParams = urlParams + '&footerText=' + encodeURIComponent(footerText);
    var drawInputFieldString = sendAjaxRequest("AjaxPages/jsfunctionsHelper", urlParams, true);
    return drawInputFieldString;
}//drawInputField()

//CODE GENERATION Functions
////////////////////////////////////////////////
/**
 * Show or hide the Overview stored procedure textarea
 * @param {object:checkbox} overviewCheck
 * @param {text} overviewDivIdName
 * @returns {undefined}
 */
function cgOverviewCheckOnClick(overviewCheck, overviewDivIdName) {
    if (overviewCheck.checked == 1) {//Don't care if it is a sting or integer
        document.getElementById(overviewDivIdName).style.display = 'block';
    } else {
        document.getElementById(overviewDivIdName).style.display = 'none';
    }
}//cgOverviewCheckOnClick()

/**
 * Show or hide the Insert stored procedure textarea
 * @param {object:checkbox} insertCheck
 * @param {text} insertDivIdName
 * @returns {undefined}
 */
function cgInsertCheckOnClick(insertCheck, insertDivIdName) {
    if (insertCheck.checked == 1) {//Don't care if it is a sting or integer
        document.getElementById(insertDivIdName).style.display = 'block';
    } else {
        document.getElementById(insertDivIdName).style.display = 'none';
    }
}//cgInsertCheckOnClick()

/**
 * Show or hide the Update stored procedure textarea
 * @param {object:checkbox} updateCheck
 * @param {text} updateDivIdName
 * @returns {undefined}
 */
function cgUpdateCheckOnClick(updateCheck, updateDivIdName) {
    if (updateCheck.checked == 1) {//Don't care if it is a sting or integer
        document.getElementById(updateDivIdName).style.display = 'block';
    } else {
        document.getElementById(updateDivIdName).style.display = 'none';
    }
}//cgUpdateCheckOnClick()

/**
 * Show or hide the GetById stored procedure textarea
 * @param {object:checkbox} byIdCheck
 * @param {text} byIdDivIdName
 * @returns {undefined}
 */
function cgByIdCheckOnClick(byIdCheck, byIdDivIdName) {
    if (byIdCheck.checked == 1) {//Don't care if it is a sting or integer
        document.getElementById(byIdDivIdName).style.display = 'block';
    } else {
        document.getElementById(byIdDivIdName).style.display = 'none';
    }
}//cgByIdCheckOnClick()

/**
 * Show or hide the php base class textarea
 * @param {object:checkbox} baseClassCheck
 * @param {text} baseClassDivIdName
 * @returns {undefined}
 */
function cgBaseClassCheckOnClick(baseClassCheck, baseClassDivIdName) {
    if (baseClassCheck.checked == 1) {//Don't care if it is a sting or integer
        document.getElementById(baseClassDivIdName).style.display = 'block';
    } else {
        document.getElementById(baseClassDivIdName).style.display = 'none';
    }
}//cgBaseClassCheckOnClick()

/**
 * Moved from baseDataEdit.js to here because it is called from functions.php, so always has to be included
 * Returns the id of the object responsible for changing the state of the baseDataEdit page
 * @param {type} callingField
 * @returns {Boolean}
 */
function editFormStateChange(callingField) {
    if ($('#editFormState').length > 0) {
        $('#editFormState').val(callingField.id);
    }
    return true;
}//editFormStateChange()

/**
 * Keep the actual time field in sync with the two dropdowns
 * @param {text} fieldIdName
 * @returns {undefined}
 */
function updateHiddenMinutes(fieldIdName) {
    var hours = document.getElementById(fieldIdName + 'Hours').value;
    var minutes = document.getElementById(fieldIdName + 'Minutes').value;
    document.getElementById(fieldIdName).value = (parseInt(hours) * 60) + parseInt(minutes);
}//updateHiddenMinutes()

/**
 * Opposite of updateHiddenMinutes(), this will update the two dropdowns if the hidden field is updated programatically
 * @param {text} fieldIdName
 * @param {int} newMinutes
 * @returns {undefined}
 */
function updateVisibleMinutes(fieldIdName, newMinutes) {
    var hours = Math.floor(newMinutes / 60);
    var minutes = newMinutes % 60;
    $('#' + fieldIdName + 'Hours').val(hours);
    $('#' + fieldIdName + 'Minutes').val(minutes);
}//updateVisibleMinutes()

/**
 * check that the Username and Password fields are filled in when clicking Login button
 * @returns {Boolean}
 */
function checkLoginForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    if (!username) {
        alertBox('Username may not be left blank');
        return false;
    }
    if (!password) {
        alertBox('Password may not be left blank');
        return false;
    }
    return true;
}//checkLoginForm()

/**
 * Save the passes set/val into the php Session
 * @param {text} set
 * @param {text} val
 * @param {boolean} continueProcessing
 * @returns {undefined}
 */
function setVal(set, val, continueProcessing) {
    if (set === '') {
        return;
    }
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", "saveOptions.php?set=" + set + "&val=" + val, continueProcessing);
    xmlhttp.send();
}//setVal()

/**
 * Send an ajax request and return the response
 * @param {text} pageName
 * @param {text} paramString
 * @param {boolean} waitForResponse
 * @returns {String|ActiveXObject.responseText}
 */
function sendAjaxRequest(pageName, paramString, waitForResponse) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    waitForResponse = !waitForResponse;
    xmlhttp.open("GET", pageName + ".php?" + paramString, waitForResponse);
    xmlhttp.send();
    var responseText = xmlhttp.responseText;
    return responseText;
}//sendAjaxRequest()

/**
 * returns whether or not the passed object has a value
 * @param {text} fieldIdName
 * @returns {Boolean}
 */
function isFieldEmpty(fieldIdName) {
    if (document.getElementById(fieldIdName).value) {
        return false;
    } else {
        return true;
    }
}//isFieldEmpty()

/**
 * format the passed mintesFromMidnight into hh:mm
 * @param {int} mintesFromMidnight
 * @returns {String}
 */
function formatMinutesFromMidnight(mintesFromMidnight) {
    var hours = Math.floor(mintesFromMidnight / 60);
    hours = '0' + hours;
    hours = hours.substr(-2, 2);
    var minutes = mintesFromMidnight % 60;
    minutes = '0' + minutes;
    minutes = minutes.substr(-2, 2);
    return hours + ':' + minutes;
}//formatMinutesFromMidnight()

/**
 * Set the passed varName php Session variable to the passed varValue
 * @param {text} varName
 * @param {text} varValue
 * @returns {Boolean}
 */
function setSessionValue(varName, varValue) {
    var returnValue = false;
    var params = {};
    params.functionName = 'setSessionValue';
    params.varName = varName;
    params.varValue = varValue;
    params.randomNumber = Math.random().toString();
    $.ajaxSetup({async: false});
    $.post('AjaxPages/jsFunctionsHelper.php', params,
        function (responseText) {
            if (responseText === 'Ok') {
                returnValue = true;
            } else {
                returnValue = false;
            }
        });
    return returnValue;
}

/**
 * Loops though all the mandatory fields and marks them if they are missing a value
 * @returns {Boolean}
 */
function formCheckMandatoryFields() {
    var mandatoryCheck = true;
    $('.mandatoryField').each(function (index, Element) {
        var thisId = this.id;
        //Only check visible fields, delete values otherwise
        if ($('#' + thisId).is(":visible")) {
            var thisValue = $('#' + thisId).val();
            if (!thisValue) {
                mandatoryCheck = false;
                $('#' + thisId).addClass('mandatoryFieldEmpty');
                //Time selector's hour and minute selects
                if ($('#' + thisId).hasClass("hiddenTime")) {
                    $('#' + thisId + 'Hours').addClass('mandatoryFieldEmpty');
                    $('#' + thisId + 'Minutes').addClass('mandatoryFieldEmpty');
                }
            } else {
                $('#' + thisId).removeClass('mandatoryFieldEmpty');
                //Time selector's hour and minute selects
                if ($('#' + thisId).hasClass("hiddenTime")) {
                    $('#' + thisId + 'Hours').removeClass('mandatoryFieldEmpty');
                    $('#' + thisId + 'Minutes').removeClass('mandatoryFieldEmpty');
                }
            }
        } else {
            if ($('#' + thisId).hasClass("hiddenTime")) {
                //Don't delete the hiddenTime field's value
            } else {
                $('#' + thisId).val('');
            }
        }
    });

    return mandatoryCheck;
}


function formRemoveAllMandatoryFlags() {
    $('.mandatoryField').removeClass('mandatoryFieldEmpty');
    //$('.mandatoryField').removeClass('mandatoryFieldEmpty');
    //$('.mandatoryField').removeClass('mandatoryFieldEmpty');
}
