<?php

// Compatibility with PHP Report Maker
if (!isset($Language)) {
	include_once "ewcfg13.php";
	include_once "ewshared13.php";
	$Language = new cLanguage();
}

// Responsive layout
if (ew_IsResponsiveLayout()) {
	$gsHeaderRowClass = "hidden-xs ewHeaderRow";
	$gsMenuColumnClass = "hidden-xs ewMenuColumn";
	$gsSiteTitleClass = "hidden-xs ewSiteTitle";
} else {
	$gsHeaderRowClass = "ewHeaderRow";
	$gsMenuColumnClass = "ewMenuColumn";
	$gsSiteTitleClass = "ewSiteTitle";
}
?>
<!DOCTYPE html>
<html>
<head>
<!-- Start WOWSlider.com HEAD section -->
<link rel="stylesheet" type="text/css" href="engine1/style.css" />
<script type="text/javascript" src="engine1/jquery.js"></script>
<!-- End WOWSlider.com HEAD section -->	<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<meta charset="utf-8">
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/css/<?php echo ew_CssFile("bootstrap.css") ?>">
<!-- Optional theme -->
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/css/<?php echo ew_CssFile("bootstrap-theme.css") ?>">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>phpcss/jquery.fileupload-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?>colorbox/colorbox.css">
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ew_IsResponsiveLayout()) { ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?><?php echo ew_CssFile(EW_PROJECT_STYLESHEET_FILENAME) ?>">
<?php if (@$gsCustomExport == "pdf" && EW_PDF_STYLESHEET_FILENAME <> "") { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $EW_RELATIVE_PATH ?><?php echo EW_PDF_STYLESHEET_FILENAME ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.storageapi.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/pStrength.jquery.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/pGenerator.jquery.js"></script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>bootstrap3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/typeahead.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/load-image.all.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jqueryfileupload/jqueryfileupload.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/mobile-detect.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/moment.min.js"></script>
<link href="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>calendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewcalendar.js"></script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "<?php echo $EW_DATE_SEPARATOR ?>"; // Date separator
var EW_TIME_SEPARATOR = "<?php echo $EW_TIME_SEPARATOR ?>"; // Time separator
var EW_DATE_FORMAT = "<?php echo $EW_DATE_FORMAT ?>"; // Default date format
var EW_DATE_FORMAT_ID = "<?php echo $EW_DATE_FORMAT_ID ?>"; // Default date format ID
var EW_DECIMAL_POINT = "<?php echo $EW_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $EW_THOUSANDS_SEP ?>";
var EW_MIN_PASSWORD_STRENGTH = 60;
var EW_GENERATE_PASSWORD_LENGTH = 16;
var EW_GENERATE_PASSWORD_UPPERCASE = true;
var EW_GENERATE_PASSWORD_LOWERCASE = true;
var EW_GENERATE_PASSWORD_NUMBER = true;
var EW_GENERATE_PASSWORD_SPECIALCHARS = false;
var EW_SESSION_TIMEOUT = <?php echo (EW_SESSION_TIMEOUT > 0) ? ew_SessionTimeoutTime() : 0 ?>; // Session timeout time (seconds)
var EW_SESSION_TIMEOUT_COUNTDOWN = <?php echo EW_SESSION_TIMEOUT_COUNTDOWN ?>; // Count down time to session timeout (seconds)
var EW_SESSION_KEEP_ALIVE_INTERVAL = <?php echo EW_SESSION_KEEP_ALIVE_INTERVAL ?>; // Keep alive interval (seconds)
var EW_RELATIVE_PATH = "<?php echo $EW_RELATIVE_PATH ?>"; // Relative path
var EW_SESSION_URL = EW_RELATIVE_PATH + "ewsession13.php"; // Session URL
var EW_IS_LOGGEDIN = <?php echo IsLoggedIn() ? "true" : "false" ?>; // Is logged in
var EW_IS_SYS_ADMIN = <?php echo IsSysAdmin() ? "true" : "false" ?>; // Is sys admin
var EW_CURRENT_USER_NAME = "<?php echo ew_JsEncode2(CurrentUserName()) ?>"; // Current user name
var EW_IS_AUTOLOGIN = <?php echo IsAutoLogin() ? "true" : "false" ?>; // Is logged in with option "Auto login until I logout explicitly"
var EW_TIMEOUT_URL = EW_RELATIVE_PATH + "logout.php"; // Timeout URL
var EW_LOOKUP_FILE_NAME = "ewlookup13.php"; // Lookup file name
var EW_LOOKUP_FILTER_VALUE_SEPARATOR = "<?php echo EW_LOOKUP_FILTER_VALUE_SEPARATOR ?>"; // Lookup filter value separator
var EW_MODAL_LOOKUP_FILE_NAME = "ewmodallookup13.php"; // Modal lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
var EW_UPLOAD_URL = "<?php echo EW_UPLOAD_URL ?>"; // Upload URL
var EW_UPLOAD_THUMBNAIL_WIDTH = <?php echo EW_UPLOAD_THUMBNAIL_WIDTH ?>; // Upload thumbnail width
var EW_UPLOAD_THUMBNAIL_HEIGHT = <?php echo EW_UPLOAD_THUMBNAIL_HEIGHT ?>; // Upload thumbnail height
var EW_MULTIPLE_UPLOAD_SEPARATOR = "<?php echo EW_MULTIPLE_UPLOAD_SEPARATOR ?>"; // Upload multiple separator
var EW_USE_COLORBOX = <?php echo (EW_USE_COLORBOX) ? "true" : "false" ?>;
var EW_USE_JAVASCRIPT_MESSAGE = true;
var EW_MOBILE_DETECT = new MobileDetect(window.navigator.userAgent);
var EW_IS_MOBILE = EW_MOBILE_DETECT.mobile() ? true : false;
var EW_PROJECT_STYLESHEET_FILENAME = "<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>"; // Project style sheet
var EW_PDF_STYLESHEET_FILENAME = "<?php echo EW_PDF_STYLESHEET_FILENAME ?>"; // Pdf style sheet
var EW_TOKEN = "<?php echo @$gsToken ?>";
var EW_CSS_FLIP = <?php echo ($EW_CSS_FLIP) ? "true" : "false" ?>;
var EW_CONFIRM_CANCEL = true;
var EW_SEARCH_FILTER_OPTION = "<?php echo EW_SEARCH_FILTER_OPTION ?>";
</script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/jsrender.min.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewp13.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>jquery/jquery.ewjtable.js"></script>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<script type="text/javascript">
var ewVar = <?php echo json_encode($EW_CLIENT_VAR); ?>;
<?php echo $Language->ToJSON() ?>
</script>
<script type="text/javascript" src="http<?php echo ew_IsHttps() ? "s" : ""; ?>://maps.googleapis.com/maps/api/js?key=AIzaSyD3OIpUon9I3J0m5SFGh7ACe5MPkpYwHuk"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/ewgooglemaps.js"></script>
<script type="text/javascript" src="<?php echo $EW_RELATIVE_PATH ?>phpjs/userfn13.js"></script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<meta name="generator" content="PHPMaker v2017">
</head>
<?php if ($EW_CSS_FLIP) { ?>
<body dir="rtl">
<?php } else { ?>
<body>
<?php } ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
<?php if (@$gsExport == "") { ?>
<div class="ewLayout">
	<!-- header (begin) --><!-- ** Note: Only licensed users are allowed to change the logo ** -->
	<?php if (ew_IsResponsiveLayout()) { ?>
<div>
<!-- Start WOWSlider.com BODY section -->
<div id="wowslider-container1">
<div class="ws_images"><ul>
<?php

$link = mysqli_connect("localhost", "sistema", "sistemabop22");
mysqli_select_db($link, "sistemadecontrol");
$tildes = $link->query("SET NAMES 'utf8'"); //Para que se muestren las tildes correctamente
$result = mysqli_query($link, "SELECT * FROM novedades");
$extraido1= mysqli_fetch_array($result);
$extraido2= mysqli_fetch_array($result);
$extraido3= mysqli_fetch_array($result);
$extraido4= mysqli_fetch_array($result);
$extraido5= mysqli_fetch_array($result);
$extraido6= mysqli_fetch_array($result);
$extraido7= mysqli_fetch_array($result);
$extraido8= mysqli_fetch_array($result);
$extraido9= mysqli_fetch_array($result);
$extraido10= mysqli_fetch_array($result);
mysqli_free_result($result);
mysqli_close($link);
$titulo1= $extraido1['Detalle'];
$imagen1=$extraido1['Archivos'];
$enlace1=$extraido1['Links'];
$titulo2= $extraido2['Detalle'];
$imagen2=$extraido2['Archivos'];
$enlace2=$extraido2['Links'];
$titulo3= $extraido3['Detalle'];
$imagen3=$extraido3['Archivos'];
$enlace3=$extraido3['Links'];
$titulo4= $extraido4['Detalle'];
$imagen4=$extraido4['Archivos'];
$enlace4=$extraido4['Links'];
$titulo5= $extraido5['Detalle'];
$imagen5=$extraido5['Archivos'];
$enlace5=$extraido5['Links'];
$titulo6= $extraido6['Detalle'];
$imagen6=$extraido6['Archivos'];
$enlace6=$extraido6['Links'];
$titulo7= $extraido7['Detalle'];
$imagen7=$extraido7['Archivos'];
$enlace7=$extraido7['Links'];
$titulo8= $extraido8['Detalle'];
$imagen8=$extraido8['Archivos'];
$enlace8=$extraido8['Links'];
$titulo9= $extraido9['Detalle'];
$imagen9=$extraido9['Archivos'];
$enlace9=$extraido9['Links'];
$titulo10= $extraido10['Detalle'];
$imagen10=$extraido10['Archivos'];
$enlace10=$extraido10['Links'];


?>

<li><a href="//<?php echo $enlace1?>"><img src="ArchivosNovedades/<?php echo $imagen1?>" alt="titulo 1" title="<?php echo $titulo1?>" id="wows1_0"/></a></li>
<li><a href="//<?php echo $enlace2?>"><img src="ArchivosNovedades/<?php echo $imagen2?>" alt="titulo 1" title="<?php echo $titulo2?>" id="wows1_1"/></a></li>
<li><a href="//<?php echo $enlace3?>"><img src="ArchivosNovedades/<?php echo $imagen3?>" alt="titulo 1" title="<?php echo $titulo3?>" id="wows1_2"/></a></li>
<li><a href="//<?php echo $enlace3?>"><img src="ArchivosNovedades/<?php echo $imagen4?>" alt="titulo 1" title="<?php echo $titulo4?>" id="wows1_3"/></a></li>
<li><a href="//<?php echo $enlace5?>"><img src="ArchivosNovedades/<?php echo $imagen5?>" alt="titulo 1" title="<?php echo $titulo5?>" id="wows1_4"/></a></li>
<li><a href="//<?php echo $enlace6?>"><img src="ArchivosNovedades/<?php echo $imagen6?>" alt="titulo 1" title="<?php echo $titulo6?>" id="wows1_5"/></a></li>
<li><a href="//<?php echo $enlace7?>"><img src="ArchivosNovedades/<?php echo $imagen7?>" alt="titulo 1" title="<?php echo $titulo7?>" id="wows1_6"/></a></li>
<li><a href="//<?php echo $enlace8?>"><img src="ArchivosNovedades/<?php echo $imagen8?>" alt="titulo 1" title="<?php echo $titulo8?>" id="wows1_7"/></a></li>
<li><a href="//<?php echo $enlace9?>"><img src="ArchivosNovedades/<?php echo $imagen9?>" alt="titulo 1" title="<?php echo $titulo9?>" id="wows1_8"/></a></li>
<li><a href="//<?php echo $enlace10?>"><img src="ArchivosNovedades/<?php echo $imagen10?>" alt="titulo 1" title="<?php echo $titulo10?>" id="wows1_9"/></a></li>
</ul>
</div>
	<div class="ws_bullets"><div>
		<a href="#" title="titulo 1"><span><img src="data1/tooltips/1.jpg" alt="titulo 1"/>1</span></a>
		<a href="#" title="titulo2"><span><img src="data1/tooltips/2.jpg" alt="titulo2"/>2</span></a>
		<a href="#" title="titulo 3"><span><img src="data1/tooltips/3.jpg" alt="titulo 3"/>3</span></a>
		<a href="#" title="titulo 4"><span><img src="data1/tooltips/4.jpg" alt="titulo 4"/>4</span></a>
		<a href="#" title="titulo 5"><span><img src="data1/tooltips/5.jpg" alt="titulo 5"/>5</span></a>
		<a href="#" title="titulo 6"><span><img src="data1/tooltips/6.jpg" alt="titulo 6"/>6</span></a>
		<a href="#" title="titulo 7"><span><img src="data1/tooltips/7.jpg" alt="titulo 7"/>7</span></a>
		<a href="#" title="titulo 8"><span><img src="data1/tooltips/8.jpg" alt="titulo 8"/>8</span></a>
		<a href="#" title="titulo9"><span><img src="data1/tooltips/9.jpg" alt="titulo9"/>9</span></a>
		<a href="#" title="titulo 10"><span><img src="data1/tooltips/10.jpg" alt="titulo 10"/>10</span></a>
	</div></div><div class="ws_script" style="position:absolute;left:-99%"><a href="http://wowslider.net">jquery slider</a> by WOWSlider.com v8.7</div>
<div class="ws_shadow"></div>
</div>	
<script type="text/javascript" src="engine1/wowslider.js"></script>
<script type="text/javascript" src="engine1/script.js"></script>
<!-- End WOWSlider.com BODY section -->
<nav id="ewMobileMenu" role="navigation" class="navbar navbar-default visible-xs hidden-print">
	<div class="container-fluid"><!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button data-target="#ewMenu" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo (EW_MENUBAR_BRAND_HYPERLINK <> "") ? EW_MENUBAR_BRAND_HYPERLINK : "#" ?>"><?php echo (EW_MENUBAR_BRAND <> "") ? EW_MENUBAR_BRAND : $Language->ProjectPhrase("BodyTitle") ?></a>
		</div>
		<div id="ewMenu" class="collapse navbar-collapse" style="height: auto;"><!-- Begin Main Menu -->
<?php
	$RootMenu = new cMenu("MobileMenu");
	$RootMenu->MenuBarClassName = "";
	$RootMenu->MenuClassName = "nav navbar-nav";
	$RootMenu->SubMenuClassName = "dropdown-menu";
	$RootMenu->SubMenuDropdownImage = "";
	$RootMenu->SubMenuDropdownIconClassName = "icon-arrow-down";
	$RootMenu->MenuDividerClassName = "divider";
	$RootMenu->MenuItemClassName = "dropdown";
	$RootMenu->SubMenuItemClassName = "dropdown";
	$RootMenu->MenuActiveItemClassName = "active";
	$RootMenu->SubMenuActiveItemClassName = "active";
	$RootMenu->MenuRootGroupTitleAsSubMenu = TRUE;
	$RootMenu->MenuLinkDropdownClass = "ewDropdown";
	$RootMenu->MenuLinkClassName = "icon-arrow-right";
?>
<?php include_once "ewmobilemenu.php" ?>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<?php } ?>
	<!-- header (end) -->
	<!-- content (begin) -->
	<div id="ewContentTable" class="ewContentTable">
		<div id="ewContentRow">
			<div id="ewMenuColumn" class="<?php echo $gsMenuColumnClass ?>">
				<!-- left column (begin) -->
				<div class="ewMenu">
<?php include_once "ewmenu.php" ?>
				</div>
				<!-- left column (end) -->
			</div>
			<div id="ewContentColumn" class="ewContentColumn">
				<!-- right column (begin) -->
				<h4 class="<?php echo $gsSiteTitleClass ?>"><?php echo $Language->ProjectPhrase("BodyTitle") ?></h4>
<?php } ?>
<?php } ?>
