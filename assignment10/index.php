<?php
// ==================================================================== 
// main home page for the site 
// ====================================================================  

include "top.php";

print '<div class="content">';

print '<article>';
print '<h2>Sample Page</h2>';
print '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at lectus et metus consectetur ullamcorper at id tortor. Ut dapibus mi eu arcu pharetra[ luctus. Nunc cursus metus nec dignissim laoreet. Morbi at ante quam. Maecenas eu urna non ante cursus convallis vehicula quis est. Mauris nec orci nec ante semper laoreet. Sed eu dapibus tortor, nec iaculis tellus. Aliquam aliquam sem ut augue vehicula, id efficitur purus lobortis. In in scelerisque tortor. Donec nec felis enim. Mauris viverra in erat sed consectetur. Nulla eleifend libero quis sapien bibendum, eu laoreet massa malesuada. Etiam venenatis tincidunt metus, sit amet tristique ante dapibus sed. Vestibulum ligula risus, ultrices vehicula sapien ac, tincidunt facilisis tortor]';
print '</article>';
?>

<div id="slider">
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="/www/js/jquery.flexslider-min.js"></script>
  <script type="text/javascript">
      var flexsliderStylesLocation = "/www/css/flexslider.css";
      $('<link rel="stylesheet" type="text/css" href="'+flexsliderStylesLocation+'" >').appendTo("head");
      $(window).load(function() {
    
          $('.flexslider').flexslider({
              animation: "fade",
              slideshowSpeed: 3000,
              animationSpeed: 1000
          });
   
      });
  </script>

	<div class="flexslider">
		<ul class="slides">

			<li>		
			<img src="images/foveo.png" alt="keyboard" />
			</li>

			<li>		
			<img src="images/foveo.png" alt="microphone" />
			</li>

			<li>		
			<img src="images/foveo.png" alt="saxophone" />
			</li>

	    <li>		
	    <img src="images/foveo.png" alt="box" />
			</li>

	  </ul>
	</div>

</div>


<?php print '</div>';

include "footer.php";
?>