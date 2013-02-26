<?php

if(isset($_GET['user'])):

   $user = $_GET['user'];

else:

   $user = 'thinkphp';

endif;

require_once('src/gists.class.php');

    $obj = new Gist();

    $resp = json_decode($obj->all($user),true);
    

//@param $entries Array
//@return returns the activities in a UL element
function building_gists($entries) {

     $out = '<ul id="gists">';
     if(count($entries) > 0) {
        foreach($entries as $entry) {
               
              $link = $entry['html_url'];    
              $created_at = $entry['created_at'];
              $content = $entry['description'];

              $files = $entry['files'];
              list($a,$b) = each($files);

              $file = $files[$a]; 
              $language = $file['language'];

              $out .= "<li><a target='_blank' href='{$link}'>{$content}</a> <span class='language'> (language: {$language})<span><br/><span class='small grey'>created {$created_at}</span></li>";
        }
     } else {
       $out .= '</li>No Entries found.</li>';
     }
       $out .= '</ul>';
  return $out;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>My Github:gists</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
<style type="text/css">
#gists li a {color: #444444;    font-family: Arial;    font-size: 17px;    line-height: 20px;    text-decoration: underline;}
#gists span.small {font-size: 12px}
#gists span.grey {color: #323232;}
#gists span.language {color: #888;font-style: oblique}
h3 {background-color: #555555;
    border-radius: 8px 8px 8px 8px;
    color: #FFFFFF;
    font-size: 150%;
    font-weight: bold;
    margin: 0;
    padding: 10px;
    text-align: left;}
h3 span.gists {color: orange}
h3 span.github {color: #ccc}
</style>

</head>
<body class="yui-skin-sam">
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h3>My <span class="github">Github</span>:<span class='gists'>gists</span></h3></div>
   <div id="bd" role="main">
	<div class="yui-g">

           <?php echo building_gists($resp); ?>

	</div>
	</div>
   <div id="ft" role="contentinfo"><p>Created by <a href="http://thinkphp.ro/+">google+</a></p></div>
</div>
</body>
</html>