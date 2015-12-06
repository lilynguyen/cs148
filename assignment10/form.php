<?php 
// ==================================================================== 
// form stuffs lol
// ====================================================================  
include "top.php";

// ====================================================================
// SECTION: 1 Initialize variables
// ====================================================================
// Debugging
$debug = false;
if (isset($_GET["debug"])) {
    $debug = true;
}
if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
}

// security used in 2a
$yourURL = $domain . $phpSelf;


// form variables
// Initialize variables one for each form element
// in the order they appear on the form
// $netID = "";
$firstName = "";
$lastName = "";
$email = ""; // default to me so that it makes life easier for debugging

$teaName = "";
$teaType = "";
$brandName = "";

$radioRating = "";
$checkServedAs = "";
$descript = "";

// SECTION: 1d form error flags
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;

$teaNameERROR = false;
$teaTypeError = false;
$brandNameERROR = false;

$ratingERROR = false; 
$servedAsERROR = false;
$descriptERROR = false; 


// SECTION: 1e misc variables
$errorMsg = array(); // create array to hold error messages filled (if any) in 2d displayed in 3c.
$dataRecord = array(); // array used to hold form values that will be written to a CSV file
$mailed = false;

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
    // SANITATION: Potential Code Input
    // ===========================================

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $teaName = htmlentities($_POST["txtTeaName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $teaName;
    $brandName = htmlentities($_POST["txtBrandName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $brandName;

    $descript = htmlentities($_POST["txtDescript"], ENT_QUOTES, "UTF-8");
    $dataRecord = $descript;

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

    if ($radioRating == "") {
      $errorMsg[] = "Please select a rating";
      $ratingERROR = true;
    }
    if ($servedAsERROR == "") {
      $errorMsg[] = "Please select a serving style";
      $servedAsERROR = true;
    }
    if ($descript == "") {
        $errorMsg[] = "Please enter a description";
        $descriptERROR = true;
    } elseif (!verifyAlphaNum($descript)) {
        $errorMsg[] = "Your description name appears to have extra character.";
        $descriptERROR = true;
    }
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
        $fileExt = ".csv";
        $myFileName = "fileName";
        $filename = $myFileName . $fileExt;
        if ($debug)
            print "\n\n<p>filename is " . $filename;
        // now we just open the file for append
        $file = fopen($filename, 'a');
        // write the forms informations
        fputcsv($file, $dataRecord);
        // close the file
        fclose($file);
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).
        $message = '<h2>Your information.</h2>';
        foreach ($_POST as $key => $value) {
            $message .= "<p>";
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";
        $from = "Foveō Support <noreply@yoursite.com>";
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");
        $subject = "Research Study: " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
        
    } // end form is valid
    
} // ends if form was submitted.

?>

<!-- ===== THE ACTUAL FORM ===== -->
<div class="content"> 
<article>
  <?php
  //####################################
  //
  // SECTION 3a.
  //
  // 
  // 
  // 
  // If its the first time coming to the form or there are errors we are going
  // to display the form.
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
      //####################################
      //
      // SECTION 3b Error Messages
      //
      // display any error messages before we print out the form
      if ($errorMsg) {
          print '<div id="errors">';
          print "<ol>\n";
          foreach ($errorMsg as $err) {
              print "<li>" . $err . "</li>\n";
          }
          print "</ol>\n";
          print '</div>';
      }
      //####################################
      //
      // SECTION 3c html Form
      //
      /* Display the HTML form. note that the action is to this same page. $phpSelf
        is defined in top.php
        NOTE the line:
        value="<?php print $email; ?>
        this makes the form sticky by displaying either the initial default value (line 35)
        or the value they typed in (line 84)
        NOTE this line:
        <?php if($emailERROR) print 'class="mistake"'; ?>
        this prints out a css class so that we can highlight the background etc. to
        make it stand out that a mistake happened here.
       */
      ?>

    <form action="<?php print $phpSelf; ?>" method="post" id="frmRegister">
      <fieldset class="formWrapper">
      <legend>Submit a Review!</legend>
      <p>Info abt form here</p>
      <br>

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
            
            <label for="txtLastName" class="required">Tea Type
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
            <label for="radioRating" class="required">Rating
              <input type="radio" id="radioRating" name="radioRating"
                     value="1"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
              <input type="radio" id="radioRating" name="radioRating"
                     value="2"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
              <input type="radio" id="radioRating" name="radioRating"
                     value="3"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
              <input type="radio" id="radioRating" name="radioRating"
                     value="4"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
              <input type="radio" id="radioRating" name="radioRating"
                     value="5"
                     <?php if ($ratingERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
            </label>
            
            <div class="checkboxes">
            <label for="checkServedAs" class="required">Served As
              <label><input type="checkbox" id="checkServedAs" name="checkServedAs"
                     value="hot"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >Hot
              </label>
              <label><input type="checkbox" id="checkServedAs" name="checkServedAs"
                     value="chilled"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >Chilled
              </label>
              <label><input type="checkbox" id="checkServedAs" name="checkServedAs"
                     value="pressed"
                     <?php if ($servedAsERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >Pressed
              </label>
            </label>
            </div>

            <label for="txtDescript" class="required">Description<br><br>
              <textarea type="text" id="txtDescript" name="txtDescript"
                     value="<?php print $descript; ?>"
                     tabindex="100" maxlength="800" placeholder="Enter description"
                     <?php if ($descriptERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()" 
                     >
              </textarea>
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