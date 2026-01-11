<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/30/2018
 * Time: 12:30 AM
 */
include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';

$DatabaseCo = new DatabaseConnection();
$religion_id = isset($_REQUEST['religion']) ? $_REQUEST['religion'] : '';

// Validate and sanitize religion IDs
$each = array_filter(array_map('intval', explode(',', $religion_id)));

if (empty($each)) {
    echo '<select name="part_caste_id[]" id="register_part_caste" data-placeholder="Partner Caste" class="form-control mb-5 chosen-select" multiple></select>';
    exit;
}
?>
<select name="part_caste_id[]" id="register_part_caste" data-placeholder="Partner Caste" class="form-control mb-5 chosen-select" multiple>
    <?php foreach ($each as $rel) { 
        // Use prepared statement for religion name
        $stmt = $DatabaseCo->dbLink->prepare("SELECT religion_name FROM religion WHERE religion_id = ?");
        $stmt->bind_param("i", $rel);
        $stmt->execute();
        $result = $stmt->get_result();
        $religionRow = $result->fetch_assoc();
        $stmt->close();
        
        if ($religionRow) { ?>
        <optgroup label="<?php echo htmlspecialchars($religionRow['religion_name'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php
            // Use prepared statement for caste list
            $stmtCaste = $DatabaseCo->dbLink->prepare("SELECT DISTINCT caste_id, caste_name FROM caste WHERE religion_id = ? AND status = 'APPROVED' ORDER BY caste_name ASC");
            $stmtCaste->bind_param("i", $rel);
            $stmtCaste->execute();
            $casteResult = $stmtCaste->get_result();
            
            while ($row = $casteResult->fetch_object()) { ?>
                <option value="<?php echo (int)$row->caste_id; ?>"><?php echo htmlspecialchars($row->caste_name, ENT_QUOTES, 'UTF-8'); ?></option>
            <?php } 
            $stmtCaste->close();
            ?>
        </optgroup>
        <?php } 
    } ?>
</select>
