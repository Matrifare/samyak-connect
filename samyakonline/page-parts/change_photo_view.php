<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 6/4/2018
 * Time: 9:57 PM
 */
require_once '../DatabaseConnection.php';
include_once '../lib/Config.php';
include_once '../auth.php';
$DatabaseCo = new DatabaseConnection();
$configObj = new Config();
$photo = $_POST['photo'] ?? "";
?>
<style>
    .custom-file-input {
        color: transparent;
    }

    .custom-file-input::-webkit-file-upload-button {
        visibility: hidden;
    }

    .custom-file-input::before {
        content: 'Select Photo';
        color: black;
        display: inline-block;
        background: -webkit-linear-gradient(top, #f9f9f9, #e3e3e3);
        border: 1px solid #999;
        border-radius: 3px;
        padding: 5px 8px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        text-shadow: 1px 1px #fff;
        font-weight: 700;
        font-size: 10pt;
    }

    .custom-file-input:hover::before {
        border-color: black;
    }

    .custom-file-input:active {
        outline: 0;
    }

    .custom-file-input:active::before {
        background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
    }
</style>
<form class="form-horizontal" id="change_photo_form" data-image="<?= $photo ?>" method="post" enctype="multipart/form-data">
    <div class="row mb-10">
        <div class="col-xs-12 text-center"><h5 class="text-center btn btn-primary btn-sm btn-shrink">Update <?= ucfirst($photo) ?></h5></div>
    </div>
    <div class="row mb-10">
        <div class="col-xs-12 text-center">
    Facing problems in uploading photos?
            <br/>
            WhatsApp us <i class="fa fa-whatsapp"></i> <a style="font-weight: bold;" href="https://api.whatsapp.com/send?phone=919819886759&text=Need to upload photo on profile Id <?= $_SESSION['user_id'] ?>">Click Here</a>
            <br/>
            OR
            <br/>
            Email us photo Click on <a href="mailto:info@samyakmatrimony.com" style="font-weight: bold">info@samyakmatrimony.com</a>
            <br/>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-xs-4" style="padding-top:7px; padding-left: 10px; padding-right: 0px;">Select Photo</label>
                <input type="file" name="<?= $photo ?>" class="col-xs-8 filer_input" required>
                <!--<input type="file" name="<?/*= $photo */?>" class="custom-file-input" required/>-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 text-right" style="padding-right: 20px;">
            <div class="form-group">
                <button type="submit" class="btn btn-danger btn-shrink btn-sm" name="change_<?= $photo ?>">Submit
                </button>
            </div>
        </div>
        <div class="col-xs-6 text-left" style="padding-left: 20px;">
            <div class="form-group">
                <button type="button" data-dismiss="modal" class="btn btn-shrink btn-sm">Close</button>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-xs-12">
        <h5 class="text-center" id="change_photo_response"></h5>
    </div>
</div>

<!-- Custom filer - a custom file input -->
<script type="text/javascript">
    $('.filer_input').filer({
        limit:1,
        showThumbs: true,
        changeInput: '<div class="jFiler-custom-wrapper col-xs-8"><a class="jFiler-btn-form">Browse Photo</a></div>',
        captions: {
            button: "Choose Photo",
        },
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
											<div class="jFiler-item-container">\
													<div class="jFiler-item-inner">\
															<div class="jFiler-item-thumb">\
																	<div class="jFiler-item-status"></div>\
																	<div class="jFiler-item-info">\
																			<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 23}}</b></span>\
																			<span class="jFiler-item-others">{{fi-size2}}</span>\
																	</div>\
																	{{fi-image}}\
															</div>\
															<div class="jFiler-item-assets jFiler-row">\
																	<ul class="list-inline pull-left">\
																			<li>{{fi-progressBar}}</li>\
																	</ul>\
																	<ul class="list-inline pull-right">\
																			<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
																	</ul>\
															</div>\
													</div>\
											</div>\
									</li>',
            itemAppend: '<li class="jFiler-item">\
													<div class="jFiler-item-container">\
															<div class="jFiler-item-inner">\
																	<div class="jFiler-item-thumb">\
																			<div class="jFiler-item-status"></div>\
																			<div class="jFiler-item-info">\
																					<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 23}}</b></span>\
																					<span class="jFiler-item-others">{{fi-size2}}</span>\
																			</div>\
																			{{fi-image}}\
																	</div>\
																	<div class="jFiler-item-assets jFiler-row">\
																			<ul class="list-inline pull-left">\
																					<li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
																			</ul>\
																			<ul class="list-inline pull-right">\
																					<li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
																			</ul>\
																	</div>\
															</div>\
													</div>\
											</li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },

    });
</script>