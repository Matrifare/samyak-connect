function shortlist(e, t) {
    var a = "remove";
    $(e).find("i").hasClass("fa-bookmark-o") ? a = "add" : $(e).find("i").hasClass("fa-bookmark") && (a = "remove");
    var s = "id=" + t + "&type=" + a;
    return $.ajax({
        type: "POST",
        url: "web-services/shortlist_block",
        data: s,
        dataType: "json",
        cache: !1,
        success: function (t) {
            "success" == t.result ? ($(e).find("i").removeClass(t.removeClass).addClass(t.addClass), $(e).find("span.counts-text").html(t.text)) : alert("Bookmark failed")
        }
    }), !1
}

function block(e, t) {
    var a = "unblock";
    $(e).find("i").hasClass("fa-ban") ? a = "block" : $(e).find("i").hasClass("fa-check") && (a = "unblock");
    var s = "id=" + t + "&type=" + a;
    return $.ajax({
        type: "POST",
        url: "web-services/shortlist_block",
        data: s,
        dataType: "json",
        cache: !1,
        success: function (t) {
            "success" == t.result ? ($(e).find("i").removeClass(t.removeClass).addClass(t.addClass), $(e).find("span.counts-text").html(t.text)) : alert("Block Action Failed")
        }
    }), !1
}

function getMessageReply(e) {
    $("#myModal1").html("Please wait..."), $.get("./web-services/compose_message?frmid=" + e, function (e) {
        $("#myModal1").html(e)
    })
}

function getContactDetail(e) {
    $("#myModal2").html("Please wait..."), $.get("./web-services/contact_detail.php?toid=" + e, function (e) {
        $("#myModal2").html(e)
    })
}

function sendGratings(e) {
    $("#myModal3").html("Please wait..."), $.get("./web-services/send_gratings?frmid=" + e, function (e) {
        $("#myModal3").html(e)
    })
}

function ExpressInterest(e, t) {
    if ("No" == t) {
        var a, s,
            o = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
            i = $("#name"), n = $([]).add(i), l = $(".validateTips");

        function r(e) {
            l.text(e).addClass("ui-state-highlight"), setTimeout(function () {
                l.removeClass("ui-state-highlight", 1500)
            }, 500)
        }

        function d(e, t, a, s) {
            return !(e.val().length > s || e.val().length < a) || (e.addClass("ui-state-error"), r("Length of " + t + " must be between " + a + " and " + s + "."), !1)
        }

        function c(e, t, a) {
            return !!t.test(e.val()) || (e.addClass("ui-state-error"), r(a), !1)
        }

        function m() {
            var e = !0;
            return n.removeClass("ui-state-error"), (e = (e = (e = (e = (e = e && d(i, "username", 3, 16)) && d(password, "password", 5, 16)) && c(i, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter.")) && c(email, o, "eg. ui@jquery.com")) && c(password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9")) && ($("#users tbody").append("<tr><td>" + i.val() + "</td><td>" + email.val() + "</td><td>" + password.val() + "</td></tr>"), a.dialog("close")), e
        }

        a = $("#dialog-form").dialog({
            autoOpen: !1, height: 300, width: 300, modal: !0, beforeClose: function () {
                return alert("You have to Verify Mobile Number."), !1
            }, buttons: {
                "Create an account": m, Cancel: function () {
                    a.dialog("close")
                }
            }, close: function () {
                s[0].reset(), n.removeClass("ui-state-error")
            }
        }), s = a.find("form").on("", function (e) {
            e.preventDefault(), m()
        }), a.dialog("open")
    } else $("#myModal1").modal("show"), $("#myModal1").html("Please wait..."), $.get("./web-services/send_interest?frmid=" + e, function (e) {
        $("#myModal1").html(e)
    })
}

function Getphotos(e) {
    $("#myModal5").html("Please wait..."), $.get("./web-services/get_photos?frmid=" + e, function (e) {
        $("#myModal5").html(e)
    })
}

function Gethoro(e) {
    $("#myModal6").html("Please wait..."), $.get("./web-services/get_horoscope?frmid=" + e, function (e) {
        $("#myModal6").html(e)
    })
}

function Getvideo(e) {
    $("#myModal7").html("Please wait..."), $.get("./web-services/get_video?frmid=" + e, function (e) {
        $("#myModal7").html(e)
    })
}

function approveaspaid(e) {
    $("#modal-14").html("Please wait..."), $.get("web-services/approveaspaid?matri_id=" + e + "&status=Renew", function (e) {
        $("#modal-14").html(e)
    })
}

function editplan(e) {
    $("#modal-14").html("Please wait..."), $.get("web-services/edit_paid_plan?matri_id=" + e, function (e) {
        $("#modal-14").html(e)
    })
}

function editplanSearch(e) {
    $("#modal-14").html("Please wait..."), $.get("web-services/edit_paid_plan_search?matri_id=" + e, function (e) {
        $("#modal-14").html(e)
    })
}

function changeMobileVerifyStatus(e, t) {
    $.ajax({
        url: "web-services/change_mobile_verified_status",
        data: {status: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changeEmailVerifyStatus(e, t) {
    $.ajax({
        url: "web-services/change_email_verified_status",
        data: {status: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changeInterestPrivacyStatus(e, t) {
    $.ajax({
        url: "web-services/change_interest_privacy_status",
        data: {status: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changePhotoViewStatus(e, t) {
    $.ajax({
        url: "web-services/change_photo_view_status",
        data: {status: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changeProfileViewStatus(e, t) {
    $.ajax({
        url: "web-services/change_profile_view_status",
        data: {profile_security: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changeViewProfileCondition(e, t) {
    $.ajax({
        url: "web-services/update_profile_view_condition",
        data: {view_profile_condition_security: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function changeExpressInterestCondition(e, t) {
    $.ajax({
        url: "web-services/update_express_interest_condition",
        data: {express_interest_condition_security: $(e).val(), matri_id: t},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function requestPhotoId(e, t) {
    let flag = true;
    if ($(e).val() == 'CancelRequest') {
        flag = confirm("Are you sure you want to cancel the Photo ID request?");
    }
    if ($(e).val() == 'ApproveRequest') {
        flag = confirm("Are you sure you want to approve the Photo ID?\nYou cannot undo this action!");
    }
    if (flag) {
        $.ajax({
            url: "web-services/request_photo_id",
            data: {photo_id_request_status: $(e).val(), matri_id: t},
            error: function () {
            },
            dataType: "html",
            success: function (e) {
                $("body").append(e)
            },
            type: "POST"
        });
    }
}

function registerMelava(context, id, matri_id) {
    var statusReg = "unregister";
    if ($(context).is(':checked')) {
        statusReg = "register";
    }
    $.ajax({
        url: "web-services/register_for_melava",
        data: {status: statusReg, matri_id: matri_id, melava_id: id},
        error: function () {
        },
        dataType: "html",
        success: function (e) {
            $("body").append(e)
        },
        type: "POST"
    })
}

function assurredContact(e) {
    $("#modal-14").html("Please wait..."), $.get("web-services/assurred_contact_search?matri_id=" + e, function (e) {
        $("#modal-14").html(e)
    })
}

function sub_form() {
    $("#MatriForm").submit()
}

function showMelavaForm(e) {
    $("#modal-14").html("Please wait..."),
        $.post("web-services/melava_form", {"matri_id": e},
            function (r) {
                $("#modal-14").html(r);
            });
}

function get_melava(city) {
    $.ajax({
        url: "web-services/get_melava_name",
        data: {"melava_city": city},
        error: function () {
            alert("Oops! Something went wrong");
        },
        dataType: "html",
        success: function (e) {
            $("#melava_name").html(e);
        },
        type: "POST",
        beforeSend: function () {
            $("#melavaDate").val("");
        }
    })
}


function get_melava_date(context) {
    $("#melavaDate").val($(context).find(':selected').data('date'));
    $("#melava_name_real").val($(context).find(':selected').data('name'));
}