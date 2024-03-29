<div id="ore-ads-block">
	<div style="margin: 0 auto; width: 960px;">
	<ul>
		<li>
			<?php
			$isFree = (isFree()) ? true : false;
			$linkTitle = Yii::t('module_install', 'Download', array(), 'messagesInFile', Yii::app()->language);
			$linkHref = (Yii::app()->language == 'ru') ? 'http://open-real-estate.info/ru/download-open-real-estate' : 'http://open-real-estate.info/en/download-open-real-estate';
			if (!$isFree) {
				$linkTitle = Yii::t('module_install', 'Buy', array(), 'messagesInFile', Yii::app()->language);
				$linkHref = (Yii::app()->language == 'ru') ? 'http://open-real-estate.info/ru/contact-us?from=pro' : 'http://open-real-estate.info/en/contact-us?from=pro';
			}

			echo CHtml::link(
				'<span class="download"></span>'.$linkTitle,
				$linkHref,
				array (
					'class' => 'button green',
					'target' => '_blank',
				)
			);
			?>
		</li>
		<?php if (isFree()):?>
			<li>
				<?php
				echo CHtml::link(
					Yii::t('module_install', 'PRO version demo', array(), 'messagesInFile', Yii::app()->language),
					'http://re-pro.monoray.net/',
					array(
						'class' => 'button green',
						'target' => '_blank',
					)
				);
				?>
			</li>

			<li>
				<?php
				echo CHtml::link(
					Yii::t('module_install', 'Add-ons', array(), 'messagesInFile', Yii::app()->language),
					(Yii::app()->language == 'ru') ? 'http://open-real-estate.info/ru/open-real-estate-modules' : 'http://open-real-estate.info/en/open-real-estate-modules',
					array(
						'class' => 'button cyan',
						'target' => '_blank',
					)
				);
				?>
			</li>
		<?php endif;?>
		<li>
			<?php
				echo CHtml::link(
					Yii::t('module_install', 'About product', array(), 'messagesInFile', Yii::app()->language),
					(Yii::app()->language == 'ru') ? 'http://open-real-estate.info/ru/about-open-real-estate' : 'http://open-real-estate.info/en/about-open-real-estate',
					array (
						'class' => 'button cyan',
						'target' => '_blank',
					)
				);
			?>
		</li>
		<li>
			<?php
				echo CHtml::link(
					Yii::t('module_install', 'Contact us', array(), 'messagesInFile', Yii::app()->language),
					(Yii::app()->language == 'ru') ? 'http://open-real-estate.info/ru/contact-us' : 'http://open-real-estate.info/en/contact-us',
					array (
						'class' => 'button cyan',
						'target' => '_blank',
					)
				);
			?>
		</li>
		
		<?php if(Yii::app()->user->isGuest){ ?>
		<li class="item-login">
			<?php
			echo CHtml::link(
				Yii::t('module_install', 'Log in', array(), 'messagesInFile', Yii::app()->language),
				Yii::app()->createUrl('/login'),
				array(
					'class' => 'button orange',
				)
			);
			?>
		</li>
        <li class="item-login-admin-panel">
            <?php
            echo CHtml::link(
                Yii::t('module_install', 'Admin panel', array(), 'messagesInFile', Yii::app()->language),
                Yii::app()->createUrl('/login', array('inadminpanel' => 1)),
                array(
                    'class' => 'button orange',
                )
            );
            ?>
        </li>
		<?php } ?>
	</ul>
	</div>
</div>