<?php 
include 'top.php'; 

if (isset($_GET['rid'])) {
	$pmkReviewId = htmlentities($_GET['rid'], ENT_QUOTES, "UTF-8");
	
	$query = 'SELECT fnkTeaName, fldRating, fldServedAs, fldReview FROM tblReviews WHERE pmkReviewId = ?';
	$results = $thisDatabaseReader->select($query, array($pmkReviewId), 1, 0, 0, 0, false, false);

	$teaName = $results[0]["fnkTeaName"];
	$rating = $results[0]["fldRating"];
	$servedAs = $results[0]["fldServedAs"];
	$descript = $results[0]["fldReview"];
}


if (isset($_POST["btnSubmit"])) { 

	$teaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $teaName;
	$rating = htmlentities($_POST["rdoRating"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $rating;

    if (isset($_POST["chkHot"])) {
      $chkHot = 'Hot';
    } else {
      $chkHot = '';
    }
    if (isset($_POST["chkChilled"])) {
      $chkChilled = 'Chilled';
    } else {
      $chkChilled = '';
    }
    if (isset($_POST["chkPressed"])) {
      $chkPressed = 'Pressed';
    } else {
      $chkPressed = '';
    }

    $addThis = $chkHot;
    $addThis .= $chkChilled;
    $addThis .= $chkPressed;
    $dataRecord[] = $addThis;

	$descript = htmlentities($_POST["txtDescript"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $descript;

	$dataRecord[] = $pmkReviewId;

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'UPDATE tblReviews SET fnkTeaName = ?, fldRating = ?, fldServedAs = ?, fldReview = ? WHERE pmkReviewId = ?';
	$results = $thisDatabaseWriter->update($query, $dataRecord);
	$primaryKey = $thisDatabaseWriter->lastInsert();

	$dataEntered = $thisDatabaseWriter->db->commit();

	// if ($results) {
	// 	print 'Updated';
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
		print 'SUBMIT UPDATE';
	} else {
	?>
		<form action="<?php print $phpSelf . '?rid=' . $pmkReviewId; ?>" method="post">
			
			<label for="txtTeaName">Tea Name
              <input type="text" id="txtTeaName" name="txtTeaName"
                     tabindex="100" maxlength="45"
                     value="<?php print $teaName; ?>"
                     placeholder="Enter tea name"
                     >
            </label>

            <label for="rdoRating" class="required">Rating
              <label><input type="radio" name="rdoRating"
                     value="1"
                     <?php if($rating == 1) print 'checked="checked"'; ?>
                     >1</label>
              <label><input type="radio" name="rdoRating"
                     value="2"
                     <?php if($rating == 2) print 'checked="checked"'; ?>
                     >2</label>
              <label><input type="radio" name="rdoRating"
                     value="3"
                     <?php if($rating == 3) print 'checked="checked"'; ?>
                     >3</label>
              <label><input type="radio" name="rdoRating"
                     value="4"
                     <?php if($rating == 4) print 'checked="checked"'; ?>
                     >4</label>
              <label><input type="radio" name="rdoRating"
                     value="5"
                     <?php if($rating == 5) print 'checked="checked"'; ?>
                     checked = "checked"
                     >5</label>
            </label>
            
            <label for="checkServedAs" class="required">Served As
              <label><input type="checkbox" name="chkHot"
                     value="Hot"
                     >Hot</label>
              <label><input type="checkbox" name="chkChilled"
                     value="Chilled"
                     >Chilled
              </label><label>
              <input type="checkbox" name="chkPressed"
                     value="Pressed"
                     >Pressed</label>
            </label>

            <label for="txtDescript" class="required">Description<br><br>
              <textarea type="text" id="txtDescript" name="txtDescript"
                     tabindex="100" maxlength="800" placeholder="Enter description"
                     onfocus="this.select()" 
                     ><?php print $descript; ?></textarea>
            </label>

			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>