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
<p class="text">
Not sure what tea to try next? Check out these reviews to see what's the scoop. What brand
is top notch? What's on the bottom of the totem pole? Maybe you'll find your new favorite!
</p>
<?php
	foreach ($reviewsArray as $rec) {

		$random = rand(1, 4);
		if ($random == 1) {
			$bfi = "one";
		} elseif ($random == 2) {
			$bfi = "two";
		} elseif ($random == 3) {
			$bfi = "three";
		} elseif ($random == 4) {
			$bfi = "four";
		}

		print '<div id="bid" class="box fade-in ' . $bfi . '">';

		print '<ul>';

		print '<li class="left">';
		print '<h4>Rating:</h4>';
		print '<p>' . $rec[1] . '/5</p>';
		for ($i = 0; $i < $rec[1]; $i++) {
			print '<img src="images/tea.png" alt="icon" class="box fade-in five">';
		}
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

		$display = preg_replace('/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/',' $1',$rec[2]);

		print '<h4>Served:</h4> <p>' . $display . '</p>';
		print '</li>';

		print '</ul>';

		print '</div>';
	}
?>

</article>
</div>

<?php include "footer.php"; ?>