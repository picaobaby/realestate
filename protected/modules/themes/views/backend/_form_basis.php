<br>
<?php
if (0) {
    echo $form->dropDownListControlGroup($dataModel, 'empty_flag', PaidBooking::getEmptyFlagDays(), array('class' => 'span5'));
    echo $form->textFieldControlGroup($dataModel, 'discount_guest');
}

?>

<div class="panel panel-default">
    <div class="panel-heading"><?= tt('Index page') ?></div>
    <div class="panel-body">
        <?php
        echo $form->checkboxControlGroup($dataModel, 'i_enable_slider_and_pd');
        echo $form->checkboxControlGroup($dataModel, 'i_enable_best_ads');
        echo $form->checkboxControlGroup($dataModel, 'i_enable_feature');
        echo $form->checkboxControlGroup($dataModel, 'i_enable_last_news');
        echo $form->checkboxControlGroup($dataModel, 'i_enable_contact');
        echo '<hr>';
        echo $form->textFieldControlGroup($dataModel, 'i_vk');
        echo $form->textFieldControlGroup($dataModel, 'i_facebook');
        echo $form->textFieldControlGroup($dataModel, 'i_twitter');
        echo '<hr>';
        echo $form->textFieldControlGroup($dataModel, 'i_lng');
		echo $form->textFieldControlGroup($dataModel, 'i_lat');
        echo $form->textFieldControlGroup($dataModel, 'i_zoom');
        ?>
    </div>
</div>

<?php if (0) { ?>
    <div class="panel panel-default">
        <div class="panel-heading"><?= tt('Widget "Popular destinations"') ?></div>

        <div class="panel-body">
            <?php echo $form->checkboxControlGroup($dataModel, 'popular_dest_user_set'); ?>

            <?php require '_form_basis_pd.php' ?>
        </div>
    </div>
<?php } ?>
