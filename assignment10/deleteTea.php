<?php 
include 'top.php'; 

if (isset($_GET['id1'])) {
	$toast = htmlentities($_GET['id1'], ENT_QUOTES, "UTF-8");
}
if (isset($_GET['id2'])) {
	$potato = htmlentities($_GET['id2'], ENT_QUOTES, "UTF-8");
}

$pmkTeaName = str_replace("Q", " ", $toast);
$fldBrand = str_replace("Q", " ", $potato);

$sendTo = array();
$sendTo[] = $pmkTeaName;
$sendTo[] = $fldBrand;

$query = 'SELECT fldType FROM tblTea WHERE pmkTeaName = ? AND fldBrand = ?';
$results = $thisDatabaseReader->select($query, $sendTo, 1, 1, 0, 0, false, false);

if (isset($_POST["btnSubmit"])) { 

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'DELETE FROM tblTea WHERE pmkTeaName = ? AND fldBrand = ?';
	$results = $thisDatabaseWriter->delete($query, $sendTo, 1, 1, 0, 0, false, false);
	$primaryKey = $thisDatabaseWriter->lastInsert();

	$dataEntered = $thisDatabaseWriter->db->commit();

	// if ($results) {
	// 	print 'Deleted';
	// } else {
	// 	print 'It didn\'t work.';
	// }

	} catch (PDOException $e) {
		$thisDatabaseWriter->db->rollback();
		if ($debug)
		    print "Error!: " . $e->getMessage() . "</br>";
		$errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
	}
}
?>

<div class="content">
	<article>

	<?php
	if (isset($_POST["btnSubmit"])) { // start body submit
		print 'SUBMIT DELETE';
	} else {
	?>
		<form action="<?php print $phpSelf . '?id1=' . $pmkTeaName . '&id2=' . $fldBrand ; ?>" method="post">
			<?php print '<p>Confirm Deleting Record: ' . $pmkTeaName . ' ' . $results[0]['fldType'] . ' ' . $fldBrand . '?'; ?>
			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>