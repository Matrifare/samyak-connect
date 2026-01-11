<?php
/**
 * Created by PhpStorm.
 * User: Manish
 * Date: 3/29/2018
 * Time: 12:45 AM
 */

include_once '../DatabaseConnection.php';
include_once '../lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
$religion_id = $_REQUEST['religionId'];
?>

<select id="register_my_caste" name="my_caste" class="form-control mb-5" required>
    <?php
    $SQL_STATEMENT = $DatabaseCo->dbLink->query("SELECT DISTINCT * FROM caste WHERE religion_id='$religion_id' and status='APPROVED' ORDER BY caste_name ASC");
    while ($DatabaseCo->dbRow = mysqli_fetch_object($SQL_STATEMENT)) { ?>
        <option value="<?php echo $DatabaseCo->dbRow->caste_id ?>"><?php echo $DatabaseCo->dbRow->caste_name ?></option>
    <?php } ?>
</select>

