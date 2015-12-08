<?php 
include 'top.php'; 

if (isset($_POST["btnSubmit"])) { 

	$firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $firstName;
	$lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $lastName;
	$email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
	$dataRecord[] = $email;
	$adminStatus = htmlentities($_POST["rdoAdmin"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $adminStatus;
	$pmkNetId = htmlentities($_POST["txtNetId"], ENT_QUOTES, "UTF-8");
	$dataRecord[] = $pmkNetId;

	$dataEntered = false;
	try {
	$thisDatabaseWriter->db->beginTransaction();

	$query = 'INSERT INTO tblUsers SET fldFirstName = ?, fldLastName = ?, fldEmail = ?, fldAdmin = ?, pmkNetId = ?';
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
			<label for="txtNetId">Net Id
              <input type="text" id="txtNetId" name="txtNetId"
                     tabindex="100" maxlength="45" 
                     placeholder="Enter valid net id"
                     >
            </label>

			<label for="txtFirstName">First Name
              <input type="text" id="txtFirstName" name="txtFirstName"
                     tabindex="100" maxlength="45" 
                     placeholder="Enter first name"
                     >
            </label>
            
            <label for="txtLastName">Last Name
              <input type="text" id="txtLastName" name="txtLastName"
                     tabindex="100" maxlength="45" 
                     placeholder="Enter last name"
                     >
            </label>

            <label for="txtEmail">Email
              <input type="text" id="txtEmail" name="txtEmail"
                     tabindex="100" maxlength="80" 
                     placeholder="Enter email address"
                     >
            </label>

            <label for="rdoAdmin">Admin
              <label><input type="radio" 
	              			name="rdoAdmin"
	                    value="0"
	                    >No</label>
              <label><input type="radio" 
              			name="rdoAdmin"
                    	value="1"
                    	>Yes</label>
        </label>
			<input type="submit" id = 'btnSubmit' name='btnSubmit' value="Confirm">
		</form>
	<?php } // end body submit ?>

	</article>
</div>

<?php include "footer.php"; ?>