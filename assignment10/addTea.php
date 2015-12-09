<?php 
include 'top.php'; 

if (isset($_POST["btnSubmit"])) { 

	$pmkTeaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $pmkTeaName;
	$fldBrand = htmlentities($_POST["txtBrandName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $fldBrand;
	$fldType = filter_var($_POST["teaTypes"], FILTER_SANITIZE_EMAIL);
	$dataRecord[] = $fldType;

	// print $pmkTeaName;
	// print $fldBrand;
	// print $fldType;

	// for ($i = 0; $i < 3; $i++) {
	// 	print $dataRecord[$i];
	// }

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'INSERT INTO tblTea SET pmkTeaName = ?, fldBrand = ?, fldType = ?';
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
            
            <label for="txtTeaType">Tea Type
              <select name="teaTypes" id="typeTea">
                <option value="green">Green</option>
                <option value="black">Black</option>
                <option value="white">White</option>
                <option value="yellow">Yellow</option>
                <option value="red">Red</option>
                <option value="puer">Puer</option>
                <option value="oolong">Oolong</option>
                <option value="herbal">Herbal</option>
              </select>
            </label>

            <label for="txtBrandName">Brand
              <input type="text" id="txtBrandName" name="txtBrandName"
                     tabindex="100" maxlength="80" 
                     placeholder="Enter brand name"
                     >
            </label>

			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>