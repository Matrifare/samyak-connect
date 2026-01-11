<?php
$sel_id=$DatabaseCo->dbLink->query("select matri_id from register_view where email='".$DatabaseCo->dbRow->msg_from."'");
$name=mysqli_fetch_array($sel_id);
?>

<li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">

                            	<div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">

 

                           	  	     <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">

                                    	

                                        <input type="checkbox" class="table-checkbox ne_disply-inline-blk ne_mrg_ri8_5 margin-top-5px pull-left" name="msg_id" id="msg_id" value="<?php echo $DatabaseCo->dbRow->msg_id;?>" >

                						

                                        <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onClick="importantfun(<?php echo $DatabaseCo->dbRow->msg_id;?>,<?php if($DatabaseCo->dbRow->msg_important_status=='Yes'){ echo "'No'";}else{ echo "'Yes'";} ?>);"><!-- "ne_inbox_msg_imp_active"for selected star--->

                                        	<i class="fa fa-star <?php if($DatabaseCo->dbRow->msg_important_status=='Yes'){ echo "ne_inbox_msg_imp_active";} ?>"></i>

                                        </a>

                                        <a href="inbox_main_msg.php?msg_id=<?php echo $DatabaseCo->dbRow->msg_id;?>&inb=1" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="left" title="<?php echo $name['matri_id'];?>">

                                        	<div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name" ><!---- "ne_inbox_msg_id_readed" class for readed msg(unbold)--->

                                               <?php echo $name['matri_id'];?>

                                            </div>

                                        </a>

                                    </div>

                                    

                                    <!-------------------------------for desktop------------------------------------------->

                                    <a href="inbox_main_msg.php?msg_id=<?php echo $DatabaseCo->dbRow->msg_id;?>&inb=1" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">

                                		<b class="ne_mrg_ri8_5 ne_font_11 name">(&nbsp;<?php echo htmlspecialchars_decode($DatabaseCo->dbRow->msg_subject); ?>&nbsp;) &nbsp;</b><?php //echo substr(htmlspecialchars_decode($DatabaseCo->dbRow->msg_content),0,45).'...'; ?>

                                    </a>

                                    <!-------------------------------for desktop End------------------------------------------->

                                    <!-------------------------------for mobile------------------------------------------->

                                    <a href="inbox_main_msg.php?msg_id=<?php echo $DatabaseCo->dbRow->msg_id;?>&inb=1" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">

                                		<b class="ne_mrg_ri8_5 name1">(&nbsp;<?php echo $DatabaseCo->dbRow->msg_subject; ?>&nbsp;) &nbsp;</b><?php //echo substr(htmlspecialchars_decode($DatabaseCo->dbRow->msg_content),0,10); ?>

                                    </a>

                                    <!-------------------------------for mobile End------------------------------------------->

                                </div>

                                <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">

                                 	<i class="fa fa-clock-o ne_mrg_ri8_5"></i><?php echo date('d M Y ,H:i A', strtotime($DatabaseCo->dbRow->msg_date)); ?>

                                    

                                </div>

                            </li>

