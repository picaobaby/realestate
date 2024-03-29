<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title><?php echo CHtml::encode($this->seoTitle ? $this->seoTitle : $this->pageTitle); ?></title>
	<meta name="description" content="<?php echo CHtml::encode($this->seoDescription ? $this->seoDescription : $this->pageDescription); ?>" />
	<meta name="keywords" content="<?php echo CHtml::encode($this->seoKeywords ? $this->seoKeywords : $this->pageKeywords); ?>" />
	<link href='https://fonts.googleapis.com/css?family=Roboto:700,400,300&subset=latin,cyrillic-ext,greek-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/form.css', 'screen'); ?>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css<?php echo (demo()) ? '?v='.ORE_VERSION: '';?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css<?php echo (demo()) ? '?v='.ORE_VERSION: '';?>" media="print" />
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css<?php echo (demo()) ? '?v='.ORE_VERSION: '';?>" media="screen" />

	<!--[if IE]> <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->

	<?php HSite::registerMainAssets();?>
	
	<link rel="icon" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php if (demo()) :?>
	<?php $this->renderPartial('//site/ads-block', array()); ?>
<?php endif; ?>

<div id="container" class="compare-main" <?php echo (demo()) ? 'style="padding-top: 40px;"' : '';?> >
	<div class="logo">
		<a title="<?php echo Yii::t('common', 'Go to main page'); ?>" href="<?php echo Yii::app()->controller->createAbsoluteUrl('/'); ?>">
			<div class="logo-img"> <img width="77" height="70" alt="" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/pages/logo-open-ore.png" /></div>
			<div class="logo-text"><?php echo CHtml::encode(Yii::app()->name);?></div>
		</a>
	</div>

	<div class="clear"></div>
	<div class="contentCompare">
		<?php echo $content; ?>
		<div class="clear"></div>
	</div>

	<div class="footer">
		<?php echo getGA(); ?>
        <?php echo getJivo(); ?>
		<p class="slogan">&copy;&nbsp;<?php echo CHtml::encode(Yii::app()->name).', '.date('Y'); ?></p>
		<!-- <?php echo ORE_VERSION_NAME . ' ' . ORE_VERSION; ?> -->
	</div>
</div>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>
</body>
</html>