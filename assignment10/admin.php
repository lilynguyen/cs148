<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#users").click(function(){
        $("#ONE").toggle(250);
    });
});

$(document).ready(function(){
    $("#teas").click(function(){
        $("#TWO").toggle(250);
    });
});

$(document).ready(function(){
    $("#reviews").click(function(){
        $("#THREE").toggle(250);
    });
});
</script>

<?php 
include 'top.php';

$access = false;
$netId = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8"); 

$query = 'SELECT pmkNetId FROM tblUsers WHERE fldAdmin = 1';
$adminArray = $thisDatabaseReader->select($query,"",1,0,0,0,false,false);

foreach ($adminArray as $adminIds) {
	for ($i = 0; $i < 1; $i++) {
		if ($netId == $adminIds[$i]) {
			$access = true;
		}
	}
}
if (!$access) {
// ====================================================================
// USER IS NOT ADMIN, SNUCK WAY INTO PAGE
// ====================================================================
?>

	<div class="content">
		<article class="error">
		<img src='images/error.gif' alt='Error Gif'>
		<p>
			Looks like you've made your way to the ~ADMIN PAGE~ by accident! Sneaky sneaky! 
			Go ahead and click another page on the navigation bar to git outta here!
		</p>
		</article>
	</div>
	<?php include "footer.php"; ?>

<?php } else { 
// ====================================================================
// USER IS ADMIN
// ====================================================================
?>

<div class="content">
<article class="admin">

<h1>ADMIN WORK</h1>
<table>
<tr>
	<td><button class="button" id="users" >Users</button></td>
	<td><button class="button" id="teas" >Teas</button></td>
	<td><button class="button" id="reviews" >Reviews</button></td>
</tr>
</table>
<p>
<?php

// ===========================================
// USER TABLE
// ===========================================

$query1 = 'SELECT pmkNetId, fldFirstName, fldLastName, fldEmail, fldAdmin FROM tblUsers';
$records1 = $thisDatabaseReader->select($query1, "", 0, 0, 0, 0, false, false);

print '<ol id="ONE" class="initiallyHidden">';
print '<a id="addLink" href="addUser.php">Add User</a>';
foreach ($records1 as $rec) {

	print '<div class="functions">';
	print '<a href="editUsers.php?nid=' . $rec['pmkNetId'] . '">edit</a> ';
	print '<a href="deleteUsers.php?nid=' . $rec['pmkNetId'] . '">delete</a>';
	print '</div>';

	print '<li>';
	for ($i = 0; $i < 5; $i++) {
		print $rec[$i] . ' ';
	}
	print '</li>';
}
print '</ol>';

// ===========================================
// TEA TABLE
// ===========================================

$query2 = 'SELECT pmkTeaName, fldType, fldBrand FROM tblTea';
$records2 = $thisDatabaseReader->select($query2, "", 0, 0, 0, 0, false, false);

print '<ol id="TWO" class="initiallyHidden">';
foreach ($records2 as $rec) {

	print '<div class="functions">';
	print '<a href="editTea.php?id1=' . $rec['pmkTeaName'] . '?id2=' . $rec['fldBrand'] . '">edit</a> ';
	print '<a href="deleteTea.php?' . $rec['pmkTeaName'] . '?' . $rec['fldBrand'] . '">delete</a>';
	print '</div>';

	print '<li>';
	for ($i = 0; $i < 2; $i++) {
		print $rec[$i] . ' ';
	}
	print '</li>';
}
print '</ol>';

// ===========================================
// REVIEW TABLE
// ===========================================

$query3 = 'SELECT pmkReviewId, fnkTeaName, fldRating, fldServedAs, fldReview FROM tblReviews';
$records3 = $thisDatabaseReader->select($query3, "", 0, 0, 0, 0, false, false);

print '<ol id="THREE" class="initiallyHidden">';
foreach ($records3 as $rec) {

	print '<div class="functions">';
	print '<a href="edit.php?' . $rec['pmkReviewId'] . '">edit</a> ';
	print '<a href="delete.php?' . $rec['pmkReviewId'] . '">delete</a>';
	print '</div>';

	print '<li>';
	for ($i = 0; $i < 4; $i++) {
		print $rec[$i] . ' ';
	}
	print '</li>';
}
print '</ol>';




?>
</p>
</article>
</div>

<?php include "footer.php"; ?>

<?php } // end else conditional ?>