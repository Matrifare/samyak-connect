<?php 
/**
 * Secure Chat Module
 * Uses prepared statements for all database queries
 */
include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();

// Validate session
if (!isset($_SESSION['uid']) || !isset($_SESSION['user_id'])) {
    header('Location: login');
    exit;
}

$_SESSION['chatuser'] = $_SESSION['uid'];
$indexid = $_SESSION['uid'];
$_SESSION['chatuser_name'] = $_SESSION['uname'] ?? '';
$chat_user = $_SESSION['chatuser'];

// Use prepared statement for status query
$stmt = $DatabaseCo->dbLink->prepare("SELECT status FROM register WHERE matri_id = ?");
$userId = $_SESSION['user_id'];
$stmt->bind_param("s", $userId);
$stmt->execute();
$statusResult = $stmt->get_result();
$row = $statusResult->fetch_array();
$stmt->close();

$a = 'male_small.png'; // Default photo

if ($_SESSION['uid']) {
    // Use prepared statement for user photo query
    $stmt = $DatabaseCo->dbLink->prepare("SELECT photo1, gender FROM register WHERE index_id = ?");
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $photoResult = $stmt->get_result();
    $fetch = $photoResult->fetch_array();
    $stmt->close();

    if ($fetch) {
        if (empty($fetch['photo1'])) {
            $a = ($fetch['gender'] == 'Groom') ? 'male_small.png' : 'female_small.png';
        } else {
            $a = htmlspecialchars($fetch['photo1'], ENT_QUOTES, 'UTF-8');
        }
    }
}
?>

<link type="text/css" rel="stylesheet" media="all" href="css/chat.css"/>

<script type="text/javascript">

    var windowFocus = true;
    var username = "me";
    var chatHeartbeatCount = 0;
    var minChatHeartbeat = 3000;
    var maxChatHeartbeat = 33000;
    var chatHeartbeatTime = minChatHeartbeat;
    var originalTitle;
    var blinkOrder = 0;
    var chatboxFocus = new Array();
    var newMessages = new Array();
    var newMessagesWin = new Array();
    var chatBoxes = new Array();

    $(document).ready(function () {
        originalTitle = document.title;
        startChatSession();

        $([window, document]).blur(function () {
            windowFocus = false;
        }).focus(function () {
            windowFocus = true;
            document.title = originalTitle;
        });
    });

    function restructureChatBoxes() {
        align = 0;
        for (x in chatBoxes) {
            chatboxtitle = chatBoxes[x];
            if ($("#chatbox_" + chatboxtitle).css('display') != 'none') {
                if (align == 0) {
                    $("#chatbox_" + chatboxtitle).css('right', '320px');
                } else {
                    width = (align) * (225 + 7) + 20;
                    $("#chatbox_" + chatboxtitle).css('right', '570px');
                }
                align++;
            }
        }
    }

    function chatWith(chatuser, chatname) {
        // Sanitize inputs
        chatuser = String(chatuser).replace(/[^a-zA-Z0-9_-]/g, '');
        chatname = $('<div>').text(chatname).html(); // HTML encode
        
        createChatBox(chatuser, chatname);
        $("#chatbox_" + chatuser + " .chatboxtextarea").focus();
    }

    function createChatBox(chatboxtitle, chatname, minimizeChatBox) {
        // Sanitize chatboxtitle to prevent XSS
        chatboxtitle = String(chatboxtitle).replace(/[^a-zA-Z0-9_-]/g, '');
        chatname = $('<div>').text(chatname).html();

        if ($("#chatbox_" + chatboxtitle).length > 0) {
            if ($("#chatbox_" + chatboxtitle).css('display') == 'none') {
                $("#chatbox_" + chatboxtitle).css('display', 'block');
                restructureChatBoxes();
            }
            $("#chatbox_" + chatboxtitle + " .chatboxtextarea").focus();
            return;
        }

        $(" <div />").attr("id", "chatbox_" + chatboxtitle)
            .addClass("chatbox")
            .html('<div style="cursor:pointer" onclick="javascript:toggleChatBoxGrowth(\'' + chatboxtitle + '\')"><div class="chatboxhead"><div class="chatboxtitle">' + chatname + '</div><div class="chatboxoptions">- <a href="javascript:void(0)" onclick="javascript:closeChatBox(\'' + chatboxtitle + '\')"> X </a></div><br clear="all"/></div></div><div id="abc" class="chatboxcontent"></div><div id="a" class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\'' + chatboxtitle + '\',\'' + chatname + '\');"></textarea></div>')
            .appendTo($("body"));

        $("#chatbox_" + chatboxtitle).css('bottom', '0px');

        chatBoxeslength = 0;
        for (x in chatBoxes) {
            if ($("#chatbox_" + chatBoxes[x]).css('display') != 'none') {
                chatBoxeslength++;
            }
        }

        if (chatBoxeslength == 0) {
            $("#chatbox_" + chatboxtitle).css('right', '320px');
        } else {
            width = (chatBoxeslength) * (230 + 8) + 20;
            $("#chatbox_" + chatboxtitle).css('right', '570px');
        }

        chatBoxes.push(chatboxtitle);

        if (minimizeChatBox == 1) {
            minimizedChatBoxes = new Array();
            if ($.cookie('chatbox_minimized')) {
                minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
            }
            minimize = 0;
            for (j = 0; j < minimizedChatBoxes.length; j++) {
                if (minimizedChatBoxes[j] == chatboxtitle) {
                    minimize = 1;
                }
            }
            if (minimize == 1) {
                $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
                $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
            }
        }

        chatboxFocus[chatboxtitle] = false;

        $("#chatbox_" + chatboxtitle + " .chatboxtextarea").blur(function () {
            chatboxFocus[chatboxtitle] = false;
            $("#chatbox_" + chatboxtitle + " .chatboxtextarea").removeClass('chatboxtextareaselected');
        }).focus(function () {
            chatboxFocus[chatboxtitle] = true;
            newMessages[chatboxtitle] = false;
            $('#chatbox_' + chatboxtitle + ' .chatboxhead').removeClass('chatboxblink');
            $("#chatbox_" + chatboxtitle + " .chatboxtextarea").addClass('chatboxtextareaselected');
        });

        $("#chatbox_" + chatboxtitle).click(function () {
            if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display') != 'none') {
                $("#chatbox_" + chatboxtitle + " .chatboxtextarea").focus();
            }
        });

        $("#chatbox_" + chatboxtitle).show();
    }

    function chatHeartbeat() {
        var itemsfound = 0;

        if (windowFocus == false) {
            var blinkNumber = 0;
            var titleChanged = 0;
            for (x in newMessagesWin) {
                if (newMessagesWin[x] == true) {
                    ++blinkNumber;
                    if (blinkNumber >= blinkOrder) {
                        document.title = x + ' says...';
                        titleChanged = 1;
                        break;
                    }
                }
            }

            if (titleChanged == 0) {
                document.title = originalTitle;
                blinkOrder = 0;
            } else {
                ++blinkOrder;
            }
        } else {
            for (x in newMessagesWin) {
                newMessagesWin[x] = false;
            }
        }

        for (x in newMessages) {
            if (newMessages[x] == true) {
                if (chatboxFocus[x] == false) {
                    $('#chatbox_' + x + ' .chatboxhead').toggleClass('chatboxblink');
                }
            }
        }

        $.ajax({
            url: "chat/chat?action=chatheartbeat",
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data && data.items) {
                    $.each(data.items, function (i, item) {
                        if (item) {
                            // Sanitize data from server
                            var chatboxtitle = String(item.f).replace(/[^a-zA-Z0-9_-]/g, '');
                            var cuser = $('<div>').text(item.u).html();
                            var image = String(item.ph).replace(/[^a-zA-Z0-9_.-]/g, '');

                            if ($("#chatbox_" + chatboxtitle).length <= 0) {
                                createChatBox(chatboxtitle, cuser);
                            }
                            if ($("#chatbox_" + chatboxtitle).css('display') == 'none') {
                                $("#chatbox_" + chatboxtitle).css('display', 'block');
                                restructureChatBoxes();
                            }

                            if (item.s == 1) {
                                item.f = username;
                            }

                            if (item.s == 2) {
                                var safeMessage = $('<div>').text(item.m).html();
                                $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' + safeMessage + '</span></div>');
                            } else {
                                newMessages[chatboxtitle] = true;
                                newMessagesWin[item.u] = true;
                                var safeMessage = $('<div>').text(item.m).html();
                                var safeUser = $('<div>').text(item.u).html();
                                $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chat_image"><img src="photos/' + image + '" height=20px width=26px>&nbsp;</span><span class="chatboxmessagefrom">' + safeUser + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + safeMessage + '</span></div>');
                            }

                            $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                            itemsfound += 1;
                        }
                    });
                }

                chatHeartbeatCount++;

                if (itemsfound > 0) {
                    chatHeartbeatTime = minChatHeartbeat;
                    chatHeartbeatCount = 1;
                } else if (chatHeartbeatCount >= 10) {
                    chatHeartbeatTime *= 2;
                    chatHeartbeatCount = 1;
                    if (chatHeartbeatTime > maxChatHeartbeat) {
                        chatHeartbeatTime = maxChatHeartbeat;
                    }
                }

                setTimeout('chatHeartbeat();', chatHeartbeatTime);
            }
        });
    }

    function closeChatBox(chatboxtitle) {
        $('#chatbox_' + chatboxtitle).css('display', 'none');
        restructureChatBoxes();

        $.post("chat/chat?action=closechat", {chatbox: chatboxtitle}, function (data) {
        });
    }

    function toggleChatBoxGrowth(chatboxtitle) {
        if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display') == 'none') {
            var minimizedChatBoxes = new Array();

            if ($.cookie('chatbox_minimized')) {
                minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
            }

            var newCookie = '';

            for (i = 0; i < minimizedChatBoxes.length; i++) {
                if (minimizedChatBoxes[i] != chatboxtitle) {
                    newCookie += chatboxtitle + '|';
                }
            }

            newCookie = newCookie.slice(0, -1);

            $.cookie('chatbox_minimized', newCookie);

            $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'block');
            $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'block');
            $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
        } else {
            var newCookie = chatboxtitle;

            if ($.cookie('chatbox_minimized')) {
                newCookie += '|' + $.cookie('chatbox_minimized');
            }

            $.cookie('chatbox_minimized', newCookie);
            $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
            $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
        }
    }

    function checkChatBoxInputKey(event, chatboxtextarea, chatboxtitle, chatname) {
        if (event.keyCode == 13 && event.shiftKey == 0) {
            message = $(chatboxtextarea).val();
            message = message.replace(/^\s+|\s+$/g, "");

            $(chatboxtextarea).val('');
            $(chatboxtextarea).focus();
            $(chatboxtextarea).css('height', '44px');

            if (message != '') {
                // Sanitize for display
                var safeMessage = $('<div>').text(message).html();
                
                $.post("chat/chat?action=sendchat", {
                    to: chatboxtitle,
                    message: message,
                    name: chatname
                }, function (data) {
                    var userPhoto = <?php echo json_encode($a); ?>;
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chat_image"><img src="photos/' + userPhoto + '" height="20px" width="26px">&nbsp;</span><span class="chatboxmessagefrom"></span><span class="chatboxmessagecontent">' + safeMessage + '</span></div>');
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                });
            }

            chatHeartbeatTime = minChatHeartbeat;
            chatHeartbeatCount = 1;

            return false;
        }

        var adjustedHeight = chatboxtextarea.clientHeight;
        var maxHeight = 94;

        if (maxHeight > adjustedHeight) {
            adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
            if (maxHeight)
                adjustedHeight = Math.min(maxHeight, adjustedHeight);
            if (adjustedHeight > chatboxtextarea.clientHeight)
                $(chatboxtextarea).css('height', adjustedHeight + 8 + 'px');
        } else {
            $(chatboxtextarea).css('overflow', 'auto');
        }
    }

    function startChatSession() {
        $.ajax({
            url: "chat/chat?action=startchatsession",
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data && data.items) {
                    $.each(data.items, function (i, item) {
                        if (item) {
                            var chatboxtitle = String(item.f).replace(/[^a-zA-Z0-9_-]/g, '');
                            var chatname = $('<div>').text(item.n).html();
                            createChatBox(chatboxtitle, chatname, 1);

                            if (item.s == 1) {
                                item.f = username;
                            }

                            if (item.s == 2) {
                                var safeMessage = $('<div>').text(item.m).html();
                                $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">' + safeMessage + '</span></div>');
                            } else {
                                var safeMessage = $('<div>').text(item.m).html();
                                var safeUser = $('<div>').text(item.u).html();
                                $("#chatbox_" + chatboxtitle + " .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">' + safeUser + ':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">' + safeMessage + '</span></div>');
                            }
                        }
                    });
                }

                for (i = 0; i < chatBoxes.length; i++) {
                    chatboxtitle = chatBoxes[i];
                    $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
                    setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100);
                }

                setTimeout('chatHeartbeat();', chatHeartbeatTime);
            }
        });
    }
</script>
