<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 4/14/2018
 * Time: 4:28 PM
 */
?>
<!-- BEGIN # MODAL LOGIN -->
<div class="modal fade modal-border-transparent" id="profileViewModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <button type="button" class="btn btn-close close" data-dismiss="modal" aria-label="Close">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>

            <div class="clear"></div>

            <!-- Begin # DIV Form -->
            <div id="modal-login-form-wrapper">
                <div class="modal-body pb-10">
                    <div class="row">
                        <div class="col-xs-12 col-sm-offset-3 col-sm-6 col-md-offset-3 col-md-6">
                            <?php if ($Row->photo1 != "" && $Row->photo1_approve == 'APPROVED' &&
                                (
                                    ($Row->photo_view_status == '1') || ($Row->photo_view_status == '2' && $_SESSION['mem_status'] == 'Paid')
                                )
                                && ($Row->photo_protect != "Yes" || $Row->photo_pswd == '')
                            ) {
                                ?>
                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                    <a href="#"
                                       onClick="newWindow('view_photo_album?matri_id=<?php echo $Row->matri_id; ?>','','790','600')"
                                       class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px font-dark-grey">
                                        <i class="fa fa-picture-o ne_mrg_ri8_10"></i><span>View More Photos</span>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>


                            <?php
                            if ($Row->video != '' || $Row->video_url != '' && $Row->video_approval == 'APPROVED') {
                                ?>

                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">

                                    <a href="#" data-toggle="modal" data-target="#myModal7"
                                       class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey"
                                       onclick="Getvideo('<?php echo $Row->matri_id; ?>')">
                                        <i class="fa fa-video-camera ne_mrg_ri8_10"></i>View Featured Video
                                    </a>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                <a target="_blank" href="javascript:void(0);" onclick="send_message('<?= $Row->matri_id ?>')"
                                   class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey">
                                    <i class="fa fa-envelope ne_mrg_ri8_10"></i>Send Message
                                </a>
                            </div>
                            <div class="modal fade-in" id="myModal1" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true">
                            </div>
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                <a href="javascript:;"
                                   class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey"
                                   title="Send Interest"
                                   onclick="ExpressInterest('<?php echo $Row->matri_id; ?>', '<?= (isset($_SESSION['last_login']) && $_SESSION['last_login'] == 'first_time') ? 'No' : 'Yes' ?>')"
                                   target="_blank">
                                    <i class="fa fa-paper-plane"></i>&nbsp;<span> Send Interest</span>
                                </a>

                            </div>
                            <div class="modal fade-in" id="myModal2" tabindex="-1" role="dialog"
                                 aria-labelledby="myModalLabel" aria-hidden="true"></div>
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                <a href="#" data-toggle="modal" data-target="#myModal2"
                                   class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey"
                                   onclick="getContactDetail('<?php echo $Row->matri_id; ?>')" target="_blank"
                                   data-toggle="modal">
                                    <i class="fa fa-phone ne_mrg_ri8_10"></i>Contact Detail
                                </a>
                            </div>
                            <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                    <a href="javascript:;"
                                       class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey">
                                        <i class="fa fa-clock-o"></i> &nbsp; Last Online
                                        : <?= date('d M, Y', strtotime($Row->last_login)) ?>
                                    </a>
                                </div>
                            </div>
                            <?php
                            if (!empty($Row->p_plan) && $Row->p_plan != 'Free') {
                                ?>
                                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero bg-white">
                                        <a href="javascript:;"
                                           class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne_pad_btm_10px ne_pad_tp_10px font-dark-grey">
                                            <img src="img/paid-icon.jpg" alt="Paid Profile" title="Paid Profile"/>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>