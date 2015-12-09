<?php 
// ==================================================================== 
// form stuffs lol
// ====================================================================  
include "top.php";

// ====================================================================
// SECTION: 1 Initialize variables
// ====================================================================

$debug = false;
if (isset($_GET["debug"])) {
    $debug = true;
}
if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
}

$yourURL = $domain . $phpSelf;

// ===========================================
// Initialize Form Vars NEED TO BE IN ORDER OF FORM
// ===========================================

$netID = "";

$firstName = "Lily";
$lastName = "Nguyen";
$email = "lhnguyen@uvm.edu";

$teaName = "Jasmine Pearl Dragon";
$teaType = "";
$brandName = "Dobra Tea VT";

$rdoRating = "5";

$chkHot = "";
$chkChilled = "";
$chkPressed = "";

$descript = "";

// ===========================================
// Error Flags NEED TO BE IN ORDER OF FORM
// ===========================================

$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;

$teaNameERROR = false;
$teaTypeError = false;
$brandNameERROR = false;

$ratingERROR = false; 
$servedAsERROR = false;
$descriptERROR = false; 

// ===========================================
// misc vars
// ===========================================

$errorMsg = array();

$dataRecord = array();
$dataRecord2 = array();
$dataRecord3 = array();

$mailed = false;
$dataEntered = false;

// ====================================================================
// SECTION: 2 Process for when the form is submitted
// ====================================================================

if (isset($_POST["btnSubmit"])) {

    // ===========================================
    // Security Check
    // ===========================================

    if (!securityCheck($path_parts, $yourURL, true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg .= "Security breach detected and reported</p>";
        die($msg);
    }
    
    // ===========================================
    // SANITATION: Potential Code Input for all input fields
    // ===========================================

    $netID = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $netID;

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $teaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
    $dataRecord2[] = $teaName;
    $dataRecord3[] = $teaName;
    $teaType = htmlentities($_POST["teaTypes"]);
    $dataRecord2[] = $teaType;
    $brandName = htmlentities($_POST["txtBrandName"], ENT_QUOTES, "UTF-8");
    $dataRecord2[] = $brandName;

    $rdoRating = htmlentities($_POST["rdoRating"], ENT_QUOTES, "UTF-8");
    $dataRecord3[] = $rdoRating;

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
    // print $addThis;
    $dataRecord3[] = $addThis;

    $descript = htmlentities($_POST["txtDescript"], ENT_QUOTES, "UTF-8");
    $dataRecord3[] = $descript;

    // ===========================================
    // SANITATION: Input Type
    // ===========================================

    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }
    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra character.";
        $lastNameERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }

    if ($teaName == "") {
        $errorMsg[] = "Please enter a tea name";
        $teaNameERROR = true;
    } elseif (!verifyAlphaNum($teaName)) {
        $errorMsg[] = "Your tea name appears to have extra character.";
        $teaNameERROR = true;
    }
    if ($brandName == "") {
        $errorMsg[] = "Please enter a brand name";
        $brandNameERROR = true;
    } elseif (!verifyAlphaNum($brandName)) {
        $errorMsg[] = "Your brand name appears to have extra character.";
        $brandNameERROR = true;
    }

    if ($rdoRating == "") {
      $errorMsg[] = "Please select a rating";
      $ratingERROR = true;
    }
    if ($chkHot == false && $chkChilled == false && $chkPressed == false) { 
      $errorMsg[] = "Please select a serving style";
      $servedAsERROR = true;
    }
    if ($descript == "") {
        $errorMsg[] = "Please enter a description";
        $descriptERROR = true;
    }
    // } elseif (!verifyAlphaNum($descript)) {
    //     $errorMsg[] = "Your description name appears to have extra character.";
    //     $descriptERROR = true;
    // } DEAR BOB OR APARAJITTA HOW DO YOU VERIFY INPUT LIKE THIS

    // ===========================================
    // Process Form (Everything passes)
    // ===========================================

    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";
        
        // ===========================================
        // PUTTING THINGS INTO DB
        // ===========================================

        $dataEntered = false;
        try {
          $thisDatabaseWriter->db->beginTransaction();

          $queryUser = 'INSERT INTO tblUsers SET pmkNetId = ?, fldFirstName = ?, fldLastName = ?, fldEmail = ?';
          $results = $thisDatabaseWriter->insert($queryUser, $dataRecord);
          $primaryKey = $thisDatabaseWriter->lastInsert();

          $queryUser2 = 'INSERT INTO tblTea SET pmkTeaName = ?, fldType = ?, fldBrand = ?';
          $results2 = $thisDatabaseWriter->insert($queryUser2, $dataRecord2);
          $primaryKey = $thisDatabaseWriter->lastInsert();

          $queryUser3 = 'INSERT INTO tblReviews SET fnkTeaName = ?, fldRating = ?, fldServedAs = ?, fldReview = ?';
          $results3 = $thisDatabaseWriter->insert($queryUser3, $dataRecord3);
          $primaryKey = $thisDatabaseWriter->lastInsert();

          # CHANGES DONE COMMIT CHANGES
          $dataEntered = $thisDatabaseWriter->db->commit();

        } catch (PDOException $e) {
          $thisDatabaseWriter->db->rollback();
          if ($debug)
              print "Error!: " . $e->getMessage() . "</br>";
          $errorMsg[] = "There was a problem with accpeting your data please contact us directly.";
        }

        // ===========================================
        // Create email message.
        // ===========================================

        $message = '<h2>Your information.</h2>';
        foreach ($_POST as $key => $value) {
            $message .= "<p>";
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
        // ===========================================
        // Actually emailing user
        // ===========================================

        $to = $email;
        $cc = "";
        $bcc = "";
        $from = "Foveō Support <no-reply@foveo.com>";
        $todaysDate = strftime("%x");
        $subject = "Foveo Review Submission: " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
    } // end form is valid
} // ends if form was submitted.

?>

<!-- ===== THE ACTUAL FORM ===== -->
<div class="content"> 
<article>
  <?php

  // ====================================================================
  // SECTION 3: Form Struction and Submission Processes
  // ====================================================================

  // ===========================================
  // If its the first time coming to the form or there are errors we are going to display the form.
  // ===========================================
  if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit
      print "<h1>Your Request has ";
      if (!$mailed) {
          print "not ";
      }
      print "been processed</h1>";
      print "<p>A copy of this message has ";
      if (!$mailed) {
          print "not ";
      }
      print "been sent</p>";
      print "<p>To: " . $email . "</p>";
      print "<p>Mail Message:</p>";
      print $message;
  } else {
      // ===========================================
      // display any error messages before we print out the form
      // ===========================================
      if ($errorMsg) {
          print '<div id="errors">';
          print "<ol>\n";
          foreach ($errorMsg as $err) {
              print "<li>" . $err . "</li>\n";
          }
          print "</ol>\n";
          print '</div>';
      }
      ?>

    <form action="<?php print $phpSelf; ?>" method="post" id="frmRegister">
      <fieldset class="formWrapper">
      <legend>Submit a Review!</legend>
      <p class="text">Have a strong opinion about a certain tea you've tried? Was it so amazing that it made
        your knees buckle? Or was it so groty that it made you want to boot? Let the world know your
        discoveries. Fill out a form!</p>

        <fieldset class="userInformation">
        <legend>Contributor Information</legend>

          <div class="chunk">
            <label for="txtFirstName" class="required">First Name
              <input type="text" id="txtFirstName" name="txtFirstName"
                     value="<?php print $firstName; ?>"
                     tabindex="100" maxlength="45" placeholder="Enter your first name"
                     <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     autofocus>
            </label>
            
            <label for="txtLastName" class="required">Last Name
              <input type="text" id="txtLastName" name="txtLastName"
                     value="<?php print $lastName; ?>"
                     tabindex="100" maxlength="45" placeholder="Enter your last name"
                     <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
            </label>

            <label for="txtEmail" class="required">Email
              <input type="text" id="txtEmail" name="txtEmail"
                     value="<?php print $email; ?>"
                     tabindex="100" maxlength="80" placeholder="Enter a valid email address"
                     <?php if ($emailERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()" 
                     >
            </label>
            </div>

        </fieldset> <!-- ends userInformation -->

        <fieldset class="teaInformation">
        <legend>Tea Information</legend>

            <div class="chunk">
            <div class="tiOneRow">

            <label for="txtTeaName" class="required">Tea Name
              <input type="text" id="txtTeaName" name="txtTeaName"
                     value="<?php print $teaName; ?>"
                     tabindex="100" maxlength="45" placeholder="Enter tea name"
                     <?php if ($teaNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
            </label>
            
            <label for="txtTeaType" class="required">Tea Type
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

            </div>

            <label for="txtBrandName" class="required">Brand
              <input type="text" id="txtBrandName" name="txtBrandName"
                     value="<?php print $brandName; ?>"
                     tabindex="100" maxlength="80" placeholder="Enter a valid brand name"
                     <?php if ($brandNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()" 
                     >
            </label>
            </div>

        </fieldset> <!-- ends teaInformation -->

        <fieldset class="reviewInformation">
        <legend>Review</legend>

            <div class="chunk">
            <label for="rdoRating" class="required">Rating
              <label><input type="radio" name="rdoRating"
                     value="1"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >1</label>
              <label><input type="radio" name="rdoRating"
                     value="2"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >2</label>
              <label><input type="radio" name="rdoRating"
                     value="3"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >3</label>
              <label><input type="radio" name="rdoRating"
                     value="4"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >4</label>
              <label><input type="radio" name="rdoRating"
                     value="5"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     checked = "checked"
                     onfocus="this.select()"
                     >5</label>
            </label>
            
            <div class="checkboxes">
            <label for="checkServedAs" class="required">Served As
              <label><input type="checkbox" name="chkHot"
                     value="Hot"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     checked = "checked"
                     onfocus="this.select()"
                     >Hot</label>
              <label><input type="checkbox" name="chkChilled"
                     value="Chilled"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >Chilled
              </label><label>
              <input type="checkbox" name="chkPressed"
                     value="Pressed"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >Pressed</label>
            </label>
            </div>

            <label for="txtDescript" class="required">Description<br><br>
              <textarea type="text" id="txtDescript" name="txtDescript"
                     value="<?php print $descript; ?>"
                     tabindex="100" maxlength="800" placeholder="Enter description"
                     <?php if ($descriptERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()" 
                     ></textarea>
            </label>

            </div>

        </fieldset> <!-- ends reviewInformation -->

          <fieldset class="buttonGroup">
              <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
              <input type="reset" id="btnReset" name="btnReset" value="Reset" tabindex="900" class="button">
          </fieldset> <!-- end buttons -->

      </fieldset> <!-- end formWrapper -->
    </form>


  <?php
  } // end body submit
  ?>

</article>
</div>
<!-- ===== THE ACTUAL FORM END ===== -->

<?php include "footer.php"; ?>