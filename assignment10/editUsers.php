<?php 
include 'top.php'; 

if (isset($_GET['nid'])) {
	$pmkNetId = htmlentities($_GET['nid'], ENT_QUOTES, "UTF-8");
	
	$query = 'SELECT fldFirstName, fldLastName, fldEmail, fldAdmin FROM tblUsers WHERE pmkNetId = ?';
	$results = $thisDatabaseReader->select($query, array($pmkNetId), 1, 0, 0, 0, false, false);

	$firstName = $results[0]["fldFirstName"];
	$lastName = $results[0]["fldLastName"];
	$email = $results[0]["fldEmail"];
	$adminStatus = $results[0]["fldAdmin"];
}

if (isset($_POST["btnSubmit"])) { 

	$firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $firstName;
	$lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $lastName;
	$email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
	$dataRecord[] = $email;
	$adminStatus = htmlentities($_POST["rdoAdmin"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $adminStatus;

	$dataRecord[] = $pmkNetId;

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'UPDATE tblUsers SET fldFirstName = ?, fldLastName = ?, fldEmail = ?, fldAdmin = ? WHERE pmkNetId = ?';
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
		<form action="<?php print $phpSelf . '?nid=' . $pmkNetId; ?>" method="post">
			<label for="txtFirstName">First Name
              <input type="text" id="txtFirstName" name="txtFirstName"
                     value="<?php print $firstName; ?>"
                     tabindex="100" maxlength="45" 
                     placeholder="Enter first name"
                     >
            </label>
            
            <label for="txtLastName">Last Name
              <input type="text" id="txtLastName" name="txtLastName"
                     value="<?php print $lastName; ?>"
                     tabindex="100" maxlength="45" 
                     placeholder="Enter last name"
                     >
            </label>

            <label for="txtEmail">Email
              <input type="text" id="txtEmail" name="txtEmail"
                     value="<?php print $email; ?>"
                     tabindex="100" maxlength="80" 
                     placeholder="Enter email address"
                     >
            </label>

            <label for="rdoAdmin">Admin
              <label><input type="radio" 
	              			name="rdoAdmin"
	                    value="0"
	                    <?php if($adminStatus == 0) print 'checked="checked"'; ?>
	                    >No</label>
              <label><input type="radio" 
              			name="rdoAdmin"
                    	value="1"
                    	<?php if($adminStatus == 1) print 'checked="checked"'; ?>
                    	>Yes</label>
        </label>
			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>