<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 5/12/2018
 * Time: 8:34 PM
 */
function pagination($limit, $adjacents, $rows, $page, $type, $subType)
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

        if ($page > 1) {
            $prev_ .= "<li><a href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$prev\");'>&laquo;</a></li>";
        } else {
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
                    $pagination .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$counter\");'>$counter</a></li>";
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
                        $pagination .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$counter\");'>$counter</a></li>";
                    }
                }
                $last .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$lastpage\");'>Last</a></li>";
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"1\");'>First</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$counter\");'>$counter</a></li>";
                    }
                }
                $last .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$lastpage\");'>Last</a></li>";
            } //close to end; only hide early pages
            else {
                $first .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"1\");'>First</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$counter\");'>$counter</a></li>";
                    }
                }
                $last = '';
            }

        }
        if ($page < $counter - 1) {
            $next_ .= "<li><a class='page-numbers' href='javascript:void(0);' onclick='interest(\"#detailTab > li.active > a\", \"$type\", \"$subType\", \"$next\");'>&raquo;</a></li>";
        } else {
            //$pagination.= "<span class=\"disabled\">next</span>";
        }
        $pagination = "<div class=\"result-paging-wrapper mb-10\"><div class=\"row\"><div class=\"col-sm-12\">
                    <ul class=\"paging\">
		"
            . $first . $prev_ . $pagination . $next_ . $last;
        //next button

        $pagination .= "</ul></div></div></div>\n";
    }

    echo $pagination;
}