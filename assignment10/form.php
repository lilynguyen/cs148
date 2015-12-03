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


// SECTION: 1d form error flags
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.
$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;


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

    // if (!securityCheck(true)) {
    //     $msg = "<p>Sorry you cannot access this page. ";
    //     $msg .= "Security breach detected and reported</p>";
    //     die($msg);
    // }
    
    // ===========================================
    // SANITATION: Potential Code Input
    // ===========================================

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    $lastName = htmlentities($_POST["txtLastName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

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
      <legend>Wrapper 1 Title</legend>

        <fieldset class="userInformation">
        <legend>Contributor Information</legend>

            <label for="txtFirstName" class="required">First Name
              <input type="text" class="form-control" id="txtFirstName" name="txtFirstName"
                     value="<?php print $firstName; ?>"
                     tabindex="100" maxlength="45" placeholder="Enter your first name"
                     <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     autofocus>
            </label>
            
            <label for="txtLastName" class="required">Last Name
              <input type="text" class="form-control" id="txtLastName" name="txtLastName"
                     value="<?php print $lastName; ?>"
                     tabindex="100" maxlength="45" placeholder="Enter your last name"
                     <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()"
                     >
            </label>

            <label for="txtEmail" class="required">Email
              <input type="text" class="form-control" id="txtEmail" name="txtEmail"
                     value="<?php print $email; ?>"
                     tabindex="100" maxlength="80" placeholder="Enter a valid email address"
                     <?php if ($emailERROR) print 'class="mistake"'; ?>
                     onfocus="this.select()" 
                     >
            </label>
        </fieldset> <!-- ends wrapper userInformation -->

          <fieldset class="buttons">
              <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="btn btn-default">
          </fieldset> <!-- ends buttons -->

      </fieldset> <!-- Ends Wrapper one -->
    </form>

  <?php
  } // end body submit
  ?>

</article>
<!-- ===== THE ACTUAL FORM END ===== -->

<?php include "footer.php"; ?>