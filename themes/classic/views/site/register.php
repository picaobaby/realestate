<?php
$this->pageTitle=Yii::app()->name . ' - '.tc('Join now');
$this->breadcrumbs=array(
	tc('Join now'),
);
?>

<div class="title highlight-left-right">
	<div>
		<h1><?php echo Yii::t('common', 'Join now'); ?></h1>
	</div>
</div>
<div class="clear"></div><br />

<div class="form">
	<?php
		$form=$this->beginWidget('CustomActiveForm', array(
		'action' => Yii::app()->controller->createUrl('/site/register'),
		'id'=>'user-register-form',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('class' => 'form-disable-button-after-submit'),
	));
	?>

	<p class="note"><?php echo Yii::t('common', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', User::getTypeList(), array('class'=>'width200 form-control')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="form-group" id="form-group_agency_name">
		<?php echo $form->labelEx($model,'agency_name'); ?>
		<?php echo $form->textField($model,'agency_name',array('size'=>20,'maxlength'=>128,'class'=>'width200 form-control')); ?>
		<?php echo $form->error($model,'agency_name'); ?>
	</div>

	<?php
		echo '<div class="form-group"  id="form-group_agency_user_id">';
			$agency = HUser::getListAgency();

			echo $form->labelEx($model, 'agency_user_id');
			echo Chosen::dropDownList(get_class($model).'[agency_user_id]', $model->agency_user_id, $agency,
					array('id'=>'agency_user_id', 'data-placeholder' => ' ')
				);
			echo "<script>$('#agency_user_id').chosen();</script>";
			echo $form->error($model, 'agency_user_id');
		echo '</div>';
	?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>128,'class'=>'width200 form-control')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>128,'class'=>'width200 form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<?php if (param('user_registrationMode') == 'without_confirm'):?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>128,'class'=>'width200 form-control')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'password_repeat'); ?>
			<?php echo $form->passwordField($model,'password_repeat',array('size'=>20,'maxlength'=>128,'class'=>'width200 form-control')); ?>
			<?php echo $form->error($model,'password_repeat'); ?>
		</div>
	<?php endif;?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->telField($model,'phone',array('size'=>20,'maxlength'=>20,'class'=>'width200 form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'verifyCode');?>
		<?php $display = (param('useReCaptcha', 0)) ? 'none;' : 'block;'?>
		<?php echo $form->textField($model, 'verifyCode', array('autocomplete' => 'off', 'style' => "display: {$display}"));?><br/>
		<?php
		$this->widget('CustomCaptchaFactory',
			array(
				'captchaAction' => '/site/captcha',
				'buttonOptions' => array('class' => 'get-new-ver-code'),
				'clickableImage' => true,
				'imageOptions'=>array('id'=>'register_captcha'),
				'model' => $model,
				'attribute' => 'verifyCode',
			)
		); ?>
		<?php echo $form->error($model, 'verifyCode');?>
		<br/>
	</div>
	
	<div class="form-group rememberMe">
		<?php echo $form->checkBox($model,'agree'); ?>
		<?php echo $form->label($model,'agree'); ?>
		<?php echo $form->error($model,'agree'); ?>
	</div>

	<div class="form-group submit">
		<?php echo CHtml::submitButton(Yii::t('common', 'Registration'), array('class' => 'button-blue submit-button')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>

<?php if(issetModule('socialauth')) :?>
	<?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login', 'title' => tt('Sign up with', 'socialauth'))); ?>
<?php endif;?>

<script type="text/javascript">
	$(function(){
		regCheckUserType();

		$('#User_type').change(function(){
			regCheckUserType();
		});
	});

	function regCheckUserType(){
		var type = $('#User_type').val();
		if(type == <?php echo CJavaScript::encode(User::TYPE_AGENCY);?>){
			$('#form-group_agency_name').show();
		} else {
			$('#form-group_agency_name').hide();
		}

		if(type == <?php echo CJavaScript::encode(User::TYPE_AGENT);?>){
			$('#form-group_agency_user_id').show();
		} else {
			$('#form-group_agency_user_id').hide();
		}
	}
</script>