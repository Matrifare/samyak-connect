<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 14/01/2022
 * Time: 07:49 PM
 */

/**
 * @Desc - fb_id => Used for hiding the profile
 */
include_once 'DatabaseConnection.php';
$DatabaseCo = new DatabaseConnection();
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_POST['actionfunction']) && $_POST['actionfunction'] != '') {

    $page = $_POST['page'];
    $limit = (isset($_SESSION['result_limit']) && !empty($_SESSION['result_limit'])) ? $_SESSION['result_limit'] : 18;
    $adjacent = 2;


    if ($_POST['religion'] == '') {
        $rel = $_SESSION['religion'];
    } else if ($_POST['religion'] == 'null') {
        $rel = '';
        $_SESSION['religion'] = $rel;
    } else {
        if (is_array($_POST['religion'])) {
            $_POST['religion'] = implode(", ", $_POST['religion']);
        }
        $rel = $_POST['religion'];
        $_SESSION['religion'] = $rel;
    }


    if ($_POST['occupation'] == '') {
        $occ = $_SESSION['occupation'];
    } else if ($_POST['occupation'] == 'null') {
        $occ = '';
        $_SESSION['occupation'] = $occ;
    } else {
        if (is_array($_POST['occupation'])) {
            $_POST['occupation'] = implode(", ", $_POST['occupation']);
        }
        $occ = $_POST['occupation'];
        $_SESSION['occupation'] = $occ;
    }


    if ($_POST['gender'] == '') {
        $gender = $_SESSION['gender'];
    } else {
        $gender = $_POST['gender'];
        $_SESSION['gender'] = $gender;
    }


    if ($_POST['t3'] == '') {
        $t3 = $_SESSION['fromage'];
    } else if ($_POST['t3'] == 'null') {
        $t3 = '';
        $_SESSION['fromage'] = $t3;
    } else {
        $t3 = $_POST['t3'];
        $_SESSION['fromage'] = $t3;
    }

    if ($_POST['t4'] == '') {
        $t4 = $_SESSION['toage'];
    } else if ($_POST['t4'] == 'null') {
        $t4 = '';
        $_SESSION['toage'] = $t4;
    } else {
        $t4 = $_POST['t4'];
        $_SESSION['toage'] = $t4;
    }
    if ($_POST['country'] == '') {
        $con = $_SESSION['country'];
    } else if ($_POST['country'] == 'null') {
        $con = '';
        $_SESSION['country'] = $con;
    } else {
        if (is_array($_POST['country'])) {
            $_POST['country'] = implode(", ", $_POST['country']);
        }
        $con = $_POST['country'];
        $_SESSION['country'] = $con;
    }

    if (!(isset($_POST['other_caste'])) && isset($_SESSION['other_caste'])) {
        $otherCaste = $_SESSION['other_caste'];
    } elseif (isset($_POST['other_caste'])) {
        $otherCaste = $_POST['other_caste'];
        $_SESSION['other_caste'] = $otherCaste;
    } else {
        $otherCaste = '';
    }

    if (!isset($_POST['special_case']) && isset($_SESSION['special_case'])) {
        $specialCase = $_SESSION['special_case'];
    } elseif (isset($_POST['special_case']) && is_array($_POST['special_case'])) {
        $specialCase = implode(",", $_POST['special_case']);
        $_SESSION['special_case'] = $specialCase;
    } else if (isset($_POST['special_case'])) {
        $_SESSION['special_case'] = $_POST['special_case'];
        $specialCase = $_SESSION['special_case'];
    } else {
        $specialCase = '';
    }


    if ($_POST['m_status'] == '') {
        $m_status = $_SESSION['m_status'];
    } else if ($_POST['m_status'] == 'null') {
        $m_status = '';
        $_SESSION['m_status'] = $m_status;
    } else {
        if (is_array($_POST['m_status'])) {
            $_POST['m_status'] = implode(",", $_POST['m_status']);
        }
        $m_status = str_replace(",", "','", $_POST['m_status']);
        $_SESSION['m_status'] = $m_status;
    }
    if ($_POST['m_tongue'] == '') {
        $m_tongue = $_SESSION['m_tongue'];
    } else if ($_POST['m_tongue'] == 'null') {
        $m_tongue = '';
        $_SESSION['m_tongue'] = $m_tongue;
    } else {
        $m_tongue = $_POST['m_tongue'];
        $_SESSION['m_tongue'] = $m_tongue;
    }

    if ($_POST['education_level'] == '') {
        $education_level = $_SESSION['education_level'];
    } else if ($_POST['education_level'] == 'null') {
        $education_level = '';
        $_SESSION['education_level'] = $education_level;
    } else {
        if (is_array($_POST['education_level'])) {
            $_POST['education_level'] = implode(",", $_POST['education_level']);
        }
        $education_level = str_replace(",", "','", $_POST['education_level']);
        $_SESSION['education_level'] = $education_level;
    }

    if ($_POST['education_field'] == '') {
        $education_field = $_SESSION['education_field'];
    } else if ($_POST['education_field'] == 'null') {
        $education_field = '';
        $_SESSION['education_field'] = $education_field;
    } else {
        if (is_array($_POST['education_field'])) {
            $_POST['education_field'] = implode(",", $_POST['education_field']);
        }
        $education_field = str_replace(",", "','", $_POST['education_field']);
        $_SESSION['education_field'] = $education_field;
    }
    if ($_POST['caste'] == '') {
        $caste = $_SESSION['caste'];
    } else if ($_POST['caste'] == 'null') {
        $caste = '';
        $_SESSION['caste'] = $caste;
    } else {
        if (is_array($_POST['caste'])) {
            $_POST['caste'] = implode(", ", $_POST['caste']);
        }
        $caste = $_POST['caste'];
        $_SESSION['caste'] = $caste;
    }
    if ($_POST['state'] == '') {
        $state = $_SESSION['state'];
    } else if ($_POST['state'] == 'null') {
        $state = '';
        $_SESSION['state'] = $state;
    } else {
        $state = $_POST['state'];
        $_SESSION['state'] = $state;
    }
    if ($_POST['city'] == '') {
        $city = $_SESSION['city'];
    } else if ($_POST['city'] == 'null') {
        $city = '';
        $_SESSION['city'] = $city;
    } else {
        if (is_array($_POST['city'])) {
            $_POST['city'] = implode(", ", $_POST['city']);
        }
        $city = $_POST['city'];
        $_SESSION['city'] = $city;
    }

    if ($_POST['family_origin'] == '') {
        $familyOrigin = $_SESSION['family_origin'];
    } else if ($_POST['family_origin'] == 'null') {
        $familyOrigin = '';
        $_SESSION['family_origin'] = $familyOrigin;
    } else {
        if (is_array($_POST['family_origin'])) {
            $_POST['family_origin'] = implode(", ", $_POST['family_origin']);
        }
        $familyOrigin = $_POST['family_origin'];
        $_SESSION['family_origin'] = $familyOrigin;
    }
    if ($_POST['fromheight'] == '') {
        $fromheight = $_SESSION['fromheight'];
    } else if ($_POST['fromheight'] == 'null') {
        $fromheight = '';
        $_SESSION['fromheight'] = $fromheight;
    } else {
        $fromheight = $_POST['fromheight'];
        $_SESSION['fromheight'] = $fromheight;
    }
    if ($_POST['toheight'] == '') {
        $toheight = $_SESSION['toheight'];
    } else if ($_POST['toheight'] == 'null') {
        $toheight = '';
        $_SESSION['toheight'] = $toheight;
    } else {
        $toheight = $_POST['toheight'];
        $_SESSION['toheight'] = $toheight;
    }
    if ($_POST['photo_search'] == '') {
        $photo = $_SESSION['photo_search'];
    } else if ($_POST['photo_search'] == 'null') {
        $photo = '';
        $_SESSION['photo_search'] = $photo;
    } else {
        $photo = $_POST['photo_search'];
        $_SESSION['photo_search'] = $photo;
    }
    if ($_POST['keyword'] == '') {
        $keyword = $_SESSION['keyword'];
    } else if ($_POST['photo_search'] == 'null') {
        $keyword = '';
        $_SESSION['keyword'] = $keyword;
    } else {
        $keyword = $_POST['keyword'];
        $_SESSION['keyword'] = $keyword;
    }
    if ($_POST['orderby'] == '') {
        $orderby = $_SESSION['orderby'];
    } else if ($_POST['orderby'] == 'null') {
        $orderby = '';
        $_SESSION['orderby'] = $orderby;
    } else {
        $orderby = $_POST['orderby'];
        $_SESSION['orderby'] = $orderby;
    }

    if ($_POST['tot_children'] == '') {
        $tot_children = $_SESSION['tot_children'];
    } else if ($_POST['tot_children'] == 'null') {
        $tot_children = '';
        $_SESSION['tot_children'] = $tot_children;
    } else {
        $tot_children = $_POST['tot_children'];
        $_SESSION['tot_children'] = $tot_children;
    }

    if ($_POST['occupation'] == '') {
        $occupation = $_SESSION['occupation'];
    } else if ($_POST['occupation'] == 'null') {
        $occupation = '';
        $_SESSION['occupation'] = $occupation;
    } else {
        if (is_array($_POST['occupation'])) {
            $_POST['occupation'] = implode(", ", $_POST['occupation']);
        }
        $occupation = $_POST['occupation'];
        $_SESSION['occupation'] = $occupation;
    }


    if ($_POST['annual_income'] == '') {
        $annual_income = $_SESSION['annual_income'];
    } else if ($_POST['annual_income'] == 'null') {
        $annual_income = '';
        $_SESSION['annual_income'] = $annual_income;
    } else {
        $annual_income = $_POST['annual_income'];
        $_SESSION['annual_income'] = $annual_income;
    }

    if ($_POST['diet'] == '') {
        $diet = $_SESSION['diet'];
    } else if ($_POST['diet'] == 'null') {
        $diet = '';
        $_SESSION['diet'] = $diet;
    } else {
        $diet = str_replace(",", "','", $_POST['diet']);
        $_SESSION['diet'] = $diet;
    }

    if ($_POST['drink'] == '') {
        $drink = $_SESSION['drink'];
    } else if ($_POST['drink'] == 'null') {
        $drink = '';
        $_SESSION['drink'] = $drink;
    } else {
        $drink = str_replace(",", "','", $_POST['drink']);
        $_SESSION['drink'] = $drink;
    }

    if ($_POST['smoking'] == '') {
        $smoking = $_SESSION['smoking'];
    } else if ($_POST['smoking'] == 'null') {
        $smoking = '';
        $_SESSION['smoking'] = $smoking;
    } else {
        $smoking = str_replace(",", "','", $_POST['smoking']);
        $_SESSION['smoking'] = $smoking;
    }

    if ($_POST['complexion'] == '') {
        $complexion = $_SESSION['complexion'];
    } else if ($_POST['complexion'] == 'null') {
        $complexion = '';
        $_SESSION['complexion'] = $complexion;
    } else {
        if (is_array($_POST['complexion'])) {
            $_POST['complexion'] = implode(",", $_POST['complexion']);
        }
        $complexion = str_replace(",", "','", $_POST['complexion']);
        $_SESSION['complexion'] = $complexion;
    }

    if ($_POST['bodytype'] == '') {
        $bodytype = $_SESSION['bodytype'];
    } else if ($_POST['bodytype'] == 'null') {
        $bodytype = '';
        $_SESSION['bodytype'] = $bodytype;
    } else {
        $bodytype = str_replace(",", "','", $_POST['bodytype']);
        $_SESSION['bodytype'] = $bodytype;
    }

    if ($_POST['star'] == '') {
        $star = $_SESSION['star'];
    } else if ($_POST['star'] == 'null') {
        $star = '';
        $_SESSION['star'] = $star;
    } else {
        $star = str_replace(",", "','", $_POST['star']);
        $_SESSION['star'] = $star;
    }

    if ($_POST['manglik'] == '') {
        $manglik = $_SESSION['manglik'];
    } else if ($_POST['manglik'] == 'null') {
        $manglik = '';
        $_SESSION['manglik'] = $manglik;
    } else {
        $manglik = $_POST['manglik'];
        $_SESSION['manglik'] = $manglik;
    }

    if ($_POST['id_search'] == '') {
        $id_search = $_SESSION['id_search'];
    } else if ($_POST['id_search'] == 'null') {
        $id_search = '';
        $_SESSION['id_search'] = $id_search;
    } else {
        $id_search = $_POST['id_search'];
        $_SESSION['id_search'] = $id_search;
    }

    if ($_POST['samyak_id'] == '') {
        $samyak_id_search = $_SESSION['samyak_id_search'];
    } else if ($_POST['samyak_id'] == 'null') {
        $samyak_id_search = '';
        $_SESSION['samyak_id_search'] = $samyak_id_search;
    } else {
        $samyak_id_search = $_POST['samyak_id'];
        $_SESSION['samyak_id_search'] = $samyak_id_search;
    }

    if ($_POST['samyak_search'] == '') {
        $samyak_search = $_SESSION['samyak_search'];
    } else if ($_POST['samyak_search'] == 'null') {
        $samyak_search = '';
        $_SESSION['samyak_search'] = $samyak_search;
    } else {
        $samyak_search = $_POST['samyak_search'];
        $_SESSION['samyak_search'] = $samyak_search;
    }


    if ($_POST['search_by_profile_id'] == '') {
        $search_by_profile_id = $_SESSION['search_by_profile_id'];
    } else if ($_POST['search_by_profile_id'] == 'null') {
        $search_by_profile_id = '';
        $_SESSION['search_by_profile_id'] = $search_by_profile_id;
    } else {
        $search_by_profile_id = $_POST['search_by_profile_id'];
        $_SESSION['search_by_profile_id'] = $search_by_profile_id;
    }


    if ($page == 1) {
        $start = 0;
    } else {
        $start = ($page - 1) * $limit;
    }

    if ($t3 != '' && $t4 != '') {
        $a = "AND ((
			(
			date_format( now( ) , '%Y' ) - date_format( birthdate, '%Y' )
			) - ( date_format( now( ) , '00-%m-%d' ) < date_format( birthdate, '00-%m-%d' ) )
			)
			BETWEEN '$t3'
			AND '$t4')";
    } else {
        $a = '';
    }

    if ($gender != '') {
        $b = "and gender='$gender'";
    } else {
        $b = '';
    }

    if ($rel != '') {
        $c = "and religion IN ($rel)";
    } else {
        $c = '';
    }

    if ($caste != '') {
        $d = "and caste IN ($caste)";
    } else {
        $d = '';
    }

    if ($otherCaste != '') {
        $sqlOtherCaste = "and other_caste='$otherCaste'";
    } else {
        $sqlOtherCaste = '';
    }

    if ($specialCase != '') {
        $sqlSpecialCase = "and disability = '$specialCase'";
    } else {
        $sqlSpecialCase = '';
    }

    if ($m_tongue != '') {

        $e = "and m_tongue IN ($m_tongue)";
    } else {
        $e = '';
    }

    if ($education_level != '') {
        $search_array3 = explode(',', $education_level);
        foreach ($search_array3 as $value3) {
            $d1 .= "(find_in_set($value3, e_level) > 0) or ";
        }
        $d2 = rtrim($d1, "or ");
        $f_level = "and e_level IN ('$education_level')";
    } else {
        $f_level = '';
    }

    if ($education_field != '') {
        $search_array3 = explode(',', $education_field);
        foreach ($search_array3 as $value3) {
            $d1 .= "(find_in_set($value3, e_field) > 0) or ";
        }
        $d2 = rtrim($d1, "or ");
        $f = "and e_field IN ('$education_field')";
    } else {
        $f = '';
    }
    if ($occ != '') {
        $g = "and occupation IN ($occ)";
    } else {
        $g = '';
    }

    if ($m_status != 'Any' && $m_status != '') {
        $h = "and m_status IN ('$m_status')";
    } else {
        $h = '';
    }

    if ($con != '') {

        $i = "and country_id IN ($con)";
    } else {
        $i = '';
    }

    if ($state != '') {
        $j = "and state_id IN ($state)";
    } else {
        $j = '';
    }

    if ($city != '') {

        $k = "and city IN ($city)";
    } else {
        $k = '';
    }

    if ($familyOrigin != '') {
        $family = "and family_origin IN ($familyOrigin)";
    } else {
        $family = '';
    }

    if ($fromheight != '') {
        $l = "and height between '$fromheight' and '$toheight'";
    } else {
        $l = '';
    }

    if ($keyword != '') {
        $m = "and ((ocp_name like '%$keyword%') OR (matri_id = '$keyword') OR (firstname like '%$keyword%') OR (lastname like '%$keyword%') OR (religion_name like '%$keyword%') OR (caste_name like '%$keyword%') OR (city_name like '%$keyword%'))";
    } else {
        $m = '';
    }

    if ($photo == 'Yes') {
        $n = " and photo1!='' and photo1_approve='APPROVED' and photo_protect='No'";
    } else {
        $n = '';
    }

    if ($orderby != '' && $orderby == 'register') {
        $o = "order by reg_date DESC";
    } else if ($orderby != '' && $orderby == 'login') {
        $o = "order by last_login DESC";
    } else if ($orderby != '' && $orderby == 'premium') {
        $o = "order by pactive_dt DESC";
    } else {
        $o = '';
    }

    if ($tot_children != '') {
        $q = "and tot_children='$tot_children'";
    } else {
        $q = '';
    }


    if ($annual_income != '') {
        $s = "and income='$annual_income'";
    } else {
        $s = '';
    }

    if ($diet != '') {
        $t = "and diet IN ('$diet')";
    } else {
        $t = '';
    }

    if ($drink != '') {
        $u = "and drink IN ('$drink')";
    } else {
        $u = '';
    }

    if ($smoking != '') {
        $v = "and smoke IN ('$smoking')";
    } else {
        $v = '';
    }

    if ($complexion != '') {
        $x = "and complexion IN ('$complexion')";
    } else {
        $x = '';
    }

    if ($bodytype != '') {
        $y = "and bodytype IN ('$bodytype')";
    } else {
        $y = '';
    }

    if ($star != '') {
        $z = "and star IN ('$star')";
    } else {
        $z = '';
    }

    if ($manglik != '') {
        $a1 = "and manglik='$manglik'";
    } else {
        $a1 = '';
    }

    if ($id_search != '') {
        $r = "and (matri_id IN ('$id_search') OR samyak_id IN ('$id_search')) AND (fb_id='1' OR fb_id='2')";
    } else {
        $r = 'AND fb_id!="2"';
    }
    if ($samyak_id_search != '') {
        $samyak = "and (samyak_id IN ('$samyak_id_search') OR matri_id IN ('$samyak_id_search')) AND (fb_id='1' OR fb_id='2')";
    } else {
        $samyak = "and fb_id!='2'";
    }
    if ($samyak_search != '') {
        $samyakSearch = "and samyak_id != ''";
    } else {
        $samyakSearch = "";
    }
    if ($search_by_profile_id != '') {
        $searchByProfileId = "";
        if (substr($search_by_profile_id, 0, 1) == 'S') {
            $_SESSION['samyak_search'] = 'Yes';
            $searchByProfileId = "and (samyak_id IN ('$search_by_profile_id') OR matri_id IN ('$search_by_profile_id'))";
        } else if (substr($search_by_profile_id, 0, 1) != 'S') {
            unset($_SESSION['samyak_search']);
            $searchByProfileId = "and (matri_id IN ('$search_by_profile_id') OR samyak_id IN ('$search_by_profile_id'))";
        }
    }

    unset($_SESSION['premium_profiles']);
    $condition = "AND r.mobile_verify_status='Yes' and p.p_plan!='Free' AND 
        p.p_plan IN ('Silver', 'Gold', 'Premium', 'Premium Plus', 'Gold Plus')";
    $_SESSION['premium_profiles'] = "select DISTINCT firstname,username,m_status, last_login,photo1,photo1_approve,
                                    photo_protect,photo_view_status,matri_id,samyak_id,photo_pswd,gender,email,status,
                                    profile_text,birthdate,height,religion_name,caste_name,mtongue_name,family_city,
                                    edu_name,city_name,country_name,state_name,ocp_name,logged_in,index_id,reg_date,
                                    p.p_plan,p.pactive_dt from register_view r INNER JOIN payments p ON matri_id=pmatri_id 
                                    where status NOT IN ('Inactive', 'Suspended') and 
                                    matri_id NOT IN (select block_by from block_profile where block_to='" . $_SESSION['user_id'] . "') AND 
                                    matri_id NOT IN ('" . $_SESSION['user_id'] . "')
                                     $a $b $c $d $e $f_level $f $g $h $i $j $k $family $l $m 
                                       and photo1!='' and photo1_approve='APPROVED' and photo_protect='No'
                                      $q $s $sqlOtherCaste 
                                     $sqlSpecialCase $condition $samyak $samyakSearch $searchByProfileId $t $u $v $x $y $z $a1 $r
                                      order by pactive_dt DESC limit 24";

    if ($orderby != '' && $orderby == 'premium') {
        $condition = "AND r.mobile_verify_status='Yes' and p.p_plan!='Free' AND p.p_plan IN ('Silver', 'Gold', 'Premium', 'Premium Plus', 'Gold Plus')";
        $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select r.index_id from register_view r INNER JOIN payments p ON r.matri_id=p.pmatri_id where status NOT IN ('Inactive', 'Suspended') and matri_id NOT IN (select block_by from block_profile where block_to='" . $_SESSION['user_id'] . "') $a $b $c $d $e $f_level $f $g $h $i $j $k $family $l $m $n $q $s $sqlOtherCaste $sqlSpecialCase $condition $samyak $samyakSearch $searchByProfileId $t $u $v $x $y $z $a1 $r"));

        $sql = "select DISTINCT firstname,username,m_status, last_login,photo1,photo1_approve,photo_protect,photo_view_status,matri_id,samyak_id,photo_pswd,gender,email,status,profile_text,birthdate,height,religion_name,caste_name,mtongue_name,family_city,edu_name,city_name,country_name,state_name,ocp_name,logged_in,index_id,reg_date,photo_view_status,p.p_plan from register_view r INNER JOIN payments p ON matri_id=pmatri_id where status NOT IN ('Inactive', 'Suspended') and matri_id NOT IN (select block_by from block_profile where block_to='" . $_SESSION['user_id'] . "') $a $b $c $d $e $f_level $f $g $h $i $j $k $family $l $m $n $q $s $sqlOtherCaste $sqlSpecialCase $condition $samyak $samyakSearch $searchByProfileId $t $u $v $x $y $z $a1 $r $o limit $start,$limit";

    } else {
        $condition = "AND mobile_verify_status='Yes'";
        $rows = mysqli_num_rows($DatabaseCo->dbLink->query("select DISTINCT index_id from register_view where status NOT IN ('Inactive', 'Suspended') and matri_id NOT IN (select block_by from block_profile where block_to='" . $_SESSION['user_id'] . "') $a $b $c $d $e $f_level $f $g $h $i $j $k $family $l $m $n $q $s $sqlOtherCaste $sqlSpecialCase $condition $samyak $samyakSearch $searchByProfileId $t $u $v $x $y $z $a1 $r"));

        $sql = "select DISTINCT firstname,username,m_status, last_login,photo1,photo1_approve,photo2,photo2_approve,photo3,photo3_approve,photo4,photo4_approve,photo_protect,photo_view_status,matri_id,samyak_id,photo_pswd,gender,email,status,hor_photo,hor_check,r.video,r.video_url,profile_text,video_approval,birthdate,height,religion_name,caste_name,mtongue_name,family_city,edu_name,city_name,country_name,state_name,ocp_name,logged_in,index_id,reg_date,photo_view_status,p.p_plan from register_view r INNER JOIN payments p ON r.matri_id = p.pmatri_id where status NOT IN ('Inactive', 'Suspended') and matri_id NOT IN (select block_by from block_profile where block_to='" . $_SESSION['user_id'] . "') $a $b $c $d $e $f_level $f $g $h $i $j $k $family $l $m $n $q $s $sqlOtherCaste $sqlSpecialCase $condition $samyak $samyakSearch $searchByProfileId $t $u $v $x $y $z $a1 $r $o limit $start,$limit";
    }

    $data = $DatabaseCo->dbLink->query($sql);

    if ($rows > 0) {
        while ($Row = mysqli_fetch_object($data)) {
            @include "page-parts/samyak-seo-results.php";
            $colCount++;
        }
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
    $isLoggedIn = false;
    if (!empty($_SESSION['user_name']) && !empty($_SESSION['user_id'])) {
        $isLoggedIn = true;
    }
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
                    if ($isLoggedIn) {
                        $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a title='Login to see this page' class='' href='login'>$counter</a></li>";
                    }
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
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' href='login'>$counter</a></li>";
                        }
                    }
                }
                if ($isLoggedIn) {
                    $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
                } else {
                    $last .= "<li><a title='Login to see this page' href='login'>Last</a></li>";
                }
            } //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' href='login'>$counter</a></li>";
                        }
                    }
                }
                if ($isLoggedIn) {
                    $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
                } else {
                    $last .= "<li><a title='Login to see this page' href='login'>Last</a></li>";
                }
            } //close to end; only hide early pages
            else {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' href='login'>$counter</a></li>";
                        }
                    }
                }
                $last = '';
            }

        }
        if ($page < $counter - 1) {
            if ($isLoggedIn) {
                $next_ .= "<li><a class='page-numbers' href=\"?page=$next\">&raquo;</a></li>";
            } else {
                $next_ .= "<li><a title='Login to see this page' href='login'>&raquo;</a></li>";
            }
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


