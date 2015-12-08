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
<?php } else { ?>

<div class="content">
<article class="admin">

<h1>ADMIN WORK</h1>
<p class="text"> Select a table</p>
<table>
<tr>
	<td><form action="?getRecordsFor="><input type="submit" class="button" value="Users"></form></td>
	<td><form action="https://google.com"><input type="submit" class="button" value="Teas"></form></td>
	<td><form action="https://google.com"><input type="submit" class="button" value="Reviews"></form></td>
</tr>
</table>

<?php

// USER TABLE

$query1 = 'SELECT pmkNetId, fldFirstName, fldLastName, fldEmail FROM tblUsers';
$records1 = $thisDatabaseReader->select($query1, "", 0, 0, 0, 0, false, false);

print '<ol>';
foreach ($records1 as $rec) {
	print '<li>';
	for ($i = 0; $i < 4; $i++) {
		print rec[$i];
	}
	print '</li>';
}
print '</ol>';

// TEA TABLE

// $query2 = 'SELECT pmkTeaName, fldType, fldBrand FROM tblTea';
// $records2 = $thisDatabaseReader->select($query2, "", 0, 0, 0, 0, false, false);

// // REVIEW TABLE

// $query3 = 'SELECT pmkReviewId, fnkTeaName, fldRating, fldServedAs, fldReview FROM tblReviews';
// $records3 = $thisDatabaseReader->select($query3, "", 0, 0, 0, 0, false, false);

?>

</article>
</div>

<?php include "footer.php"; ?>

<?php } ?>