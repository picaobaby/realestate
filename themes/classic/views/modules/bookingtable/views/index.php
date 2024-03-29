<?php
$this->pageTitle .= ' - '.tt('Booking applications', 'usercpanel');
$this->breadcrumbs = array(
    tc('Control panel') => Yii::app()->createUrl('/usercpanel'),
    tt('Booking applications', 'usercpanel'),
);


if (issetModule('bookingcalendar')) {
	echo "<div class='flash-notice'>".tt('booking_table_to_calendar', 'booking')."</div>";
}
?>

<?php
	$this->widget('NoBootstrapGridView',
		array(
			'id'=>'users-booking-grid',
			'afterAjaxUpdate' => 'function(){attachStickyTableHeader();}',
			'dataProvider'=>$model->search(true),
			'filter'=>$model,
			'columns' => array(
				/*array(
					'name' => 'id',
					'htmlOptions' => array(
						'class' => 'id_column',
					),
				),*/
				array(
					'name' => 'active',
					'type' => 'raw',
					'value' => 'Yii::app()->controller->returnBookingTableStatusHtml($data, "users-booking-grid", 1)',
					'htmlOptions' => array(
						'style' => 'width: 150px;',
						//'class'=>'apartments_status_column',
					),
					'sortable' => false,
					'filter' => Bookingtable::getAllStatuses(),
				),
				array(
					'name' => 'apartment_id',
					'type' => 'raw',
					'value' => '(isset($data->apartment) && $data->apartment->id) ? CHtml::link($data->apartment->id, $data->apartment->getUrl()) : tc("No")',
					'filter' => false,
					'sortable' => false,
				),
				array(
					'name' => 'num_guest',
					'filter' => true,
					'sortable' => false,
				),
				array(
					'name' => 'username',
					'value' => '$data->username',
					'filter' => true,
					'sortable' => false,
				),
				array(
					'name' => 'email',
					'value' => '$data->email',
					'filter' => true,
					'sortable' => false,
				),
				array(
					'name' => 'phone',
					'value' => '$data->phone',
					'filter' => true,
					'sortable' => false,
				),
				array(
					'name' => 'comment',
					'value' => '$data->comment',
					'filter' => true,
					'sortable' => false,
				),
				array(
					'name' => 'date_start',
					'value' => '$data->dateStartShort . " (". $data->getTimeInName().")"',
					'filter' => true,
					'sortable' => false,
					'htmlOptions' => array('style' => 'width:150px;'),
				),
				array(
					'name' => 'date_end',
					'value' => '$data->dateEndShort . " (". $data->getTimeOutName().")" ',
					'filter' => true,
					'sortable' => false,
					'htmlOptions' => array('style' => 'width:150px;'),
				),
				array(
					'header' => tt('Creation date', 'booking'),
					'value' => '$data->date_created',
					'type' => 'raw',
					'filter' => false,
					'sortable' => false,
					//'htmlOptions' => array('style' => 'width:130px;'),
				),
			),
		)
	);

Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.jeditable.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('editable_select_booking_table', "
		function ajaxSetBookingTableStatus(elem, id, id_elem, items){
			$('#editable_select-'+id_elem).editable('".Yii::app()->controller->createUrl("bookingtableactivate")."', {
				data   : items,
				type   : 'select',
				cancel : '".tc('Cancel')."',
				submit : '".tc('Ok')."',
				style  : 'inherit',
				submitdata : function() {
					return {id : id_elem};
				}
			});
		}
	",
	CClientScript::POS_BEGIN);

?>
