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
$each = !empty($_GET['religion']) ? $_GET['religion'] : "";
?>
<select name="caste[]" id="match_part_caste" data-placeholder="Any Caste"
        class="form-control mb-5 chosen-select" multiple>
    <?php foreach ($each as $rel) { ?>
        <optgroup
                label="<?php $a = mysqli_fetch_array($DatabaseCo->dbLink->query("select religion_name from religion where religion_id = $rel"));
                echo $a['religion_name']; ?>">
            <?php
            $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM caste WHERE religion_id ='$rel' and status='APPROVED' ORDER BY caste_name ASC");
            while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
                <option value="<?php echo $DatabaseCo->dbRow->caste_id ?>"><?php echo $DatabaseCo->dbRow->caste_name ?></option>
            <?php } ?>
        </optgroup>
    <?php } ?>
</select>
