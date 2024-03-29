<div class="form">

    <?php
    $form = $this->beginWidget('CustomForm', array(
        'id' => $this->modelName . '-form',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('class' => 'well form-disable-button-after-submit'),
    ));

    ?>

    <p class="note"><?php echo Yii::t('common', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->isNewRecord) { ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'category'); ?>
            <?php echo $form->textField($model, 'category', array('class' => 'width450')); ?>
            <?php echo $form->error($model, 'category'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'message'); ?>
            <?php echo $form->textField($model, 'message', array('class' => 'width450')); ?>
            <?php echo $form->error($model, 'message'); ?>
        </div>
    <?php } else { ?>
        <div class="form-group">
            <p><strong><?php echo tt('category'); ?>:</strong> <?php echo $model->category; ?></p>
            <p><strong><?php echo tt('String constant (defined in code)'); ?>:</strong> <?php echo CHtml::encode($model->message); ?></p>
        </div>
    <?php } ?>

    <?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
        'model' => $model,
        'field' => 'translation',
        'type' => 'text'
    ));

    ?>
    <div class="clear"></div>

    <div class="form-group buttons">
        <?php
        echo AdminLteHelper::getSubmitButton($model->isNewRecord ? tc('Add') : tc('Save'));

        ?>
   	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->