<!DOCTYPE html>
<html lang="en">
<head>
<title><?php print !empty($page['title'])?$page['title']:''; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="p:domain_verify" content="226c67a724269e614b55e5a7f771c00f"/>
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
    <div class="clearfix">
        <header class="navbar navbar-dark navbar-fixed-top bd-navbar">
            <div class="clearfix">
                <button class="navbar-toggler pull-xs-right hidden-sm-up" type="button" data-toggle="collapse" data-target="#bd-main-nav">
                &#9776;
                </button>
                <a class="navbar-brand hidden-sm-up ik-title" href="/">
                    <img src="/asset/template/img/logo.png" height="56" width="185" alt="Ikeio.com">
                </a>
            </div>
            <div class="collapse navbar-toggleable-xs" id="bd-main-nav">
                <nav class="nav navbar-nav navbar-left hidden-xs-down">
                    <a class="navbar-brand ik-title" href="/"><img src="/asset/template/img/logo.png" height="56" width="185" alt="Ikeio.com"></a>
                </nav>
<?php if(empty($user)){?>
                <nav class="nav navbar-nav pull-sm-right hidden-xs-down ik-menu">
                    <a class="nav-item nav-link pull-xs-right loginlink">Log In</a>
                    <a class="nav-item nav-link pull-xs-right" href="/signup">Sign Up</a>
                    <form class="form-inline pull-xs-right ik-searchbox">
                        <input class="form-control search" type="text" placeholder="Search">
                        <button class="btn searchbutton" type="submit">Search</button>
                    </form>
                </nav>
                <nav class="nav navbar-nav hidden-sm-up ik-ddmenu">
                    <a class="nav-item nav-link" href="/signup">Sign Up</a>
                    <a class="nav-item nav-link loginlink">Login</a>
                    <form class="ik-ddsearchbox">
                        <input class="form-control search" type="text" placeholder="Search">
                        <button class="btn" type="submit">Search</button>
                    </form>
                </nav>
<?php }else{ ?>
                <ul class="nav navbar-nav pull-sm-right hidden-xs-down ik-menu">
                    <li class="nav-item">
                        <form class="form-inline pull-xs-right ik-searchbox">
                            <input class="form-control search" type="text" placeholder="Search">
                            <button class="btn" type="submit">Search</button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/manage">My Collections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/offer">My Offers</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">My Account (<?php echo $user['username']?>)</a>
                            <a class="dropdown-item" href="/auth/logout">Log Out</a>
                        </div>
                    </li>
                </ul>
                <nav class="nav navbar-nav hidden-sm-up ik-ddmenu">
                    <a class="nav-item nav-link" href="/manage">My Collections</a>
                    <a class="nav-item nav-link" href="/offer">My Offers</a>
                    <a class="nav-item nav-link" href="#ik-ddprofile" data-toggle="collapse" aria-expanded="false">Profile</span></a>
                    <div class="collapse" id="ik-ddprofile">
                        <a class="ik-ddprofile-item" href="#">My Account (<?php echo $user['username']?>)</a>
                        <a class="ik-ddprofile-item" href="/auth/logout">Log Out</a>
                    </div>
                    <form class="ik-ddsearchbox">
                        <input class="form-control search" type="text" placeholder="Search">
                        <button class="btn" type="submit">Search</button>
                    </form>
                </nav>
<?php } ?>
            </div>
        </header>
    </div>
