<?php
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$con = '';
$limit = '';
$adjacent = '';
if (isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction'] != '') {
    $actionfunction = $_REQUEST['actionfunction'];
    call_user_func($actionfunction, $_REQUEST, $con, $limit, $adjacent);
}
function showData($data, $con, $limit, $adjacent)
{
    $limit = 1;
    $adjacent = 1;
    $DatabaseCo = new DatabaseConnection();
    $page = $_POST['page'];
    if ($page == 1) {
        $start = 0;
    } else {
        $start = ($page - 1) * $limit;
    }
    $sql = "select * from success_story where weddingphoto_type='photo' and status='APPROVED'";
    $rows = $DatabaseCo->dbLink->query($sql);
    $rows = mysqli_num_rows($rows);
    $sql = "select * from success_story where weddingphoto_type='photo' and status='APPROVED' limit $start,$limit";
    $data = $DatabaseCo->dbLink->query($sql);
    if (mysqli_num_rows($data) > 0) {
        while ($get_featured_story = mysqli_fetch_object($data)) {
            $str = '<div  class="xxl-8 xl-8 s-16 m-8 l-8 xs-16 padding-lr-zero ">
										<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 margin-bottom-20px padding-lr-zero-320 padding-lr-zero-480">
															<div class="xxl-16 xl-16 s-16 m-16 l-16 xs-16 center-text down bg-light-grey padding-15px border-radius-5px">
																Success Story
															</div>
															<div class="clearfix"></div>
															<span class="arrow-down ne-arrow-mrg"></span>
														</div>
														<div class="clearfix"></div>
														<div class="xxl-16 xl-16 s-16 m-16 l-16 center-text padding-lr-zero-320 padding-lr-zero-480">
															<h4 class="xxl-16 xl-16 xs-16 box-shadow-light margin-bottom-0px border-radius-top-5px padding-top-10px padding-bottom-10px border-1px-light-grey font-light-grey bg-offwhite">' . $get_featured_story->bridename . ' & ' . $get_featured_story->groomname . '
															</h4>
														</div>
														<div class="xxl-16 xs-16 padding-lr-zero">
															<div class="margin-bottom-0px xxl-16 padding-lr-zero-320 padding-lr-zero-480">
																<img src="SuccessStory/' . $get_featured_story->weddingphoto . '" class="" style="max-height:253px; width:100%;" >
															</div>
															<div class="clearfix"></div>
														</div>
														<div class="xxl-16 xs-16 padding-lr-zero-320 padding-lr-zero-480">
															<div class="xxl-16 xl-16 s-16 m-16 l-16 xs-16 padding-15px border-radius-bottom-5px box-shadow-light border-1px-light-grey bg-offwhite">
																<p class="left-text xxl-16 xl-16 s-16 l-16 xs-16 m-16 padding-lr-zero font-size-14">
												   ' . substr($get_featured_story->successmessage, 0, 250) . '... 
																</p>
																<a class="text-decoration-none right-text xxl-16 xl-16 xs-16 padding-lr-zero margin-top-5px trigger ne-cursor" data-toggle="modal" data-target="#myModal">
																  Read More...
																</a>
																
																															</div>
															
														</div>
														<div class="clearfix"></div>
														';
            echo $str;
            ?>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true" style="position:fixed;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content xxl-16 xl-16 m-16 l-16 s-16 xs-16">
                        <div class="xxl-16 xl-16 m-16 l-16 s-16 xs-16">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove-circle" style="display:block;"></i>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-body xxl-16 xl-16 m-16 l-16 s-16 xs-16">
                            <div class="xxl-6 xl-6 l-16 s-16 m-16 xs-16">
                                <img src="SuccessStory/<?php echo $get_featured_story->weddingphoto; ?>"
                                     class="img-thumbnail">
                            </div>
                            <div class="xxl-10 xl-10 l-16 s-16 m-16 xs-16 margin-top-10px-320px margin-top-10px-480px ne-mrg-top-10-768 margin-top-10px-999">
                                <?php echo $get_featured_story->successmessage; ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="modal-footer xxl-16 xl-16 m-16 l-16 s-16 xs-16">
                            <button type="button" class="button-green button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        $str = '<div  class="xxl-8 xl-8 s-16 m-8 l-8 xs-16 padding-lr-zero ">
										<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 margin-bottom-20px padding-lr-zero-320 padding-lr-zero-480">
															<div class="xxl-16 xl-16 s-16 m-16 l-16 xs-16 center-text down bg-light-grey padding-15px border-radius-5px">
																Success Story
															</div>
															<div class="clearfix"></div>
															<span class="arrow-down ne-arrow-mrg"></span>
														</div>
														<div class="clearfix"></div>
					
														
										<div class="xxl-16 xl-16 s-16 m-16 l-16 center-text padding-lr-zero-320 padding-lr-zero-480">
                                            		<h4 class="xxl-16 xl-16 xs-16 box-shadow-light margin-bottom-0px border-radius-top-5px padding-top-10px padding-bottom-10px border-1px-light-grey font-light-grey bg-offwhite">
                                          <img src="../img/nodata.jpg" alt="User Image" class="img-responsive" border="1" />
                                                	</h4>
                                                </div>
												
														<div class="clearfix"></div>
														';
        echo $str;
    }
    ?>
    <div class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 ne-success-next padding-lr-zero-320 margin-bottom-20px padding-lr-zero-480">
        <?php pagination($limit, $adjacent, $rows, $page); ?>
    </div>
    </div>
    <?php
}
function pagination($limit, $adjacents, $rows, $page)
{
    $pagination = '';
    if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
    $prev = $page - 1;                            //previous page is page - 1
    $next = $page + 1;                            //next page is page + 1
    $prev_ = '';
    $first = '';
    $lastpage = ceil($rows / $limit);
    $next_ = '';
    $last = '';
    if ($lastpage > 1) {
        if ($page > 1)
            $prev_ .= "<a class='page-numbers' href=\"?page=$prev\">Previous</a>";
        else {
            //$pagination.= "<span class=\"disabled\">previous</span>";	
        }
        //pages	
        if ($lastpage < 5 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {
            $first = '';
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<span class=\"current\">$counter</span>";
                else
                    $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
            }
            $last = '';
        } elseif ($lastpage > 3 + ($adjacents * 2))    //enough pages to hide some
        {
            //close to beginning; only hide later pages
            $first = '';
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                }
                $last .= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<a class='page-numbers' href=\"?page=1\">First</a>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current\">$counter</span>";
                    else
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                }
                $last .= "<a class='page-numbers' href=\"?page=$lastpage\">Last</a>";
            } //close to end; only hide early pages
            else {
                $first .= "<a class='page-numbers' href=\"?page=1\">First</a>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<span class=\"current ne_bg_light_grey\">$counter</span>";
                    else
                        $pagination .= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
                }
                $last = '';
            }
        }
        if ($page < $counter - 1)
            $next_ .= "
			
			<a class='page-numbers' href=\"?page=$next\">Next</a>";
        else {
            //$pagination.= "<span class=\"disabled\">next</span>";
        }
        $pagination = "<div class=''><div class=''>
		<ul class=\"pagination\" ><li>" . $prev_ . $pagination . "</li><li>" . $next_ . $last . "</li>";
        //next button
        $pagination .= "</ul></div></div>\n";
    }
    echo $pagination;
}
?>
<style>
    .current {
        background: none repeat scroll 0 0 rgba(236, 236, 236, 1) !important;
        color: #000 !important;
        padding: 4px 8px;
    }
    /*.pagination > li > a{
        padding:8px 12px;	
        }
    .page-numbers{
        display:none;	
    }
    .ne-success-story ul{
        border-bottom:none !important;	
        
    }
    .ne-success-story li
    {
        background: none !important;
        border-bottom:none !important;	
    }*/
</style>