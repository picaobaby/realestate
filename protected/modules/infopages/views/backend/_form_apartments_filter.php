<?php
$cs = Yii::app()->clientScript;
$baseThemeUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseThemeUrl . '/js/sumoselect/jquery.sumoselect.js', CClientScript::POS_BEGIN);
$cs->registerCssFile($baseThemeUrl . '/js/sumoselect/sumoselect.css');

?>

<div id="apartments_filter" style="display: none;" class="well">
    <h4><?php echo tt('Filter for listings\' list') ?></h4>
    <?php if (issetModule('location')) { ?>
        <div class="">
            <div class=""><?php echo tc('Country') ?>:</div>
            <?php
            echo CHtml::dropDownList(
                'filter[country_id]', $this->getFilterValue('country_id'), Country::getCountriesArray(2), array('class' => 'searchField form-control', 'id' => 'country',
                'ajax' => array(
                    'type' => 'GET',
                    'url' => $this->createUrl('/location/main/getRegions'),
                    'data' => 'js:"country="+$("#country").val()+"&type=2"',
                    'success' => 'function(result){
							$("#region").html(result);
							$("#region").change();
						}'
                )
                )
            );

            ?>
        </div>

        <div class="">
            <div class=""><?php echo tc('Region') ?>:</div>
            <?php
            echo CHtml::dropDownList(
                'filter[region_id]', $this->getFilterValue('region_id'), Region::getRegionsArray($this->getFilterValue('country_id'), 2), array('class' => 'searchField form-control', 'id' => 'region',
                'ajax' => array(
                    'type' => 'GET',
                    'url' => $this->createUrl('/location/main/getCities'),
                    'data' => 'js:"region="+$("#region").val()+"&type=2"',
                    'success' => 'function(result){
							$("#ap_city").html(result);' . ((issetModule('metroStations')) ? '$("#ap_city").change()' : '') .
                    '}'
                )
                )
            );

            ?>
        </div>
        <?php
        $cities = City::getCitiesArray($this->getFilterValue('region_id'), 2);
    }

    $objTypes = CArray::merge(array(0 => ''), ApartmentObjType::getList());
    //$typeList = CArray::merge(array(0 => ''), HApartment::getTypesArray());
    $typeList = HApartment::getTypesForSearch(true, false);

    $roomItems = array(
        '0' => '',
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => Yii::t('common', '4 and more'),
    );

    $ownersList = array(
        0 => '',
        User::TYPE_PRIVATE_PERSON => tc('Private person'),
        User::TYPE_AGENCY => tc('Company'),
    );

    ?>

    <?php if (issetModule('metroStations')): ?>
        <?php $metros = MetroStations::getMetrosArray($this->getFilterValue('city_id'), 0); ?>
        <div class="">
            <div class=""><?php echo Yii::t('common', 'City') ?>:</div>
            <?php
            $cities = (isset($cities) && count($cities)) ? $cities : CArray::merge(array(0 => tc('select city')), ApartmentCity::getAllCity());

            echo CHtml::dropDownList(
                'filter[city_id]', $this->getFilterValue('city_id'), $cities, array(
                'class' => ' searchField form-control',
                'id' => 'ap_city',
                'ajax' => array(
                    'type' => 'GET',
                    'url' => $this->createUrl('/metroStations/main/getMetroStations'),
                    'data' => 'js:"city="+$("#ap_city").val()+"&type=0"',
                    'dataType' => 'json',
                    'success' => 'function(result){
							if (result.dropdownMetro) { 
								//$("#metro-block").show(); 
								$("#metro").html(result.dropdownMetro);
								$("#metro").trigger("chosen:updated");
								//$("#metro")[0].sumo.reload();
							} 
							else { 
								//$("#metro-block").hide(); 
								$("#metro").html("");
								$("#metro").trigger("chosen:updated");
								//$("#metro")[0].sumo.reload();
							}
						}'
                ),
                )
            );

            ?>
        </div>
        <div class="" id="metro-block" style="display: block; <?php /* echo ($metros && count($metros) > 1) ? 'block;' : 'none;'; */ ?>">
            <div class=""><?php echo Yii::t('common', 'Subway stations') ?>:</div>
            <?php
            echo Chosen::multiSelect('filter[metro][]', $this->getFilterValue('metro'), $metros, array('id' => 'metro', 'class' => ' searchField span3 form-control', 'data-placeholder' => tt('Select metro stations', 'metroStations'))
            );
            echo "<script>$('#metro').chosen();</script>";

            ?>
        </div>
        <br />
    <?php else: ?>
        <div class="">
            <div class=""><?php echo Yii::t('common', 'City') ?>:</div>
            <?php
            $cities = (isset($cities) && count($cities)) ? $cities : CArray::merge(array(0 => tc('select city')), ApartmentCity::getAllCity());

            echo CHtml::dropDownList(
                'filter[city_id]', $this->getFilterValue('city_id'), $cities, array('class' => ' searchField form-control', 'id' => 'ap_city') //, 'multiple' => 'multiple'
            );

            ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <div class=""><?php echo tt("Is located", 'apartments') ?>:</div>
        <?php
        $this->widget('CAutoComplete', array(
            'model' => $model,
            'attribute' => 'parent_id_autocomplete',
            'url' => array('/infopages/backend/main/getParentObject'),
            'multiple' => true,
            'htmlOptions' => array(
                'class' => 'span5 form-control',
                'onblur' => 'checkFillParentId($(this));',
                'onkeyup' => 'checkFillParentId($(this));',
                'id' => 'Apartment_parent_id_autocomplete',
            ),
            'minChars' => 0,
            'matchCase' => false,
            'methodChain' => ".result(function(event,item){\$(\"#Apartment_parent_id\").val(item[1]);})",
        ));

        ?>
        <div><span class="label label-info"><?php echo tc('enter initial letters'); ?></span></div>

        <?php echo CHtml::hiddenField('filter[parent_id]', $model->parent_id, array('id' => 'Apartment_parent_id')); ?>
        <script>
            function checkFillParentId(elem) {
                if (elem.val().length < 1) {
                    $("#Apartment_parent_id").val('');
                    $("#Apartment_parent_id_autocomplete").val('');
                }
            }
        </script>
        <br />
    </div>	

    <div class="form-group">
        <div class=""><?php echo tc('Type') ?>:</div>
        <?php echo CHtml::dropDownList('filter[type]', $this->getFilterValue('type'), $typeList, array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <div class=""><?php echo tc('Property type') ?>:</div>
        <?php echo CHtml::dropDownList('filter[obj_type_id]', $this->getFilterValue('obj_type_id'), $objTypes, array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <div class=""><?php echo tc('Number of rooms') ?>:</div>
        <?php
        echo CHtml::dropDownList('filter[rooms]', $this->getFilterValue('rooms'), $roomItems, array('class' => 'form-control'));

        ?>
    </div>

    <div class="form-group">
        <div class=""><?php echo tc('Listing from') ?>:</div>
        <?php echo CHtml::dropDownList('filter[ot]', $this->getFilterValue('ot'), $ownersList, array('class' => 'form-control')); ?>
    </div>

    <div class="form-group">
        <div class=""><?php echo tc('Square') ?>:</div>
        <div>
            <?php echo CHtml::textField('filter[square_min]', $this->getFilterValue('square_min', ''), array('class' => 'width100 form-control inline', 'placeholder' => tc('Square from'))); ?>
            <?php echo CHtml::textField('filter[square_max]', $this->getFilterValue('square_max', ''), array('class' => 'width100 form-control inline', 'placeholder' => tc('Square to'))); ?>
            <span class=""><?php echo tc("site_square"); ?></span>
        </div>
    </div>

    <div class="form-group">
        <div class=""><?php echo tc('Floor') ?>:</div>
        <div>
            <?php echo CHtml::textField('filter[floor_min]', $this->getFilterValue('floor_min', ''), array('class' => 'width100 form-control inline', 'placeholder' => tc('Floor from'))); ?>
            <?php echo CHtml::textField('filter[floor_max]', $this->getFilterValue('floor_max', ''), array('class' => 'width100 form-control inline', 'placeholder' => tc('Floor to'))); ?>
        </div>
    </div>

    <div class="form-group">
        <?php
        echo CHtml::checkBox('filter[wp]', $this->getFilterValue('wp'), array(
            'id' => 'search_with_photo',
            'style' => 'margin: 0 5px 0 0; vertical-align: middle;'
        ));

        echo CHtml::label(Yii::t('common', 'Only with photo'), 'search_with_photo', array('style' => 'display: inline; vertical-align: middle; margin: 2px 0 0 0;'));

        ?>
    </div>

    <?php if (isset($addedFields) && $addedFields && count($addedFields)) : ?>
        <?php foreach ($addedFields as $adField): ?>
            <div class="form-group">
                <div class=""><?php echo $adField['label']; ?>:</div>
                <?php
                if ($adField['type'] == FormDesigner::TYPE_MULTY) {
                    echo CHtml::dropDownList('filter[' . $adField['field'] . ']', $this->getFilterValue($adField['field']), $adField['listData'], array('class' => 'form-control ', 'multiple' => 'multiple', 'placeholder' => 'Выберите', 'id' => $adField['field'])
                    );
                    echo "<script>$('#" . $adField['field'] . "').SumoSelect({captionFormat: '" . tc('{0} Selected') . "', selectAlltext: '" . tc('check all') . "', csvDispCount:1, filter: true, filterText: '" . tc('enter initial letters') . "', filter: true, filterText: '" . tc('enter initial letters') . "'});</script>";
                } elseif (isset($adField['listData']) && $adField['listData']) {

                    ?>
                    <?php echo CHtml::dropDownList('filter[' . $adField['field'] . ']', $this->getFilterValue($adField['field']), CMap::mergeArray(array("" => ""), $adField['listData']), array('class' => 'form-control')); ?>
                <?php } else { ?>
                    <?php echo CHtml::textField('filter[' . $adField['field'] . ']', $this->getFilterValue($adField['field']), array('class' => 'form-control')); ?>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>