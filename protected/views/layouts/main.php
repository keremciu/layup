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
	$cs->registerCssFile($baseurl.'/css/style.css');
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
			<h1 class="logoarea"><a href="<?php echo Yii::app()->request->baseUrl; ?>">Dribbbler</a></h1>
			<div class="btn-group">
			<?php if ((!Yii::app()->user->isGuest)) {
				echo '<a href="'.Yii::app()->createUrl('site/logout').'" class="btn btn-primary">Upload</a>';
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
	</div>
</body>
</html>