"use strict";

$(document).ready(function () {
    var activeTab = $('#activeTab').val();
    var activeTabInt = parseInt(activeTab);
    $("#baseDataDetailTabs").tabs({active: activeTabInt});

    $(".shiftHours").each(function (index, Element) {
        var divParts = Element.id.split('_');
        var siteId = divParts[1];
        var dayOfWeek = divParts[2];
        var onTime = $("#" + siteId + '_on_' + dayOfWeek).val();
        var offTime = $("#" + siteId + '_off_' + dayOfWeek).val();
        onTime = onTime / 60;
        offTime = offTime / 60;
        var shiftTime = 0;
        if (offTime > onTime) {
            shiftTime = offTime - onTime;
        } else if (offTime === onTime) {
            shiftTime = 0;
        } else {
            shiftTime = (offTime + 24) - onTime;
        }
        Element.innerHTML = shiftTime;
        calculateDailyTotals(dayOfWeek);
    });

    $("#divContractEditConfirmFinalise:ui-dialog").dialog("destroy");
    $("#divContractEditConfirmFinalise").dialog({
        autoOpen: false,
        closeOnEscape: false,
        dialogClass: 'no-close',
        width: 560,
        modal: true
    });

    $("#Site_PersonnelExclusionEditDiv:ui-dialog").dialog("destroy");
    $("#Site_PersonnelExclusionEditDiv").dialog({
        autoOpen: false,
        closeOnEscape: false,
        height: 500,
        width: 600,
        modal: true,
        buttons: {
            Submit: function () {
                Site_PersonnelExclusionEditDivSubmitOnClick();
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });

    baseDataDetailTab_OnClick(activeTabInt);

});

/**
 * Set the Session to remember the new active tab and update the child div is nessassary
 * @param {int} tabNo
 * @returns {undefined}
 */
function baseDataDetailTab_OnClick(tabNo) {
    $('#activeTab').val(tabNo);
    setSessionValue('DETAILACTIVETAB', tabNo);
    var siteId = $('#siteId').val();
    if (tabNo == 4) {
        ShiftHours_ContractId_OnChange(siteId);
    }
    if (tabNo == 5) {
        $('#personnelExclusion_SiteId').val(siteId);
        drawSite_PersonnelExclusionDiv_Overview(siteId);
    }
}//baseDataDetailTab_OnClick()

/**
 * Site[Hours]
 * Add up all the ShiftHours of the passed DayOfWeek and update the relevent total div
 * @param {int} dayOfWeek
 * @returns {undefined}
 */
function calculateDailyTotals(dayOfWeek) {
    var shiftTime = 0
    $('.shiftHours').each(function (index, Element) {
        var divParts = Element.id.split('_');
        var ldayOfWeek = divParts[2];
        if (ldayOfWeek === dayOfWeek) {
            shiftTime = shiftTime + parseInt(Element.innerHTML);
        }
    });
    $('#dayHours_' + dayOfWeek).html(shiftTime);
}//calculateDailyTotals()

/**
 * Site[Hours]
 * Update the shift hours div for the passed ShiftId and DayOfWeek
 * @param {int} shiftId
 * @param {int} dayOfWeek
 * @returns {undefined}
 */
function hourDropDownChange(shiftId, dayOfWeek) {
    var onTime = $("#" + shiftId + '_on_' + dayOfWeek).val();
    var offTime = $("#" + shiftId + '_off_' + dayOfWeek).val();
    onTime = onTime / 60;
    offTime = offTime / 60;
    var shiftTime = 0;
    if (offTime > onTime) {
        shiftTime = offTime - onTime;
    } else if (offTime === onTime) {
        shiftTime = 0;
    } else {
        shiftTime = (offTime + 24) - onTime;
    }
    $("#shiftHours_" + shiftId + "_" + dayOfWeek).html(shiftTime);
    calculateDailyTotals(dayOfWeek);
}//hourDropDownChange()

/**
 * Site[Hours]
 * Ajax in the default Shift start and end times and then update all the dropdowns and hours divs
 * @param {int} shiftId
 * @returns {undefined}
 */
function setShiftDefault(shiftId) {
    var onPrefix = shiftId + '_on_';
    var offPrefix = shiftId + '_off_';
    var defaultSiteShiftString = sendAjaxRequest("AjaxPages/getShiftDefaultTimes", "ShiftId=" + shiftId, true);
    var defaultTimesArray = defaultSiteShiftString.trim().split("|");
    var startTime = defaultTimesArray[0];

    startTime = startTime.replace("StartTime=", "");
    var endTime = defaultTimesArray[1];
    endTime = endTime.replace("EndTime=", "");

    $('[id^=' + onPrefix + ']').each(function (index, Element) {
        var elementId = Element.id
        var nameParts = elementId.split('_');
        var dayOfWeek = nameParts[2];
        $('#' + elementId).val(startTime);
        hourDropDownChange(shiftId, dayOfWeek)
    });

    $('[id^=' + offPrefix + ']').each(function (index, Element) {
        var elementId = Element.id
        var nameParts = elementId.split('_');
        var dayOfWeek = nameParts[2];
        $('#' + elementId).val(endTime);
        hourDropDownChange(shiftId, dayOfWeek)
    });
}//setShiftDefault()

/**
 * Site[Contract]
 * Update contractEdit_BookingPeriod so that it is picked up Contract->populateFromForm()
 * @returns {undefined}
 */
function btnContractEditSaveOnClick() {
    $('#divContractEditConfirmFinalise').dialog('open');
    $('#contractEdit_StartDate').html($('#newContract_startDate').val());
    $('#contractEdit_EndDate').html($('#newContract_endDate').val());
    var bookingPeriod = $('#newContract_period:checked').val();
    var bookingPeriodText = '';
    if (bookingPeriod === '1') {
        bookingPeriodText = 'Daily';
    } else if (bookingPeriod === '2') {
        bookingPeriodText = 'Weekly';
    } else {
        bookingPeriodText = 'Unknown period: ' + bookingPeriod;
    }
    $('#contractEdit_BookingPeriod').html(bookingPeriodText);
}//btnContractEditSaveOnClick()

/**
 * Send the ajax request to update the Contract in a Finalised state
 * @param {int} siteId
 * @returns {undefined}
 */
function btnContractEdit_YesOnClick(siteId) {
    var params = {};
    params.functionName = 'btnContractEdit_YesOnClick';
    params.contractId = $('#EditContractId').val();
    params.siteId = siteId;
    params.contractNumber = $('#newContract_contractNumber').val();
    params.startDate = $('#newContract_startDate').val();
    params.endDate = $('#newContract_endDate').val();
    params.clientName = $('#newContract_clientName').val();
    params.clientNumber = $('#newContract_clientNumber').val();
    //Have to get the value from tinyMce since it has not updated the original <textarea>
    var newContract_contractDescription = tinymce.get('newContract_contractDescription').getContent();
    params.contractDescription = newContract_contractDescription;
    params.contractAmount = $('#newContract_contractAmount').val();
    params.period = $('#newContract_period:checked').val();
    params.finalised = 'true';
    params.isPermanent = $('#newContract_isPermanent:checked').val();
    params.active = $('#newContract_active').prop('checked');
    params.randomNumber = Math.random().toString();
    $.ajaxSetup({async: false});
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            var responseTextArray = responseTextTrimmed.split('|');
            if (responseTextArray[0] === 'Ok') {
                $('#frmMain').submit();
            } else {
                alertBox('ERROR: ' + responseTextTrimmed);
            }
        });
}//btnContractEdit_YesOnClick()

/**
 * Send the ajax request to update the Contract in an Unfinalised state
 * @param {int} siteId
 * @returns {undefined}
 */
function btnContractEdit_NoOnClick(siteId) {
    var params = {};
    params.functionName = 'btnContractEdit_NoOnClick';
    params.contractId = $('#EditContractId').val();
    params.siteId = siteId;
    params.contractNumber = $('#newContract_contractNumber').val();
    params.startDate = $('#newContract_startDate').val();
    params.endDate = $('#newContract_endDate').val();
    params.clientName = $('#newContract_clientName').val();
    params.clientNumber = $('#newContract_clientNumber').val();
    params.contractDescription = $('#newContract_contractDescription').val();
    params.contractAmount = $('#newContract_contractAmount').val();
    params.period = $('#newContract_period:checked').val();
    params.finalised = 'false';
    params.isPermanent = $('#newContract_isPermanent:checked').val();
    params.active = $('#newContract_active').prop('checked');
    params.randomNumber = Math.random().toString();
    $.ajaxSetup({async: false});
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            var responseTextArray = responseTextTrimmed.split('|');
            if (responseTextArray[0] === 'Ok') {
                $('#frmMain').submit();
            } else {
                alertBox('ERROR: ' + responseTextTrimmed);
            }
        });
}//btnContractEdit_NoOnClick()

/**
 * Close the Contract edit confirm dialog with out saving any changes
 * @returns {undefined}
 */
function btnContractEdit_CancelOnClick() {
    $('#divContractEditConfirmFinalise').dialog('close');
}//btnContractEdit_CancelOnClick()

/**
 * Refresh the Site[Hours] tab when the Contract is changed
 * @param {int} siteId
 * @returns {undefined}
 */
function ShiftHours_ContractId_OnChange(siteId) {
    var contractId = $('#ShiftHours_ContractId').val();
    $('#ShiftHoursContractDiv').html('Loading...');
    var params = {};
    params.functionName = 'ShiftHours_ContractId_OnChange';
    params.contractId = contractId;
    params.siteId = siteId;
    params.randomNumber = Math.random().toString();
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            $('#ShiftHoursContractDiv').html(responseTextTrimmed);
        });
}//ShiftHours_ContractId_OnChange()

/**
 * Send ajax request to save changed to the Shift[Hours] tab
 * @returns {undefined}
 */
function btnShiftHoursSubmit_OnClick() {
    var contractId = $('#ShiftHours_ContractId').val();
    var params = {};
    params.functionName = 'btnShiftHoursSubmit_OnClick';
    params.contractId = contractId;
    params.siteId = $('#siteId').val();
    var onOffTimes = '';
    $(".ShiftHoursSelect").each(function (index, Element) {
        var elementId = Element.id;
        var onOffTime = $('#' + elementId).val();
        onOffTimes = onOffTimes + elementId + '_' + onOffTime + '~';
    });
    params.onOffTimes = onOffTimes;
    params.randomNumber = Math.random().toString();
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            alert(responseTextTrimmed);
        });
}//btnShiftHoursSubmit_OnClick()

/**
 * Ajax in the html for the Site[Exclusions] tab
 * @param {int} siteId
 * @returns {undefined}
 */
function drawSite_PersonnelExclusionDiv_Overview(siteId) {
    if (siteId) {
        $('#Site_PersonnelExclusionDiv').html('Loading...');
        var params = {};
        params.functionName = 'drawSite_PersonnelExclusionDiv_Overview';
        params.siteId = siteId;
        params.randomNumber = Math.random().toString();
        $.post('AjaxPages/baseDataDetail.php', params,
            function (responseText) {
                var responseTextTrimmed = responseText.trim();
                $('#Site_PersonnelExclusionDiv').html(responseTextTrimmed);
            });
    } else {
        $('#Site_PersonnelExclusionDiv').html('Unknon SiteId: ' + siteId);
    }
}//drawSite_PersonnelExclusionDiv_Overview()

/**
 * Popup the Personnel Exclusions edit dialog and ajax in the html
 * @param {int} personnelExclusionId
 * @returns {undefined}
 */
function btnSitePersonnelExclusionEditOnClick(personnelExclusionId) {
    $('#Site_PersonnelExclusionEditDiv').html('Loading...');
    $('#Site_PersonnelExclusionEditDiv').dialog('open');
    var params = {};
    params.functionName = 'drawSite_PersonnelExclusionDiv_Edit';
    params.siteId = $('#personnelExclusion_SiteId').val();
    params.personnelExclusionId = personnelExclusionId;
    params.randomNumber = Math.random().toString();
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            $('#Site_PersonnelExclusionEditDiv').html(responseTextTrimmed);
            makePersonnelSelect2();
            makeDateFieldsDatePickers();
        });
}//btnSitePersonnelExclusionEditOnClick()

/**
 * Site[Personnel Exclusions]
 * Have to manually set up the Personnel select2 dropdown so that it functions as a searchable dropdown correctly
 * @returns {undefined}
 */
function makePersonnelSelect2() {
    $('#newPersonnelExclusion_personnelId').select2({
        dropdownAutoWidth: "true",
        placeholder: "Select a Person",
        minimumInputLength: 2,
        ajax: {
            url: "AjaxPages/baseDataDetail.php",
            dataType: 'html',
            data: function (term, page) {
                return {
                    functionName: 'sitePersonnelExclusionPersonnel',
                    searchPerson: term
                };
            },
            results: function (data, page) {
                var rowsArray = data.split('~');
                var colsArray = [];
                var retArray = [];
                for (var i = 0; i < rowsArray.length - 1; i++) {
                    colsArray = rowsArray[i].split("|");
                    retArray.push({id: colsArray[0], text: colsArray[1]});
                }
                return {results: retArray};
            }
            //
        },//ajax});

        initSelection: function (element, callback) {
            var data = {id: element.val(), text: $('#sitePersonnelExclusionPersonnelDisplayName').val()};
            callback(data);
        }//initSelection
    });//projectId

}//makePersonnelSelect2()

/**
 * Have to force date fields to be jQuery.datePickers if the element if created (ajaxed in) after the page was loaded
 * @returns {undefined}
 */
function makeDateFieldsDatePickers() {
    $('.baseDate').datepicker({
        dateFormat: 'yy-mm-dd'
    });//date picker
}//makeDateFieldsDatePickers()

/**
 * Site[Personnel Exclusions]
 * Popup the new exclusion dialog and ajax in the html contents
 * @param {int} siteId
 * @returns {undefined}
 */
function btnSitePersonnelExclusionNewOnClick(siteId) {
    $('#Site_PersonnelExclusionEditDiv').html('Loading...');
    $('#Site_PersonnelExclusionEditDiv').dialog('open');
    var params = {};
    params.functionName = 'drawSite_PersonnelExclusionDiv_Edit';
    params.siteId = siteId;
    params.personnelExclusionId = '';
    params.randomNumber = Math.random().toString();
    $.post('AjaxPages/baseDataDetail.php', params,
        function (responseText) {
            var responseTextTrimmed = responseText.trim();
            $('#Site_PersonnelExclusionEditDiv').html(responseTextTrimmed);
            makePersonnelSelect2();
            makeDateFieldsDatePickers();
        });
}//btnSitePersonnelExclusionNewOnClick()

/**
 * Validate the new exclusion dialog and then send the request to insert the new exclusion
 * @returns {undefined}
 */
function Site_PersonnelExclusionEditDivSubmitOnClick() {
    var personnelExclusionId = $('#personnelExclusionId').val();
    var siteId = $('#personnelExclusion_SiteId').val();
    var personnelId = $('#newPersonnelExclusion_personnelId').val();
    var incidentTypeId = $('#newPersonnelExclusion_incidentTypeId').val();
    var dateStart = $('#newPersonnelExclusion_dateStart').val();
    if (personnelId) {
        if (incidentTypeId) {
            if (dateStart) {
                var params = {};
                params.functionName = 'Site_PersonnelExclusion_InsertUpdate';
                params.personnelExclusionId = personnelExclusionId;
                params.siteId = siteId;
                params.personnelId = personnelId;
                params.incidentTypeId = incidentTypeId;
                params.dateStart = dateStart;
                params.dateEnd = $('#newPersonnelExclusion_dateEnd').val();
                params.isOnlyWarning = $('#newPersonnelExclusion_isOnlyWarning').prop('checked');
                params.incidentDescription = $('#newPersonnelExclusion_incidentDescription').val();
                params.active = $('#newPersonnelExclusion_active').prop('checked');
                params.randomNumber = Math.random().toString();
                $.post('AjaxPages/baseDataDetail.php', params,
                    function (responseText) {
                        var responseTextTrimmed = responseText.trim();
                        var responseTextArray = responseTextTrimmed.split('|');
                        if (responseTextArray[0] === 'Ok') {
                            $('Site_PersonnelExclusionEditDiv').dialog('close');
                            $('#frmMain').submit();
                        } else {
                            alert(responseTextArray[1]);
                        }
                    });
            } else {
                alert('Date Start is mandatory');
            }
        } else {
            alert('Incident Type is mandatory');
        }
    } else {
        alert('Personnel is mandatory');
    }
}//Site_PersonnelExclusionEditDivSubmitOnClick()

/**
 * Redirect the browser back to the object's overview page
 * objectId will be used to make sure the correct page in the paginator is selected
 * @param {text} action
 * @param {int} objectId
 * @returns {undefined}
 */
function btnBaseDataDetailBackOnClick(action, objectId) {
    window.location = 'default.php?action=' + action;
}//btnBaseDataDetailBackOnClick()
