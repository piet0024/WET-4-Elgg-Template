<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	_elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

// render content before head so that JavaScript and CSS can be loaded. See #4032

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));

$header = elgg_view('page/elements/header', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
//$acion
$topcanbar = elgg_view('page/elements/topcanbar', $vars);
$wavyblue = elgg_view('page/elements/wavyblue', $vars);
$tabskip = elgg_view('page/elements/tabskip', $vars);

$body = <<<__BODY
    $tabskip
<div class="elgg-page elgg-page-default">
	
__BODY;

//$body .= elgg_view('page/elements/topbar_wrapper', $vars);

$body .= <<<__BODY
	<header class="" role="banner">
    
    	<div id="wb-bnr">
	   $topcanbar

        $wavyblue
	</div>

        
			$header
		
  
	</header>
	<nav role="navigation" id="wb-sm"  data-trgt="mb-pnl" class="wb-menu visible-md visible-lg" typeof="SiteNavigationElement">
    
    <div class="container nvbar">
          
            <div class="row">
               $navbar
            </div>
        </div>
		
	</nav>
    
    <div class="elgg-page-messages">
		$messages
	</div>
	<main role="main" property="mainContentOfPage" class="container">
		<div class="elgg-inner">
			$content
		</div>
	</main>
	<footer role="contentinfo" id="wb-info" class="visible-sm visible-md visible-lg wb-navcurr">
		
			$footer
		
	</footer>
</div>
__BODY;

//$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);
