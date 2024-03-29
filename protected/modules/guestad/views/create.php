<?php
$this->pageTitle .= ' - ' . tc("List your property");
$this->breadcrumbs = array(
    tt('Add ad', 'common')
);

?>

<div class="title highlight-left-right">
    <div>
        <h1><?php echo tt('Add ad', 'common'); ?></h1>
    </div>
</div>
<div class="clear"></div><br />

<?php
//Yii::app()->clientScript->registerCssFile( Yii::app()->clientScript->getCoreScriptUrl(). '/jui/css/base/jquery-ui.css' );
HSite::registerMainAssets();

Yii::app()->clientScript->registerScript('redirectType', "
    $(document).ready(function() {
        var BASE_URL = " . CJavaScript::encode(Yii::app()->baseUrl) . ";

        $('.form').on('change', '#obj_type, #ap_type', function() {
            $('#update_overlay').show();
            $('#is_update').val(1);
            $('#Apartment-form').submit(); return false;
        });
    });
	", CClientScript::POS_BEGIN, array(), true);

Yii::app()->clientScript->registerScript('show-special', '
		// price poa
		if($("#Apartment_is_price_poa").is(":checked")){
			$("#price_fields").hide();
		}
		$("#Apartment_is_price_poa").bind("change", function(){
			if($(this).is(":checked")){
				$("#price_fields").hide();
			} else {
				$("#price_fields").show();
			}
		});
	', CClientScript::POS_READY);

?>

<div class="form">
    <div id="update_overlay"><p><?php echo tc('Loading content...'); ?></p></div>

    <?php
    $ajaxValidation = false;
    if (!$model->isNewRecord) {
        $htmlOptions = array('enctype' => 'multipart/form-data', 'class' => 'well form-disable-button-after-submit');
    } else {
        $htmlOptions = array('class' => 'well form-disable-button-after-submit');
    }

    /** @var $form BootActiveForm */
    $form = $this->beginWidget('CustomActiveForm', array(
        'id' => 'Apartment-form',
        'enableAjaxValidation' => $ajaxValidation,
        'htmlOptions' => $htmlOptions,
    ));

    ?>

    <p class="note"><?php echo Yii::t('common', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary(array($model, $user, $login)); ?>

    <?php
    $this->renderPartial('//../modules/apartments/views/backend/__form_general', array(
        'model' => $model,
        'form' => $form,
        'seasonalPricesModel' => $seasonalPricesModel,
        'callFrom' => 'guestAdModule',
    ));

    $tabs = array();
    if (param('useUserRegistration')) {
        $tabs['tab_register'] = array(
            'title' => tc('Join now'),
            'content' => $this->renderPartial('_create_tab_register', array('user' => $user, 'form' => $form), true),
        );
    }

    $tabs['tab_login'] = array(
        'title' => tc('Login'),
        'content' => $this->renderPartial('_create_tab_login', array('model' => $login, 'form' => $form), true),
    );

    $this->widget('CTabView', array(
        'tabs' => $tabs,
        'activeTab' => $activeTab,
    ));

    ?>

    <br/>
    <?php
    echo '<div class="form-group buttons save">';
    echo CHtml::button(tc('Save'), array(
        'onclick' => "$('#Apartment-form').submit(); return false;", 'class' => 'btn btn-primary big_button button-blue submit-button',
    ));
    echo '</div>';

    ?>

    <?php $this->endWidget(); ?><!-- form -->
</div>

