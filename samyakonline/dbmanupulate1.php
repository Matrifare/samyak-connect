<?php
/**
 * Secure Search Controller
 * Uses prepared statements to prevent SQL injection
 */
include_once 'DatabaseConnection.php';
include_once 'lib/Security.php';

$DatabaseCo = new DatabaseConnection();
ini_set('display_errors', 0);

if (isset($_POST['actionfunction']) && $_POST['actionfunction'] != '') {

    $page = Security::sanitizeInt($_POST['page'] ?? 1);
    $limit = (isset($_SESSION['result_limit']) && !empty($_SESSION['result_limit'])) ? Security::sanitizeInt($_SESSION['result_limit']) : 32;
    $adjacent = 2;

    // Helper function to get value from POST or SESSION
    function getSearchValue($postKey, $sessionKey, $sanitizeFunc = 'escape') {
        $value = '';
        if ($_POST[$postKey] === '') {
            $value = $_SESSION[$sessionKey] ?? '';
        } else if ($_POST[$postKey] === 'null') {
            $value = '';
            $_SESSION[$sessionKey] = '';
        } else {
            $val = $_POST[$postKey];
            if (is_array($val)) {
                $val = implode(",", $val);
            }
            $value = $val;
            $_SESSION[$sessionKey] = $value;
        }
        return $value;
    }

    // Get and sanitize all search parameters
    $rel = getSearchValue('religion', 'religion');
    $occ = getSearchValue('occupation', 'occupation');
    $gender = getSearchValue('gender', 'gender');
    $t3 = getSearchValue('t3', 'fromage');
    $t4 = getSearchValue('t4', 'toage');
    $con = getSearchValue('country', 'country');
    $m_status = getSearchValue('m_status', 'm_status');
    $m_tongue = getSearchValue('m_tongue', 'm_tongue');
    $education_level = getSearchValue('education_level', 'education_level');
    $education_field = getSearchValue('education_field', 'education_field');
    $caste = getSearchValue('caste', 'caste');
    $state = getSearchValue('state', 'state');
    $city = getSearchValue('city', 'city');
    $familyOrigin = getSearchValue('family_origin', 'family_origin');
    $fromheight = getSearchValue('fromheight', 'fromheight');
    $toheight = getSearchValue('toheight', 'toheight');
    $photo = getSearchValue('photo_search', 'photo_search');
    $keyword = getSearchValue('keyword', 'keyword');
    $orderby = getSearchValue('orderby', 'orderby');
    $tot_children = getSearchValue('tot_children', 'tot_children');
    $annual_income = getSearchValue('annual_income', 'annual_income');
    $diet = getSearchValue('diet', 'diet');
    $drink = getSearchValue('drink', 'drink');
    $smoking = getSearchValue('smoking', 'smoking');
    $complexion = getSearchValue('complexion', 'complexion');
    $bodytype = getSearchValue('bodytype', 'bodytype');
    $star = getSearchValue('star', 'star');
    $manglik = getSearchValue('manglik', 'manglik');
    $id_search = getSearchValue('id_search', 'id_search');
    $samyak_id_search = getSearchValue('samyak_id', 'samyak_id_search');
    $samyak_search = getSearchValue('samyak_search', 'samyak_search');
    $search_by_profile_id = getSearchValue('search_by_profile_id', 'search_by_profile_id');

    if ($page == 1) {
        $start = 0;
    } else {
        $start = ($page - 1) * $limit;
    }

    // Build secure query using prepared statements
    $conditions = [];
    $params = [];
    $types = '';
    
    // User ID for blocked profiles
    $userId = $_SESSION['user_id'] ?? '';
    
    // Base condition
    $baseQuery = "FROM register_view WHERE status NOT IN ('Inactive', 'Suspended')";
    
    // Add blocked profiles exclusion
    if (!empty($userId)) {
        $baseQuery .= " AND matri_id NOT IN (SELECT block_by FROM block_profile WHERE block_to = ?)";
        $params[] = $userId;
        $types .= 's';
    }

    // Age range filter
    if ($t3 != '' && $t4 != '') {
        $t3_safe = Security::sanitizeInt($t3);
        $t4_safe = Security::sanitizeInt($t4);
        $conditions[] = "((date_format(now(), '%Y') - date_format(birthdate, '%Y')) - (date_format(now(), '00-%m-%d') < date_format(birthdate, '00-%m-%d'))) BETWEEN ? AND ?";
        $params[] = $t3_safe;
        $params[] = $t4_safe;
        $types .= 'ii';
    }

    // Gender filter
    if ($gender != '') {
        $gender_safe = Security::validateAllowed($gender, ['Groom', 'Bride'], '');
        if ($gender_safe) {
            $conditions[] = "gender = ?";
            $params[] = $gender_safe;
            $types .= 's';
        }
    }

    // Religion filter (supports multiple values)
    if ($rel != '') {
        $relIds = array_map('intval', array_filter(explode(',', $rel), 'is_numeric'));
        if (!empty($relIds)) {
            $placeholders = implode(',', array_fill(0, count($relIds), '?'));
            $conditions[] = "religion IN ($placeholders)";
            foreach ($relIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Caste filter
    if ($caste != '') {
        $casteIds = array_map('intval', array_filter(explode(',', $caste), 'is_numeric'));
        if (!empty($casteIds)) {
            $placeholders = implode(',', array_fill(0, count($casteIds), '?'));
            $conditions[] = "caste IN ($placeholders)";
            foreach ($casteIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Mother tongue filter
    if ($m_tongue != '') {
        $tongueIds = array_map('intval', array_filter(explode(',', $m_tongue), 'is_numeric'));
        if (!empty($tongueIds)) {
            $placeholders = implode(',', array_fill(0, count($tongueIds), '?'));
            $conditions[] = "m_tongue IN ($placeholders)";
            foreach ($tongueIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Education level filter
    if ($education_level != '') {
        $eduLevelIds = array_map('intval', array_filter(explode(',', str_replace("'", "", $education_level)), 'is_numeric'));
        if (!empty($eduLevelIds)) {
            $placeholders = implode(',', array_fill(0, count($eduLevelIds), '?'));
            $conditions[] = "e_level IN ($placeholders)";
            foreach ($eduLevelIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Education field filter
    if ($education_field != '') {
        $eduFieldIds = array_map('intval', array_filter(explode(',', str_replace("'", "", $education_field)), 'is_numeric'));
        if (!empty($eduFieldIds)) {
            $placeholders = implode(',', array_fill(0, count($eduFieldIds), '?'));
            $conditions[] = "e_field IN ($placeholders)";
            foreach ($eduFieldIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Occupation filter
    if ($occ != '') {
        $occIds = array_map('intval', array_filter(explode(',', $occ), 'is_numeric'));
        if (!empty($occIds)) {
            $placeholders = implode(',', array_fill(0, count($occIds), '?'));
            $conditions[] = "occupation IN ($placeholders)";
            foreach ($occIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Marital status filter
    if ($m_status != 'Any' && $m_status != '') {
        $statusList = explode(',', str_replace("'", "", $m_status));
        $placeholders = implode(',', array_fill(0, count($statusList), '?'));
        $conditions[] = "m_status IN ($placeholders)";
        foreach ($statusList as $status) {
            $params[] = trim($status);
            $types .= 's';
        }
    }

    // Country filter
    if ($con != '') {
        $conIds = array_map('intval', array_filter(explode(',', $con), 'is_numeric'));
        if (!empty($conIds)) {
            $placeholders = implode(',', array_fill(0, count($conIds), '?'));
            $conditions[] = "country_id IN ($placeholders)";
            foreach ($conIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // State filter
    if ($state != '') {
        $stateIds = array_map('intval', array_filter(explode(',', $state), 'is_numeric'));
        if (!empty($stateIds)) {
            $placeholders = implode(',', array_fill(0, count($stateIds), '?'));
            $conditions[] = "state_id IN ($placeholders)";
            foreach ($stateIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // City filter
    if ($city != '') {
        $cityIds = array_map('intval', array_filter(explode(',', $city), 'is_numeric'));
        if (!empty($cityIds)) {
            $placeholders = implode(',', array_fill(0, count($cityIds), '?'));
            $conditions[] = "city IN ($placeholders)";
            foreach ($cityIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Family origin filter
    if ($familyOrigin != '') {
        $originIds = array_map('intval', array_filter(explode(',', $familyOrigin), 'is_numeric'));
        if (!empty($originIds)) {
            $placeholders = implode(',', array_fill(0, count($originIds), '?'));
            $conditions[] = "family_origin IN ($placeholders)";
            foreach ($originIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }
    }

    // Height filter
    if ($fromheight != '' && $toheight != '') {
        $conditions[] = "height BETWEEN ? AND ?";
        $params[] = Security::sanitizeInt($fromheight);
        $params[] = Security::sanitizeInt($toheight);
        $types .= 'ii';
    }

    // Keyword search (secure LIKE with proper escaping)
    if ($keyword != '') {
        $keyword_safe = '%' . $keyword . '%';
        $keyword_exact = $keyword;
        $conditions[] = "(ocp_name LIKE ? OR matri_id = ? OR firstname LIKE ? OR lastname LIKE ? OR religion_name LIKE ? OR caste_name LIKE ? OR city_name LIKE ?)";
        $params[] = $keyword_safe;
        $params[] = $keyword_exact;
        $params[] = $keyword_safe;
        $params[] = $keyword_safe;
        $params[] = $keyword_safe;
        $params[] = $keyword_safe;
        $params[] = $keyword_safe;
        $types .= 'sssssss';
    }

    // Photo filter
    if ($photo == 'Yes') {
        $conditions[] = "photo1 != '' AND photo1_approve = 'APPROVED' AND photo_protect = 'No'";
    }

    // Children filter
    if ($tot_children != '') {
        $conditions[] = "tot_children = ?";
        $params[] = Security::escape($tot_children);
        $types .= 's';
    }

    // Income filter
    if ($annual_income != '') {
        $conditions[] = "income = ?";
        $params[] = Security::escape($annual_income);
        $types .= 's';
    }

    // Diet filter
    if ($diet != '') {
        $dietList = explode(',', str_replace("'", "", $diet));
        $placeholders = implode(',', array_fill(0, count($dietList), '?'));
        $conditions[] = "diet IN ($placeholders)";
        foreach ($dietList as $d) {
            $params[] = trim($d);
            $types .= 's';
        }
    }

    // Drink filter
    if ($drink != '') {
        $drinkList = explode(',', str_replace("'", "", $drink));
        $placeholders = implode(',', array_fill(0, count($drinkList), '?'));
        $conditions[] = "drink IN ($placeholders)";
        foreach ($drinkList as $d) {
            $params[] = trim($d);
            $types .= 's';
        }
    }

    // Smoking filter
    if ($smoking != '') {
        $smokingList = explode(',', str_replace("'", "", $smoking));
        $placeholders = implode(',', array_fill(0, count($smokingList), '?'));
        $conditions[] = "smoke IN ($placeholders)";
        foreach ($smokingList as $s) {
            $params[] = trim($s);
            $types .= 's';
        }
    }

    // Complexion filter
    if ($complexion != '') {
        $complexionList = explode(',', str_replace("'", "", $complexion));
        $placeholders = implode(',', array_fill(0, count($complexionList), '?'));
        $conditions[] = "complexion IN ($placeholders)";
        foreach ($complexionList as $c) {
            $params[] = trim($c);
            $types .= 's';
        }
    }

    // Body type filter
    if ($bodytype != '') {
        $bodyList = explode(',', str_replace("'", "", $bodytype));
        $placeholders = implode(',', array_fill(0, count($bodyList), '?'));
        $conditions[] = "bodytype IN ($placeholders)";
        foreach ($bodyList as $b) {
            $params[] = trim($b);
            $types .= 's';
        }
    }

    // Star filter
    if ($star != '') {
        $starList = explode(',', str_replace("'", "", $star));
        $placeholders = implode(',', array_fill(0, count($starList), '?'));
        $conditions[] = "star IN ($placeholders)";
        foreach ($starList as $s) {
            $params[] = trim($s);
            $types .= 's';
        }
    }

    // Manglik filter
    if ($manglik != '') {
        $conditions[] = "manglik = ?";
        $params[] = Security::escape($manglik);
        $types .= 's';
    }

    // ID search filter
    if ($id_search != '') {
        $conditions[] = "matri_id = ?";
        $params[] = Security::sanitizeProfileId($id_search);
        $types .= 's';
    }

    // Samyak ID search
    if ($samyak_id_search != '') {
        $conditions[] = "samyak_id = ?";
        $params[] = Security::sanitizeProfileId($samyak_id_search);
        $types .= 's';
    }

    // Samyak member search
    if ($samyak_search != '') {
        $conditions[] = "samyak_id != ''";
    }

    // Search by profile ID
    if ($search_by_profile_id != '') {
        $profileId = Security::sanitizeProfileId($search_by_profile_id);
        if (substr($profileId, 0, 1) == 'S') {
            $_SESSION['samyak_search'] = 'Yes';
            $conditions[] = "samyak_id = ?";
        } else {
            unset($_SESSION['samyak_search']);
            $conditions[] = "matri_id = ?";
        }
        $params[] = $profileId;
        $types .= 's';
    }

    // Build WHERE clause
    $whereClause = '';
    if (!empty($conditions)) {
        $whereClause = ' AND ' . implode(' AND ', $conditions);
    }

    // Order by clause (whitelist approach)
    $orderClause = '';
    if ($orderby == 'register') {
        $orderClause = " ORDER BY reg_date DESC";
    } else if ($orderby == 'login') {
        $orderClause = " ORDER BY last_login DESC";
    }

    // Count query
    $countSql = "SELECT COUNT(DISTINCT index_id) as total $baseQuery $whereClause";
    $stmt = $DatabaseCo->dbLink->prepare($countSql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $countResult = $stmt->get_result();
    $countRow = $countResult->fetch_assoc();
    $rows = $countRow['total'];
    $stmt->close();

    // Main query
    $selectSql = "SELECT DISTINCT firstname, username, m_status, last_login, photo1, photo1_approve, photo_protect, 
                  photo_view_status, matri_id, samyak_id, photo_pswd, gender, email, status, hor_photo, hor_check, 
                  video, video_url, profile_text, video_approval, birthdate, height, religion_name, caste_name, 
                  mtongue_name, edu_name, city_name, country_name, state_name, ocp_name, logged_in, index_id 
                  $baseQuery $whereClause $orderClause LIMIT ?, ?";
    
    $stmt = $DatabaseCo->dbLink->prepare($selectSql);
    $params[] = $start;
    $params[] = $limit;
    $types .= 'ii';
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $data = $stmt->get_result();
    $stmt->close();
    ?>
    <div class="result-status">
        <p>We found <span class="text-primary font700"><?= Security::escape($rows) ?></span> results.</p>
    </div>
    <?php

    if ($rows > 0) {
        pagination($limit, $adjacent, $rows, $page);
        $colCount = 0;
        $viewType = (isset($_SESSION['result_view_type']) && !empty($_SESSION['result_view_type'])) ? $_SESSION['result_view_type'] : 'icon_view';
        if ($viewType == 'icon_view') {
            echo "<div class='row'><div class='mb-10'>";
        }
        ?>

        <div class="top-hotel-grid-wrapper">
            <div class="col-5-wrapper gap-20">
                <?php
                while ($Row = mysqli_fetch_object($data)) {
                    if ($viewType == 'icon_view') {
                        @include "page-parts/samyak-grid-results.php";
                    } else {
                        @include "page-parts/samyak-list-results.php";
                    }
                    $colCount++;
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
    if ($page == 0) $page = 1;
    $prev = $page - 1;
    $next = $page + 1;
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

        if ($lastpage < 5 + ($adjacents * 2)) {
            $first = '';
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                } else {
                    if ($isLoggedIn) {
                        $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                    } else {
                        $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                    }
                }
            }
            $last = '';
        } elseif ($lastpage > 3 + ($adjacents * 2)) {
            $first = '';
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active \"><a href=\"#\">$counter</a></li>";
                    } else {
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                        }
                    }
                }
                $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
                        }
                    }
                }
                if ($isLoggedIn) {
                    $last .= "<li><a class='page-numbers' href=\"?page=$lastpage\">Last</a></li>";
                } else {
                    $last .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">Last</a></li>";
                }
            } else {
                $first .= "<li><a class='page-numbers' href=\"?page=1\">First</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class=\"active page-numbers\"><a href=\"#\">$counter</a></li>";
                    } else {
                        if ($isLoggedIn) {
                            $pagination .= "<li><a class='page-numbers' href=\"?page=$counter\">$counter</a></li>";
                        } else {
                            $pagination .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">$counter</a></li>";
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
                $next_ .= "<li><a title='Login to see this page' data-toggle='modal' class='' href=\"#loginModal\">&raquo;</a></li>";
            }
        }
        $pagination = "<div class=\"result-paging-wrapper mb-10\"><div class=\"row\"><div class=\"col-sm-offset-6 col-sm-6\">
                    <ul class=\"paging\">
		"
            . $first . $prev_ . $pagination . $next_ . $last;

        $pagination .= "</ul></div></div></div>\n";
    }

    echo $pagination;
}

?>
