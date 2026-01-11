/**
 * Created by Manish on 5/12/2018.
 */

function express_interest(type) {
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "express_interest_" + type, //Where to make Ajax calls
        dataType: 'html',
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $("#express_interest_content").html(response);
            if (type == 'sent') {
                interest('#detailTab > li.active > a', 'sent', 'pending');
            } else {
                interest('#detailTab > li.active > a', 'received', 'pending');
            }
            var url = document.location.toString();
            if (url.match('#')) {
                $('.tab-nav a[href="#' + url.split('#')[1] + '"]').click();
            }

            // Change hash for page-reload
            $('.tab-nav a').on('shown.bs.tab', function (e) {
                window.location.hash = e.target.hash;
            })
        }
    });
}

function manage_tabs(context) {
    var isOpen = $(context).find('i').hasClass('fa-folder-open-o');
    if (isOpen) {
        $(context).find('i').removeClass('fa-folder-open-o');
        $(context).find('i').addClass('fa-folder-o');
    } else {
        $(context).find('i').removeClass('fa-folder-o');
        $(context).find('i').addClass('fa-folder-open-o');
    }
}

function interest(context, type, sub_type, page) {
    //manage_tabs(context);
    page = (typeof page === 'undefined') ? '1' : page;
    $.ajax({
        type: "POST", // HTTP method POST or GET
        url: "page-parts/express_interest_" + sub_type, //Where to make Ajax calls
        data: {
            interest_type: type,
            page:page
        },
        dataType: 'html',
        beforeSend: function () {
            $("#countWithExpressInterest").html("");
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

function deleteexprev(id, type) {
    $('#delsentall' + id + '').fadeIn();
    $.ajax({
        url: "web-services/delete_expressinterest",
        type: "POST",
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        data: 'exp_id=' + id + '&del_status='+type,
        cache: false,
        success: function () {
            $('#delsentall' + id + '').fadeOut();
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

function sendReminder(id, type) {
    $.ajax({
        url: "web-services/exp-reminder",
        type: "POST",
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        data: 'exp_id=' + id + '&exp_status='+type,
        cache: false,
        dataType: 'json',
        success: function (response) {
            alert(response.msg);
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
            $('#hold' + expid + '').fadeOut('slow');
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
            $('#hold' + expid + '').fadeOut('slow');
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}

function onHoldInt(expid) {
    $.ajax({
        url: "web-services/exp-accept",
        type: "POST",
        data: "exp_id=" + expid + '&exp_status=hold',
        cache: false,
        beforeSend: function () {
            $("#loader-animation-area").show();
        },
        success: function (response) {
            $('#accept' + expid + '').fadeOut('slow');
            $('#reject' + expid + '').fadeOut('slow');
            $('#hold' + expid + '').fadeOut('slow');
        },
        complete: function () {
            $("#loader-animation-area").hide();
        }
    });
}