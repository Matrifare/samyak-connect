<?php
include_once 'DatabaseConnection.php';
include_once 'lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once 'lib/Config.php';
include_once 'auth.php';
$configObj = new Config();
?>
<div class="hotel-message-wrapper">
    <div class="row">
        <div class="col-xs-12">
            <h4 class="text-center" style="font-size: 16px;">Interest Received <span style="font-size: 16px;text-transform: capitalize" id="countWithExpressInterest"></span>
                <button class="btn btn-danger btn-sm btn-shrink"
                        onclick="newWindow('web-services/express-interest-list?matri_id=<?= $_SESSION['user_id'] ?>&name=<?= $_SESSION['uname'] ?>&mobile=<?= $_SESSION['mobile'] ?>&pending_send=yes','','800','700');"
                        style="margin-left: 10px;"><i class="fa fa-whatsapp"></i> Get on WhatsApp</button>
            </h4>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="tab-style-01-wrapper">

                <ul id="detailTab" class="tab-nav clearfix">
                    <li class="active"><a href="#tab_2-01" data-toggle="tab" onclick="interest(this, 'received', 'pending');">Pending <!--<i class="fa fa-folder-open-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>  </li>
                    <li><a href="#tab_2-02" data-toggle="tab" onclick="interest(this, 'received', 'accepted');">Accepted <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_2-03" data-toggle="tab" onclick="interest(this, 'received', 'rejected');">Rejected <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_2-04" data-toggle="tab" onclick="interest(this, 'received', 'hold');">Decide Later <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_2-05" data-toggle="tab" onclick="interest(this, 'received', 'deleted');">Deleted <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="tab_2-01"></div>
                    <div class="tab-pane fade" id="tab_2-02"></div>
                    <div class="tab-pane fade" id="tab_2-03"></div>
                    <div class="tab-pane fade" id="tab_2-04"></div>
                    <div class="tab-pane fade" id="tab_2-05"></div>
                </div>

            </div>

        </div>

    </div>

</div>