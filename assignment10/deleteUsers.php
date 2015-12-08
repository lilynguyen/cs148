<?php 
include 'top.php'; 

if (isset($_GET['nid'])) {
	$pmkNetId = htmlentities($_GET['nid'], ENT_QUOTES, "UTF-8");
	
	$query = 'SELECT fldFirstName, fldLastName, fldEmail, fldAdmin FROM tblUsers WHERE pmkNetId = ?';
	$results = $thisDatabaseReader->select($query, array($pmkNetId), 1, 0, 0, 0, false, false);
}

if (isset($_POST["btnSubmit"])) { 

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'DELETE FROM tblUsers WHERE pmkNetId = ?';
	$results = $thisDatabaseWriter->delete($query, array($pmkNetId), 1, 0, 0, 0, false, false);
	$primaryKey = $thisDatabaseWriter->lastInsert();

	$dataEntered = $thisDatabaseWriter->db->commit();

	// if ($results) {
	// 	print 'Deleted';
	// } else {
	// 	print 'It didn\'t work. :(';
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
		<form action="<?php print $phpSelf . '?nid=' . $pmkNetId; ?>" method="post">
			<?php print '<p>Confirm Deleting Record: ' . $pmkNetId . ' ' . $results[0]["fldFirstName"] . ' ' . $results[0]["fldLastName"] . ' ' . $results[0]["fldEmail"] . ' ' . $results[0]["fldAdmin"] . '?'; ?>
			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>