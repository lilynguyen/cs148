<?php 
include 'top.php'; 

if (isset($_POST["btnSubmit"])) { 

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

	$fnkTeaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $fnkTeaName;

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'INSERT INTO tblReviews SET fldRating = ?, fldServedAs = ?, fldReview = ?, fnkTeaName = ?';
	$results = $thisDatabaseWriter->insert($query, $dataRecord);
	$primaryKey = $thisDatabaseWriter->lastInsert();

	$dataEntered = $thisDatabaseWriter->db->commit();

	// if ($results) {
	// 	print 'Inserted';
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
		print 'SUBMIT INSERT';
	} else {
	?>

		<form action="<?php print $phpSelf; ?>" method="post">

			<label for="txtTeaName">Tea Name
              <input type="text" id="txtTeaName" name="txtTeaName"
                     tabindex="100" maxlength="45"
                     placeholder="Enter tea name"
                     >
            </label>

            <label for="rdoRating" class="required">Rating
              <label><input type="radio" name="rdoRating"
                     value="1"
                     >1</label>
              <label><input type="radio" name="rdoRating"
                     value="2"
                     >2</label>
              <label><input type="radio" name="rdoRating"
                     value="3"
                     >3</label>
              <label><input type="radio" name="rdoRating"
                     value="4"
                     >4</label>
              <label><input type="radio" name="rdoRating"
                     value="5"
                     checked = "checked"
                     >5</label>
            </label>
            
            <label for="checkServedAs" class="required">Served As
              <label><input type="checkbox" name="chkHot"
                     value="Hot"
                     checked = "checked"
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
                     ></textarea>
            </label>

			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>