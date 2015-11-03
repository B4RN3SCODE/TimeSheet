/*
 * ts
 * javascript for timesheet application
 *
 * @author			Tyler Barnes
 * @author			Chris Schaefer
 * @contact			tbarnes@arbsol.com
 * @contact			cschaefer@arbsol.com
 * @version			1.0
 */

// strict mode
'use strict';

var urlPrefix = window.location.protocol + '//' + window.location.host;
var root_dir = '/';
var debug = true;

function Debug_Print(text) {
    if(debug) {
        console.log(text);
    }
}
function Error_Output(xhr, status, errorThrown) {
    if(debug) {
        alert( "Sorry, there was a problem!" );
        console.log( "Error: " + errorThrown );
        console.log( "Status: " + status );
        console.dir( xhr );
    }
}
function LoadSelect(form_name,select_name,data) {
    $.each(data, function(key, value) {
        $('form[name="' + form_name + '"] select[name="' + select_name + '"]').append($("<option/>", {
            value: key, text: value
        }));
    });
}

function GetClientById(form_name,ClientId) {
    Debug_Print("GetClientById(" + ClientId + ")")
    var url = urlPrefix + root_dir + 'TimeSheet/Admin/GetClientById';
    var data = { ClientId: ClientId};
    jQuery.ajax({
        url: url, data: data, type: "POST", dataType: "json",
        success: function(data) {
            $.each(data, function(key, value) {
                $('form[name="' + form_name + '"] [name="' + key + '"]').val(value);
            });
        },
        error: function( xhr, status, errorThrown ) {
            Error_Output(xhr, status, errorThrown);
        }
    });
}

function GetProjectById(form_name,ProjectId) {
    Debug_Print("GetProjectById(" + ProjectId + ")")
    var url = urlPrefix + root_dir + 'TimeSheet/Admin/GetProjectById';
    var data = { ProjectId: ProjectId};
    jQuery.ajax({
        url: url, data: data, type: "POST", dataType: "json",
        success: function(data) {
            $.each(data, function(key, value) {
                $('form[name="' + form_name + '"] input[name="' + key + '"]').val(value);
            });
        },
        error: function( xhr, status, errorThrown ) {
            Error_Output(xhr, status, errorThrown);
        }
    });
}

function GetProjectsByClient(form_name,select_name,ClientId) {
    Debug_Print("GetProjectsByClient(" + form_name + "," + select_name + "," + ClientId + ")")
    var url = urlPrefix + root_dir + 'User/Home/GetProjectsByClient';
    var data = { ClientId: ClientId };
    jQuery.ajax({
        url: url, data: data, type: "POST", dataType: "json",
        success: function(data) {
            LoadSelect(form_name,select_name,data);
        },
        error: function( xhr, status, errorThrown ) {
            Error_Output(xhr, status, errorThrown);
        }
    });
}

function ShowSelectedClientsProjectList(ClientName) {
    $("#client-list .panel-collapse").removeClass("in");
    $("#client-list .panel .panel-title a.list-group-item").each(function () {
        var label = $(this).text().substr(0,$(this).text().length - $(this).children("span").text().length);
        if (label != ClientName) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });
    $('#client-list .panel-title a.list-group-item:visible').click();
}

function initialize() {
    $('form[name="timesheet-settings"] select[name="default-client"]').on('change', function(event) {
        $('form[name="timesheet-settings"] select[name="default-project"] option:not(:first)').remove();
        GetProjectsByClient('timesheet-settings','default-project',event.target.selectedIndex);
        if(event.target.selectedIndex !== 0) $('form[name="timesheet-settings"] select[name="default-project"]').focus();
    });
    $('form[name="timesheet"] select[name="client"]').on('change', function(event) {
        $('form[name="timesheet"] select[name="project"] option:not(:first)').remove();
        GetProjectsByClient('timesheet','project',event.target.selectedIndex);
        if(event.target.selectedIndex !== 0) $('form[name="timesheet"] select[name="project"]').focus();
    });
    $('[id^=client] [data-edit-id]').on('click', function() {
        GetProjectById('editproject',$(this).attr('data-edit-id'));
        $('#modal-editproject').modal('show');
    });
    $('[id^=client] [data-del-id]').on('click', function() {
        $('form[name="delproject"] input[name="id"]').val($(this).attr('data-del-id'));
        $('#modal-delproject').modal('show');
    });
    $('[id^=client] [data-edit-client]').on('click', function(event) {
        event.stopPropagation();
        event.preventDefault();
        GetClientById('editclient',$(this).attr('data-edit-client'));
        $('#modal-editclient').modal('show');
    });
}

function validate_add_client(form) {
    return false;
}

$(document).ready(initialize);

/*
 * Timesheet Admin Initialization
 */
$(function() {
    var availableTags = [];
    $("#client-list .panel .panel-title a.list-group-item").each(function () {
        var label = $(this).text().substr(0, $(this).text().length - $(this).children("span").text().length);
        availableTags.push({'label': label}); //, 'value' : $(this).parent().attr('id') });
    });
    $("#search-box").autocomplete({
        source: availableTags,
        select: function (event, ui) {
            $("#client-list .panel-collapse").removeClass("in");
            $("#client-list .panel .panel-title a.list-group-item").each(function () {
                var label = $(this).text().substr(0, $(this).text().length - $(this).children("span").text().length);
                if (label != ui.item.label) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            $('#client-list .panel-title a.list-group-item:visible').click();
        }
    });
    $("#search-box").keyup(function () {
        if ($(this).val().length < 1) {
            $("#client-list .panel .panel-title a.list-group-item").each(function () {
                $(this).show();
            });
            $("#client-list .panel-collapse").removeClass("in");
        }
    });

    $(".list-group-item input[name='name'],.list-group-item input[name='rate']").on("keyup", function () {
        var button = $(this.form).find('button')[0];
        if (this.form.name.value.trim().length > 0 && this.form.rate.value.trim().length > 0) {
            $(button).removeAttr('disabled');
        } else {
            $(button).attr('disabled', 'disabled');
        }
    });
});