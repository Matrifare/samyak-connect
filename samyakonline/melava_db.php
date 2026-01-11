<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/15/2018
 * Time: 11:18 PM
 */
include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
ini_set('display_errors', 0);

if (isset($_POST['actionfunction']) && $_POST['actionfunction'] != '') {

    $page = $_POST['page'];
    $limit = (isset($_SESSION['result_limit']) && !empty($_SESSION['result_limit'])) ? $_SESSION['result_limit'] : 10000;
    $adjacent = 2;

    $melava = "";

    $_POST['melava_city'] = 'Pune';
    $_POST['melava_name'] = '1';

    if (!empty($_POST['melava_city'])) {
        $melava .= " AND m.melava_city='" . mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['melava_city']) . "'";
    }

    if (!empty($_POST['melava_name'])) {
        $melava .= " AND m.id='" . mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['melava_name']) . "'";
    }

    if (!empty($_POST['gender'])) {
        $melava .= " AND r.gender='" . mysqli_real_escape_string($DatabaseCo->dbLink, $_POST['gender']) . "'";
    }

    $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT r.*, meu.id as user_id, meu.melava_id, meu.melava_date, m.* from register_view r
                         INNER JOIN melava_event_users meu ON r.matri_id=meu.matri_id 
                         INNER JOIN melava_events m ON m.id = meu.melava_id WHERE m.melava_date >= CURRENT_DATE " . $melava));

    $sql = "select DISTINCT r.*, meu.id as user_id, meu.melava_id, meu.melava_date, m.* from register_view r
                         INNER JOIN melava_event_users meu ON r.matri_id=meu.matri_id 
                         INNER JOIN melava_events m ON m.id = meu.melava_id WHERE m.melava_date >= CURRENT_DATE " . $melava . " ORDER BY m.melava_date DESC";

    ?>
    <?php
    $data = $DatabaseCo->dbLink->query($sql);
    if ($rows > 0) {
        pagination($limit, $adjacent, $rows, $page);
        $count = 1;
        $colCount = 0;
        $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
        if ($viewType == 'icon_view') {
            echo "<div class='row'><div class='hidden-xss hidden-xs'>
    <div class='col-sm-1'></div></div><div class='mb-10'>";
        }
        ?>

        <div class="top-hotel-grid-wrapper">
            <div class="col-5-wrapper gap-20">
                <?php
                while ($Row = mysqli_fetch_object($data)) {
                    if ($viewType == 'icon_view') {
                        @include "page-parts/samyak-grid-results-for-melava.php";
                    } else {
                        @include "page-parts/samyak-list-results.php";
                    }
                    $colCount++;
                    $count++;
                } ?>
            </div>
        </div>
        <?php

        pagination($limit, $adjacent, $rows, $page);
    } else {
        ?>
        <div class="mb-95">
            <div class="thumbnail">
                <img src="img/nodata-available.jpg">
            </div>
        </div>
        <?php
    }
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
            $prev_ .= "<li><a href=\"?page=$prev\">&laquo;</a></li>";
        else {
            //$pagination.= "<span class=\"disabled\">previous</span>";
        }

        //pages
        if ($lastpage < 5 + ($adjacents * 2))    //not enough pages to bother breaking it up
        {
            $first = '';
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                } else {
                    $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                }
            }
            $last = '';
        } elseif ($lastpage > 3 + ($adjacents * 2))    //enough pages to hide some
        {
            //close to beginning; only hide later pages
            $first = '';
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active \"><a href=\"#\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                    }
                }
                $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                    }
                }
                $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
            } //close to end; only hide early pages
            else {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a title='Login to see this page' href='login'>$counter</a></li>";
                    }
                }
                $last = '';
            }

        }
        if ($page < $counter - 1) {
            $next_ .= "<li><a class='page-numbers' href=\"?page=$next\">&raquo;</a></li>";
        } else {
            //$pagination.= "<span class=\"disabled\">next</span>";
        }
        $pagination = "<div class=\"result-paging-wrapper mb-10\"><div class=\"row\"><div class=\"col-sm-offset-6 col-sm-6\">
                    <ul class=\"paging\">
		"
            . $first . $prev_ . $pagination . $next_ . $last;
        //next button

        $pagination .= "</ul></div></div></div>\n";
    }

    echo $pagination;
}

?>


