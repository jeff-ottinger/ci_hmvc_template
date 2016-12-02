<!DOCTYPE html>
<html lang="en">
<head>
<title><?php print !empty($page['title'])?$page['title']:''; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="UTF-8" />
<?php
if (isset($page["meta"])) {
    foreach ($page["meta"] as $key => $value) {
?>
	<meta name="<?php print $key; ?>" content="<?php print $value; ?>" />
<?php
    }
}
$this->assets->printCSS();
$this->assets->printJS();
?>
</head>
<body>
