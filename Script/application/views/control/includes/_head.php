<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php compileScss(); ?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
<link rel="icon" href="<?=  base_url("assets/images/favicon.png") ?>">
<meta name="robots" content="noindex, onfollow">

<!-- JQUERY -->
<script src="<?= base_url("assets/libraries/jquery-3.3.1/jquery.min.js"); ?>"></script>


<!-- SEMANTIC-UI -->
<link rel="stylesheet" href="<?= base_url("assets/frameworks/semantic-ui-2.4.1/semantic.min.css"); ?>">
<script src="<?= base_url("assets/frameworks/semantic-ui-2.4.1/semantic.min.js"); ?>"></script>


<!-- JS -->
<script src="<?= base_url("assets/control/js/functions.js")."?v=".time() ?>"></script>
<script src="<?= base_url("assets/control/js/app.js")."?v=".time() ?>"></script>


<!-- CSS -->
<link rel="stylesheet" href="<?= base_url("assets/control/css/style.css")."?v=".time() ?>">
<link rel="stylesheet" href="<?= base_url("assets/control/css/responsive.css")."?v=".time() ?>">
<link rel="stylesheet" href="<?= base_url("assets/control/css/spacing.css")."?v=".time() ?>">



<script type="text/javascript">
function parseJSAtOnload() {
var links = ["assets/libraries/jquery-3.3.1/jquery.min.js", "assets/plugins/jquery-ui.min-1.12.0.js", "assets/frameworks/semantic-ui-2.4.1/semantic.min.js", "assets/plugins/slick-carousel/slick.min.js"],
headElement = document.getElementsByTagName("head")[0],
linkElement, i;
for (i = 0; i < links.length; i++) {
linkElement = document.createElement("script");
linkElement.src = links[i];
headElement.appendChild(linkElement);
}
}
if (window.addEventListener)
window.addEventListener("load", parseJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", parseJSAtOnload);
else window.onload = parseJSAtOnload;
</script>