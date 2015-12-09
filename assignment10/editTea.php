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
 
$teaName = $pmkTeaName;
$teaType = $results[0]["fldType"];
$brandName = $fldBrand;

if (isset($_POST["btnSubmit"])) { 

	$pmkTeaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $pmkTeaName;
	$fldType = htmlentities($_POST["teaTypes"]);
	$dataRecord[] = $fldType;
	$fldBrand = htmlentities($_POST["txtBrandName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $fldBrand;

	$dataRecord[] = str_replace("Q", " ", $toast);
	$dataRecord[] = str_replace("Q", " ", $potato);

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'UPDATE tblTea SET pmkTeaName = ?, fldType = ?, fldBrand = ? WHERE pmkTeaName = ? AND fldBrand = ?';
	$results = $thisDatabaseWriter->update($query, $dataRecord, 1, 1, 0, 0, false, false);
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
		<form action="<?php print $phpSelf . '?id1=' . $pmkTeaName . '&id2=' . $fldBrand ; ?>" method="post">
			<label for="txtTeaName">Tea Name
              <input type="text" id="txtTeaName" name="txtTeaName"
                     tabindex="100" maxlength="45"
                     value="<?php print $teaName; ?>"
                     placeholder="Enter tea name"
                     >
            </label>
            
            <label for="txtTeaType">Tea Type
              <select name="teaTypes" id="typeTea">
                <option value="green" 
                	<?php if($teaType == 'green') print 'selected'; ?>
                	>Green</option>
                <option value="black" 
                	<?php if($teaType == 'black') print 'selected'; ?>
                	>Black</option>
                <option value="white" 
                	<?php if($teaType == 'white') print 'selected'; ?>
                	>White</option>
                <option value="yellow" 
                	<?php if($teaType == 'yellow') print 'selected'; ?>
                	>Yellow</option>
                <option value="red" 
                	<?php if($teaType == 'red') print 'selected'; ?>
                	>Red</option>
                <option value="puer" 
                	<?php if($teaType == 'puer') print 'selected'; ?>
                	>Puer</option>
                <option value="oolong" 
                	<?php if($teaType == 'oolong') print 'selected'; ?>
                	>Oolong</option>
                <option value="herbal" 
                	<?php if($teaType == 'herbal') print 'selected'; ?>
                	>Herbal</option>
              </select>
            </label>

            <label for="txtBrandName">Brand
              <input type="text" id="txtBrandName" name="txtBrandName"
                     tabindex="100" maxlength="80"
                     value="<?php print $brandName; ?>"
                     placeholder="Enter brand name"
                     >
            </label>

			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>