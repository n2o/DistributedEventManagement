<?php 
/**
 * Show buttons for each chart and make it click-/slideable
 */
echo "
	<a href='#' class='slide_div button' rel='#".$column."Div'>$column Chart</a><br>
	<div id='".$column."Div' class='slidingDiv'>
		<div id='".$column."Chart'></div>
	</div>
";
?>
