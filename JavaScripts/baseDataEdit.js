"use strict";

$(document).ready(function () {

});

/**
 * Warn the user if they are going to loose unsaved changes
 * @returns {Boolean}
 */
function btnCancelClick() {
    var editFormState = $('#editFormState').val();
    if (editFormState) {
        return confirm('Do you really want to return without saving your changes?');
    } else {
        return true;
    }
}//btnCancelClick()
