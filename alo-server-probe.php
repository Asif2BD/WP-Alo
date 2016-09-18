<?php

function alo_server_probe()

{
	echo '<iframe src="' . plugins_url( 'alo.php', __FILE__ ) . '" height="1200" width="1060" margin-top:-4px; margin-left:-4px; border:none;></iframe>';

}

?>