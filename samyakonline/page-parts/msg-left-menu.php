<?php
$get_page=explode("/",$_SERVER["REQUEST_URI"]);
//print_r($get_page);

$sent_cnt=mysqli_num_rows($DatabaseCo->dbLink->query("select msg_id from message where msg_from='".$_SESSION['email']."' and msg_status='sent' and trash_sender='No'"));			
 
$draft_cnt=mysqli_num_rows($DatabaseCo->dbLink->query("select msg_id from message where msg_from='".$_SESSION['email']."' and msg_status='draft' and trash_sender='No'"));			

$trash_cnt=mysqli_num_rows($DatabaseCo->dbLink->query("select * from message where (msg_from='".$_SESSION['email']."' and trash_sender='Yes' ) or (msg_to='".$_SESSION['email']."' and trash_receiver='Yes' ) order by msg_id desc"));			

$important_cnt=mysqli_num_rows($DatabaseCo->dbLink->query("select msg_id from message where (msg_from='".$_SESSION['email']."' and msg_important_status='Yes' and trash_sender='No') or (msg_to='".$_SESSION['email']."' and msg_important_status='Yes' and trash_receiver='No')"));			

$inbox_cnt=mysqli_num_rows($DatabaseCo->dbLink->query("select msg_id from message where msg_to='".$_SESSION['email']."' and msg_status='sent' and trash_receiver='No'"));			


?>



<div class="xxl-4 xl-4 s-16 m-16 l-4 xs-16 ne_inbox_left_pan padding-lr-zero-320 padding-lr-zero-480">

<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
      <a class="btn-compose-new-msg xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne-cursor" data-target="#myModal1" data-toggle="modal" onClick="cmpchkmsg();">
      	<i class="fa fa-plus ne_mrg_ri8_10"></i>Compose New
      </a>
</div>
                   
                    	<ul class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne-box-shd-1px-lgt-grey ne-bdr-lgt-grey margin-top-10px padding-lr-zero">

                        	

                        	    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">

                            		<a href="inbox" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 <?php if($get_page[2]=='inbox'){echo "active";}?>">

                                    	<div class="xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">

                                        	<i class="fa fa-inbox ne_mrg_ri8_10"></i>Inbox

                                        </div>

                                        <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">

                                        	<span class="ne-counter pull-right "><?php echo $inbox_cnt; ?></span>

                                        </div>

                                    </a>

                                </li>

                                <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">

                                	<a href="sent_msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 <?php if($get_page[2]=='sent_msg'){echo "active";}?>">

                                    	<div class="xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">

                                        	<i class="fa fa-paper-plane ne_mrg_ri8_10"></i>Sent

                                        </div>

                                        <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">

                                        	<span class="ne-counter pull-right "><?php echo $sent_cnt; ?></span>

                                        </div>

                                    </a>

                                </li>

                                <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">

                                	<a href="draft_msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 <?php if($get_page[2]=='draft_msg'){echo "active";}?>">

                                    	<div class="xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">

                                        	<i class="fa fa-envelope ne_mrg_ri8_10"></i>Draft

                                        </div>

                                        <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">

                                        	<span class="ne-counter pull-right "><?php echo $draft_cnt; ?></span>

                                        </div>

                                    </a>

                                </li>

                                <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">

                                	<a href="important_msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 <?php if($get_page[2]=='important_msg'){echo "active";}?>">

                                    	<div class="xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">

                                        	<i class="fa fa-star-o ne_mrg_ri8_10"></i>Important

                                        </div>

                                        <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">

                                        	<span class="ne-counter pull-right "><?php echo $important_cnt; ?></span>

                                        </div>

                                    </a>

                                </li>

                                <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">

                                	<a href="trash_msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 <?php if($get_page[2]=='trash_msg'){echo "active";}?>">

                                    	<div class="xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">

                                        	<i class="fa fa-trash-o ne_mrg_ri8_10"></i>Trash

                                        </div>

                                        <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">

                                        	<span class="ne-counter pull-right "><?php echo $trash_cnt; ?></span>

                                        </div>

                                    </a>

                                </li>

                        </ul>

                    </div>