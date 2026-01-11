/**
 * Created by Manish on 06/27/2018.
 */

/* function view_messages(type) {
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "page-parts/"+type+"_messages", //Where to make Ajax calls
        dataType: 'html',
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $("#messages_content").html(response);
            if (type == 'sent') {
                interest('#detailTab > li.active > a', 'sent', 'pending');
            } else {
                interest('#detailTab > li.active > a', 'received', 'pending');
            }
        }
    });
} */


function view_messages(context, type, page) {
    //manage_tabs(context);
    page = (typeof page === 'undefined') ? '1' : page;
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "page-parts/view_messages", //Where to make Ajax calls
        data: {
            messages_type: type,
            page:page
        },
        dataType: 'html',
        beforeSend: function () {
            $("#countOfMessage").html("");
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $($(context).attr('href')).html(response);
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function delete_message(id, type) {
    $('#deleteBox' + id + '').fadeIn();
    $.ajax({
        url: "web-services/delete_message",
        type: "POST",
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        data: 'msg_id=' + id + '&msg_status='+type,
        cache: false,
        success: function () {
            $('#deleteBox' + id + '').fadeOut();
            /*if ($(".xyz.active").attr("id") == 'sent_all_define') {
             getexpsentdata();
             }
             else if ($(".xyz.active").attr("id") == 'receive_all_define') {
             getexpreceivedata();
             }*/
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function acceptint(expid) {
    $.ajax({
        url: "web-services/exp-accept",
        type: "POST",
        data: "exp_id=" + expid + '&exp_status=accept',
        cache: false,
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $('#accept' + expid + '').fadeOut('slow');
            $('#reject' + expid + '').fadeOut('slow');
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function rejectint(expid) {
    $.ajax({
        url: "web-services/exp-accept",
        type: "POST",
        data: "exp_id=" + expid + '&exp_status=reject',
        cache: false,
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $('#accept' + expid + '').fadeOut('slow');
            $('#reject' + expid + '').fadeOut('slow');
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}