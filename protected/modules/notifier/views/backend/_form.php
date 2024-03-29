<div class="form">

    <?php
    $rules = Notifier::getRules();

    $form = $this->beginWidget('CustomForm', array(
        'id' => 'Notifier-form',
        'enableClientValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'class' => 'well form-disable-button-after-submit'),
    ));

    ?>
    <p class="note">
        <?php echo Yii::t('common', 'Fields with <span class="required">*</span> are required.'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <?php
    if (in_array($model->status, array(NotifierModel::STATUS_SEND_USER, NotifierModel::STATUS_SEND_ALL))) {
        echo CHtml::tag('h3', array(), tt('Mail template for users'));
        //echo $form->dropDownListControlGroup($model, 'status', NotifierModel::getStatusList());

        $this->widget('application.modules.lang.components.langFieldWidget', array(
            'model' => $model,
            'field' => 'subject',
            'type' => 'string'
        ));

        $this->widget('application.modules.lang.components.langFieldWidget', array(
            'model' => $model,
            'field' => 'body',
            'type' => 'text-editor',
            'note' => $model->getRulesFieldsString($rules, 'user'),
        ));

        echo '<hr>';
    }

    if ($model->status != NotifierModel::STATUS_SEND_USER) {
        echo CHtml::tag('h3', array(), tt('Mail template for admin'));

        $this->widget('application.modules.lang.components.langFieldWidget', array(
            'model' => $model,
            'field' => 'subject_admin',
            'type' => 'string'
        ));

        $this->widget('application.modules.lang.components.langFieldWidget', array(
            'model' => $model,
            'field' => 'body_admin',
            'type' => 'text-editor',
            'note' => $model->getRulesFieldsString($rules, 'user'),
        ));
    }

    ?>

    <div class="clear"></div>
    <br />

    <div class="form-group buttons">
        <?php
        echo AdminLteHelper::getSubmitButton($model->isNewRecord ? tc('Add') : tc('Save'));

        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

