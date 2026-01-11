<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/8/2018
 * Time: 12:04 AM
 */
?>
<span id="loader-animation-area">
    <img src="img/loader.gif" id="loader-icon-animated"/>
</span>
<header id="header" class="overflow-x-hidden-xss hidden">
    <?php
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        ?>

        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav">

            <div class="container">

                <div class="navbar-header">
                    <a class="navbar-brand" href="index_old">
                        <img src="logo/buddhist-matrimony.jpg" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                    </a>
                </div>

                <div id="navbar" class="collapse navbar-collapse navbar-arrow pull-left">

                    <ul class="nav navbar-nav" id="responsive-menu">
                        <li>
                            <a href="homepage">Home</a>

                        </li>
                        <li>
                            <a href="javascript:void(0)">My Profile</a>
                            <ul>
                                <li>
                                    <a href="#">Manage Profile</a>
                                    <ul>
                                        <li><a href="view_profile?userId=<?= $_SESSION['user_id'] ?>" target="_blank">View Profile</a></li>
                                        <li><a href="delete_profile">Delete Profile</a></li>
                                        <li><a href="current_plan">Current Plan</a></li>
                                        <!--<li><a href="result-page-grid-right-sidebar.html">Privacy Settings</a></li>
                                        <li><a href="result-page-grid-right-sidebar.html">Change Password</a></li>-->
                                    </ul>
                                </li>
                                <li><a href="edit-profile">Edit Profile</a></li>
                                <li><a href="change-password">Change Password</a></li>
                                <li><a href="edit_photo">Manage Photo</a></li>
                                <li><a href="express-interest">My Interest</a></li>
                                <li><a href="my-matches">My Matches</a></li>
                                <li><a href="profile-statistics">My Profile Statistics</a></li>
                                <li><a href="delete_profile">Delete Profile</a></li>
                            </ul>

                        </li>
                        <li>
                            <a href="search">Search</a>
                        </li>
                        <li>
                            <a href="premium_member">Plan</a>
                            <!--<ul>
                                <li><a href="premium_member">Membership</a></li>
                                <li><a href="">Current Plan</a></li>
                                <li><a href="contact_us">Contact Us</a></li>


                            </ul>-->
                        </li>
                </div><!--/.nav-collapse -->

                <div class="pull-right">

                    <div class="navbar-mini" style="margin-right: 0px;">
                        <ul class="clearfix">
                            <li class="hidden-md hidden-sm hidden-lg">
                                <a href="homepage" class="icon-msg">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    My Matrimony
                                </a>
                            </li>
                            <li class="">
                                <a href="search" class="icon-msg">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search
                                </a>
                            </li>
                            <li class="has-msg hidden-xs hidden-sm hidden-md">
                                <a href="messages" class="icon-msg">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <span class="count bg-danger">
                                        <?php
                                        if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) { ?>
                                            <?= mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT * from message INNER JOIN register_view ON register_view.email = message.msg_from where msg_to='" . $_SESSION['email'] . "' and trash_receiver='No'")); ?>
                                            <?php
                                        }
                                        ?>
                                    </span> Message
                                </a>
                            </li>
                            <li class="has-msg">
                                <a href="express-interest" class="icon-msg">
                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    <span class="count bg-danger"><?php
                                        if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) {
                                            $pendingInterest = mysqli_num_rows($DatabaseCo->dbLink->query("SELECT DISTINCT ei_id FROM expressinterest,register_view WHERE register_view.matri_id=expressinterest.ei_sender and expressinterest.ei_receiver='" . $_SESSION["user_id"] . "' and expressinterest.trash_receiver='No' and expressinterest.receiver_response='Pending' and register_view.status <> 'Suspended'"));
                                            if (!isset($_SESSION['no_photo']) && $pendingInterest >= 10) {
                                                $_SESSION['pendingInterest'] = $pendingInterest;
                                            }
                                            echo $pendingInterest;
                                        }
                                        ?></span> Interest
                                </a>
                            </li>

                            <li class="dropdown bt-dropdown-click user-action">
                                <a class="btn btn-primary btn-inverse btn-loged-in dropdown-toggle"
                                   data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?= $_SESSION['user_id'] ?? "" ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" aria-labelledby="language-dropdown">
                                    <li><a target="_blank" href="view_profile?userId=<?= $_SESSION['user_id'] ?>">My Profile</a></li>
                                    <li><a href="edit_photo">Edit Photo</a></li>
                                    <li><a href="my-matches">My Matches</a></li>
                                    <li><a href="profile-statistics">Profile Statistics</a></li>
                                    <li><a href="logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->
    <?php } else { ?>
        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav">

            <div class="container">

                <div class="navbar-header">

                    <a class="navbar-brand" href="index_old">
                        <img src="logo/buddhist-matrimony.jpg" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                    </a>
                </div>

                <div id="navbar" class="collapse navbar-collapse navbar-arrow pull-left">
                    <ul class="nav navbar-nav" id="responsive-menu">
                        <li>
                            <a href="index_old">Home</a>

                        </li>
                        <li>
                            <a href="register" title="Register me">Register</a>
                        </li>
                        <!--<li>
                            <a href="result-page-list.html">Search Profile</a>
                            <ul>
                                <li>
                                    <a href="result-page-grid.html">Quick Search</a>

                                </li>


                                <li><a href="confirmation.html">Advance Search</a></li>
                                <li><a href="list-property.html">Keyword Search </a></li>
                                <li><a href="list-property.html">Matri ID Search </a></li>
                                <li><a href="list-property.html">Samyak ID Search </a></li>
                            </ul>

                        </li>-->
                        <li>
                            <a href="premium_member">Membership</a>

                        </li>
                        <li>
                            <a href="search">Search</a>

                        </li>

                    </ul>
                </div><!--/.nav-collapse -->

                <div class="pull-right hidden-xs">

                    <div class="navbar-mini">
                        <ul class="clearfix">
                            <li class="user-action">
                                <a href="login" style="margin-top: 14px;color: #FFF; padding: 5px; float: right;text-align: right;" class="btn btn-primary"> &nbsp; &nbsp; Login &nbsp; &nbsp; </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->
    <?php } ?>
</header>
<header id="header_new" class="overflow-x-hidden-xss hidden-sm hidden-xs hidden-xss">
    <?php
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $webPage = basename($_SERVER['REQUEST_URI']);
        ?>
        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav new-menu-nav">

            <div class="container">
                <div class="new-menu">
                    <div class="left-side-menu">
                        <div class="logo-image">
                            <a class="" href="index_old">
                                <img src="logo/buddhist-matrimony.png" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                            </a>
                        </div>
                    </div>
                    <div class="right-side-menu">
                        <div class="desktop-menu-list">
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && $webPage=='homepage') ? "active" : "" ?>" href="homepage">Dashboard</a>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && in_array($webPage, ['view_profile', 'edit-profile',
                                        'express-interest', 'my-matches', 'messages', 'profile-statistics'])) ? "active" : "" ?>" href="javascript:void(0);">My Profile</a>
                                <div class="desktop-more-list-item top-animate">
                                    <a class="<?= (!empty($webPage) && $webPage=='view_profile') ? "active" : "" ?>" href="view_profile?userId=<?= $_SESSION['user_id'] ?>" target="_blank">View Profile</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='edit-profile') ? "active" : "" ?>" href="edit-profile">Edit Profile</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='edit_photo') ? "active" : "" ?>" href="edit_photo">Manage Photo</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='express-interest') ? "active" : "" ?>" href="express-interest">My Interest</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='my-matches') ? "active" : "" ?>" href="my-matches">My Matches</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='messages') ? "active" : "" ?>" href="messages">My Messages</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='messages') ? "active" : "" ?>" href="show_more_profiles?type=visitor">My Visitor List</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='profile-statistics') ? "active" : "" ?>" href="profile-statistics">My Profile Statistics</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='delete_profile') ? "active" : "" ?>" href="delete_profile">Delete Profile</a>
                                </div>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="javascript:void(0);">Search</a>
                                <div class="desktop-more-list-item top-animate">
                                    <a class="<?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="search">Quick Search</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="search#tab_1-02">Advanced Search</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="search#tab_1-03">ID Search</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="my-matches"> My Matches</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='search') ? "active" : "" ?>" href="search#tab_1-04"> Keyword Search</a>
                                </div>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && in_array($webPage, ['settings', 'change-password', 'change-contact-detail',
                                        'contact-security', 'edit_photo', 'photo-security', 'profile-security','express-interest-privacy', 'delete_profile',
                                        'update-descriptions'])) ? "active" : "" ?>" href="settings">Settings</a>
                                <div class="desktop-more-list-item top-animate">
                                    <a class="<?= (!empty($webPage) && $webPage=='edit_photo') ? "active" : "" ?>" href="edit_photo">Edit Photo</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='settings') ? "active" : "" ?>" href="settings">Profile Settings</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='express-interest-privacy') ? "active" : "" ?>" href="express-interest-privacy">Interest Privacy</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='contact-security') ? "active" : "" ?>" href="contact-security">Contact Security</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='change-password') ? "active" : "" ?>" href="change-password">Change Password</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='change-contact-detail') ? "active" : "" ?>" href="change-contact-detail">Edit Contact Details</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='update-descriptions') ? "active" : "" ?>" href="update-descriptions">Profile Description</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='photo-security') ? "active" : "" ?>" href="photo-security">Photo Hide/Unhide</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='profile-security') ? "active" : "" ?>" href="profile-security">Profile Hide/Unhide</a>
                                    <a class="<?= (!empty($webPage) && $webPage=='delete_profile') ? "active" : "" ?>" href="delete_profile">Delete Profile</a>
                                </div>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && in_array($webPage, ['current_plan', 'premium_member'])) ? "active" : "" ?>"
                                   href="javascript:void(0);">Plan</a>
                                <div class="desktop-more-list-item top-animate">
                                    <a class="<?= (!empty($webPage) && $webPage=='premium_member') ? "active" : "" ?>" href="premium_member">Membership Plans</a>
                                    <?php
                                    if(!empty($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid') {
                                        ?>
                                        <a class="<?= (!empty($webPage) && $webPage == 'current_plan') ? "active" : "" ?>"
                                           href="current_plan">My Plan</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link <?= (!empty($webPage) && in_array($webPage, ['contact_us'])) ? "active" : "" ?>"
                                   href="contact_us">Contact Us</a>
                            </div>
                            <div class="desktop-menu-list-item">
                                <a class="desktop-link" href="logout">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end Navbar (Header) -->
    <?php } else { ?>
        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav">

            <div class="container">

                <div class="navbar-header">

                    <a class="navbar-brand" href="index_old">
                        <img src="logo/buddhist-matrimony.jpg" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                    </a>
                </div>

                <div id="navbar" class="collapse navbar-collapse navbar-arrow pull-left">
                    <ul class="nav navbar-nav" id="responsive-menu">
                        <li>
                            <a href="index_old">Home</a>

                        </li>
                        <li>
                            <a href="register" title="Register me">Register</a>
                        </li>
                        <!--<li>
                            <a href="result-page-list.html">Search Profile</a>
                            <ul>
                                <li>
                                    <a href="result-page-grid.html">Quick Search</a>

                                </li>


                                <li><a href="confirmation.html">Advance Search</a></li>
                                <li><a href="list-property.html">Keyword Search </a></li>
                                <li><a href="list-property.html">Matri ID Search </a></li>
                                <li><a href="list-property.html">Samyak ID Search </a></li>
                            </ul>

                        </li>-->
                        <li>
                            <a href="search">Search</a>

                        </li>
                        <li>
                            <a href="contact_us">Contact Us</a>

                        </li>

                    </ul>
                </div><!--/.nav-collapse -->

                <div class="pull-right hidden-xs">

                    <div class="navbar-mini">
                        <ul class="clearfix">
                            <li class="user-action">
                                <a href="login" style="margin-top: 14px;color: #FFF; padding: 5px; float: right;text-align: right;" class="btn btn-primary"> &nbsp; &nbsp; Login &nbsp; &nbsp; </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->
    <?php } ?>
</header>
<header id="header_mobile" class="overflow-x-hidden-xss hidden-md hidden-lg">
    <?php
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $webPage = basename($_SERVER['REQUEST_URI']);
        ?>
        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav new-menu-nav">

            <div class="container">
                <div class="new-menu float-left">
                    <div class="mobile-menu-list">
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link  <?= (!empty($webPage) && in_array($webPage, ['homepage', 'view_profile', 'my-matches',
                                    'edit-profile'])) ? "active" : "" ?>" href="homepage"><i class="fa fa-home"></i> </a>
                        </div>
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link <?= (!empty($webPage) && in_array($webPage, ['search', 'search?'])) ? "active" : "" ?>" href="search"><i class="fa fa-search-plus"></i> </a>
                        </div>
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link <?= (!empty($webPage) && in_array($webPage, ['messages', 'messages?', 'messages?type=received'])) ? "active" : "" ?>" href="messages"><i class="fa fa-envelope-o"></i> </a>
                        </div>
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link <?= (!empty($webPage) && in_array($webPage, ['express-interest',
                                    'express-interest?type=received', 'express-interest?type=sent&',
                                    'express-interest?type=sent'])) ? "active" : "" ?>" href="express-interest"><i class="fa fa-heart-o"></i>
                            </a>
                        </div>
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link <?= (!empty($webPage) && in_array($webPage, ['premium_member', 'current_plan'])) ? "active" : "" ?>" href="premium_member"><i class="fa fa-shopping-cart"></i> </a>
                        </div>
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link <?= (!empty($webPage) && in_array($webPage, ['settings', 'change-password', 'change-contact-detail',
                                    'contact-security', 'edit_photo', 'photo-security', 'profile_security',
                                    'delete_profile'])) ? "active" : "" ?>" href="settings"><i class="fa fa-wrench"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="new-menu float-right">
                    <div class="mobile-menu-list">
                        <div class="mobile-menu-list-item">
                            <a class="mobile-link menu_btn" href="javascript:void(0);" onClick="openRightSideMenu();"><i class="fa fa-bars"></i> </a>
                        </div>
                    </div>
                </div>

                <div class="right-side-menu-new">
                    <div class="side-logo float-left">
                        <a class="" href="index_old">
                            <img src="logo/buddhist-matrimony.png" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                        </a>
                    </div>
                    <div class="side-menu-close float-right">
                        <span class="close_btn" onClick="closeRightSideMenu();">
                            <i class="fa fa-close"></i>
                        </span>
                    </div>
                    <div class="clear"></div>
                    <div class="side-menu-list">
                        <a href="javscript:void(0);">My Account</a>
                        <div class="side-sub-menu-list">
                            <a href="index_old">Homepage</a>
                            <a href="homepage">Dashboard</a>
                            <a href="view_profile?userId=<?= $_SESSION['user_id'] ?>" target="_blank">My Profile</a>
                            <a href="edit-profile">Edit Profile</a>
                            <a href="my-matches">My Match</a>
                            <a href="edit_photo">Manage/Hide Photo</a>
                            <a href="delete_profile">Delete Profile</a>
                            <a href="change-password">Change Password</a>
                        </div>
                        <a href="javascript:void(0);">My Interest/Message</a>
                        <div class="side-sub-menu-list">
                            <a href="express-interest?type=received">Pending Interest</a>
                            <a href="express-interest?type=sent&#tab_1-02">Accepted Interest</a>
                            <a href="express-interest?type=sent#tab_1-03">Decline Interest</a>
                            <a href="messages?type=received">Received Messages</a>
                            <a href="messages#tab_2-02">Sent Messages</a>
                        </div>
                        <a href="javascript:void(0);">Search</a>
                        <div class="side-sub-menu-list">
                            <a href="search">Advanced Search</a>
                            <a href="search?#tab_1-02">ID Search</a>
                            <a href="my-matches">My Matches</a>
                            <a href="search#tab_1-04">Name Search</a>
                        </div>
                        <a href="javascript:void(0);">Profile Statistics</a>
                        <div class="side-sub-menu-list">
                            <a href="show_more_profiles?type=bookmark">Bookmarked Profiles</a>
                            <a href="show_more_profiles?type=viewed">Profiles visited by me</a>
                            <a href="show_more_profiles?type=visitor">Visitor List My Profile</a>
                            <a href="show_more_profiles?type=viewed_contacts">Contacts viewed by me</a>
                            <a href="show_more_profiles?type=viewed_my_contact">Who viewed my contact</a>
                            <a href="show_more_profiles?type=block">Block listed Profiles</a>
                        </div>
                        <a href="javascript:void(0);">Membership</a>
                        <div class="side-sub-menu-list">
                            <a href="premium_member">Membership Plan</a>
                            <?php
                            if(!empty($_SESSION['mem_status']) && $_SESSION['mem_status'] == 'Paid') {
                                ?>
                                <a href="current_plan">My Plan</a>
                                <?php
                            }
                            ?>
                            <!--<a href="javscript:void(0);">Pending Order</a>-->
                        </div>
                        <a href="settings">Settings</a>
                        <div class="side-sub-menu-list">
                            <a href="change-password">Change Password</a>
                            <a href="change-contact-detail">Edit Contact Details</a>
                            <a href="contact-security">Contact Security</a>
                            <a href="edit_photo">Edit Photo</a>
                            <a href="photo-security">Photo Hide/Unhide</a>
                            <a href="profile-security">Profile Hide/Unhide</a>
                            <a href="delete_profile">Delete Profile</a>
                        </div>
                        <a href="javascript:void(0);">Assistance</a>
                        <div class="side-sub-menu-list">
                            <a href="contact_us">Contact</a>
                        </div>
                        <a href="logout">Logout</a>
                    </div>
                </div>
            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->
    <?php } else { ?>
        <!-- start Navbar (Header) -->
        <nav class="navbar navbar-default navbar-fixed-top with-slicknav">

            <div class="container">

                <div class="navbar-header">

                    <a class="navbar-brand" href="index_old">
                        <img src="logo/buddhist-matrimony.jpg" alt="Buddhist Matrimony" title="Buddhist Matrimony">
                    </a>
                </div>

                <div id="navbar" class="collapse navbar-collapse navbar-arrow pull-left">
                    <ul class="nav navbar-nav" id="responsive-menu">
                        <li>
                            <a href="index_old">Home</a>

                        </li>
                        <li>
                            <a href="register" title="Register me">Register</a>
                        </li>
                        <!--<li>
                            <a href="result-page-list.html">Search Profile</a>
                            <ul>
                                <li>
                                    <a href="result-page-grid.html">Quick Search</a>

                                </li>


                                <li><a href="confirmation.html">Advance Search</a></li>
                                <li><a href="list-property.html">Keyword Search </a></li>
                                <li><a href="list-property.html">Matri ID Search </a></li>
                                <li><a href="list-property.html">Samyak ID Search </a></li>
                            </ul>

                        </li>-->
                        <li>
                            <a href="search">Search</a>

                        </li>
                        <li>
                            <a href="contact_us">Contact Us</a>

                        </li>

                    </ul>
                </div><!--/.nav-collapse -->

                <div class="pull-right hidden-xs">

                    <div class="navbar-mini">
                        <ul class="clearfix">
                            <li class="user-action">
                                <a href="login" style="margin-top: 14px;color: #FFF; padding: 5px; float: right;text-align: right;" class="btn btn-primary"> &nbsp; &nbsp; Login &nbsp; &nbsp; </a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="slicknav-mobile"></div>

        </nav>
        <!-- end Navbar (Header) -->
    <?php } ?>
</header>

<?php
if (!empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !empty($_SESSION['user_id'])) {
    $sql = "select DISTINCT p.* from payment_view p where p.pmatri_id='" . $_SESSION['user_id'] . "' and p_plan!='Free'";
    $result = $DatabaseCo->dbLink->query($sql);
    if ($result->num_rows > 0) { ?>
    <link type="text/css" rel="stylesheet" id="arrowchat_css" media="all" href="samyak-chat/external.php?type=css" charset="utf-8" />
    <script type="text/javascript" src="samyak-chat/includes/js/jquery.js"></script>
    <script type="text/javascript" src="samyak-chat/includes/js/jquery-ui.js"></script>
    <?php }
}?>