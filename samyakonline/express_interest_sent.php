

<div class="hotel-message-wrapper">
    <div class="row">
        <div class="col-xs-12">
            <h4 class="text-center" style="font-size: 16px;">Interest Sent <span style="font-size: 16px; text-transform: capitalize" id="countWithExpressInterest"></span></h4>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-12">

            <div class="tab-style-01-wrapper">

                <ul id="detailTab" class="tab-nav clearfix">
                    <li class="active"><a href="#tab_1-01" data-toggle="tab" onclick="interest(this, 'sent', 'pending');">Pending <!--<i class="fa fa-folder-open-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a>  </li>
                    <li><a href="#tab_1-02" data-toggle="tab" onclick="interest(this, 'sent', 'accepted');">Accepted <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_1-03" data-toggle="tab" onclick="interest(this, 'sent', 'rejected');">Rejected <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_1-04" data-toggle="tab" onclick="interest(this, 'sent', 'hold');">Decide Later <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                    <li><a href="#tab_1-05" data-toggle="tab" onclick="interest(this, 'sent', 'deleted');">Deleted <!--<i class="fa fa-folder-o mt-5 pull-right hidden-lg hidden-md hidden-sm"></i>--></a></li>
                </ul>

                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="tab_1-01"></div>
                    <div class="tab-pane fade" id="tab_1-02"></div>
                    <div class="tab-pane fade" id="tab_1-03"></div>
                    <div class="tab-pane fade" id="tab_1-04"></div>
                    <div class="tab-pane fade" id="tab_1-05"></div>
                </div>

            </div>

        </div>

    </div>

</div>