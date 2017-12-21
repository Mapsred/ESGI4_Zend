$(document).ready(function () {
    DateHelper.datepicker($(".date_picker"));

});
var DateHelper = {
    datepicker: function (object) {
        $(object).datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            language: "fr",
            clearBtn: true,
            autoclose: true,
            todayHighlight: true
        });
    }
};