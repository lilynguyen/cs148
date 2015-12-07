<?php
include "top.php";
$query = 'SELECT pmkTeaName, fldRating, fldServedAs, fldReview, fldType, fldBrand
	FROM tblReviews
	INNER JOIN tblTea on tblReviews.fnkTeaName = tblTea.pmkTeaName';
$reviewsArray = $thisDatabaseReader->select($query, "", 0, 0, 0, 0, false, false);
$columns = 6;
?>

<div class="content">
<article class="reviews">

<h1>Reviews</h1>
<div class="text">
<p>Here are some submitted reviews</p>
</div>
<br>
<?php
	foreach ($reviewsArray as $rec) {
		print '<div class="block">';

		print '<ul>';

		print '<li class="left">';
		print '<h4>Rating:</h4>';
		print '<p>' . $rec[1] . '/5</p>';
		print '</li>';

		print '<li class="center">';
		print '<h3>Tea:</h3> <p>' . $rec[0] . '</p>';
		print '<br>';
		print '<h4>Review:</h4>';
		print '<p>' . $rec[3] . '</p>';
		print '</li>';

		print '<li class="right">';
		print '<h4>Type:</h4> <p>' . $rec[4] . '</p>';
		print '<br>';
		print '<h4>Brand:</h4> <p>' . $rec[5] . '</p>';
		print '<br>';
		print '<h4>Served:</h4> <p>' . $rec[2] . '</p>';
		print '</li>';

		print '</ul>';


		print '</div>';
	}
?>

</article>
</div>

<?php include "footer.php"; ?>