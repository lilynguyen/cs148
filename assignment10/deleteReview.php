<?php 
include 'top.php'; 

if (isset($_GET['rid'])) {
	$pmkReviewId = htmlentities($_GET['rid'], ENT_QUOTES, "UTF-8");
	
	$query = 'SELECT fnkTeaName, fldRating, fldServedAs, fldReview FROM tblReviews WHERE pmkReviewId = ?';
	$results = $thisDatabaseReader->select($query, array($pmkReviewId), 1, 0, 0, 0, false, false);
}

if (isset($_POST["btnSubmit"])) { 

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'DELETE FROM tblReviews WHERE pmkReviewId = ?';
	$results = $thisDatabaseWriter->delete($query, array($pmkReviewId), 1, 0, 0, 0, false, false);
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
		<form action="<?php print $phpSelf . '?rid=' . $pmkReviewId; ?>" method="post">
			<?php print '<p>Confirm Deleting Record: ' . $results[0]["fnkTeaName"] . ' ' . $results[0]["fldRating"] . ' ' . $results[0]["fldServedAs"] . ' ' . $results[0]["fldReview"] . '?'; ?>
			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>