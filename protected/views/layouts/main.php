<?php
	$baseurl = Yii::app()->baseUrl; 
	$cs = Yii::app()->getClientScript();
	$cs->registerMetaTag(null, null, null,array('charset'=>'utf-8'));
	$cs->registerMetaTag('en-GB', 'language');
	$cs->registerLinkTag('shortcut icon','image/x-ico',$baseurl.'/images/favicon.png');
	$cs->registerLinkTag('publisher',NULL,'https://plus.google.com/+KeremSevencan');
	$cs->registerLinkTag('author',NULL,'https://plus.google.com/+KeremSevencan/posts');
	$cs->registerMetaTag('yes', 'apple-mobile-web-app-capable');
	$cs->registerMetaTag('width=device-width, initial-scale=1.0, user-scalable=no', 'viewport');
	$cs->registerMetaTag('A showcase for dribbble prospects show their shots to dribbble players.', 'description');
	$cs->registerMetaTag('dribbble,showcase,prospects', 'keywords');
	$cs->registerCssFile($baseurl.'/css/bootstrap.css');
	$cs->registerCssFile($baseurl.'/css/animate.css');
	$cs->registerCssFile($baseurl.'/css/style.css');
	$cs->registerScriptFile($baseurl.'/js/jquery.min.js',CClientScript::POS_END);
	$cs->registerScriptFile($baseurl.'/js/cookie.js',CClientScript::POS_END);
	$cs->registerScriptFile($baseurl.'/js/tab.js',CClientScript::POS_END);
	$cs->registerScriptFile($baseurl.'/js/tooltip.js',CClientScript::POS_END);
	$cs->registerScriptFile($baseurl.'/js/application.js',CClientScript::POS_END);
?>
<!DOCTYPE html>
<html lang="en">
<head><title><?php echo CHtml::encode($this->pageTitle); ?></title></head>
<body class="frontend">
<?php 
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '"><div class="container">' . $message . "</div></div>\n";
    }
?>
	<div class="container" id="page">
		<div id="header">
			<h1 class="logoarea"><a href="<?php echo Yii::app()->request->baseUrl; ?>/">Layup</a></h1>
			<div class="btn-group action-list">
			<?php if ((!Yii::app()->user->isGuest)) {
				echo '<a href="http://dribbble.com/'.Yii::app()->user->username.'" class="btn avatar" target="_blank"><img width="36" height="36" src="'.Yii::app()->user->avatar_url.'"/>'.Yii::app()->user->name.'</a>';
				if (Yii::app()->user->type=="Player") {
					echo '<a href="'.Yii::app()->createUrl('shots/share').'" class="btn btn-primary">Share</a>';
				} else {
					echo '<a href="'.Yii::app()->createUrl('shots/new').'" class="btn btn-primary">Upload</a>';
				}
				echo '<a href="'.Yii::app()->createUrl('site/logout').'" class="btn btn-primary">Logout</a>';
    		} else { 
    			echo '<a href="'.Yii::app()->createUrl('site/signin').'" class="btn btn-primary">Sign in with Dribbble</a>';
    		}
    		?>
    		</div>
		</div>
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
		<div id="footer">
			Copyright © 2014 Layup. All Rights Reserved. <a href="<?php echo Yii::app()->createUrl('site/about'); ?>">About</a> | <a href="https://github.com/keremciu/layup" target="_blank">Github</a>
		</div>
	</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-10277838-7', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>