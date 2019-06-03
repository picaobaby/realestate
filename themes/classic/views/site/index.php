<?php
$entriesIndex = Entries::getLastNews();
if ($entriesIndex) : ?>
	<div class="clear"></div>
	<div class="last-entries-index">
		<p class="title"><?php echo tt('News', 'entries');?></p>
		<?php foreach($entriesIndex as $entries) : ?>
			<div class="last-entries-item">
				<div class="last-entries-date">
					<p class="ns-label">
						<?php echo $entries->dateCreatedLong;?>
					</p>
				</div>
				<div class="last-entries-title">
					<?php echo CHtml::link(truncateText($entries->getStrByLang('title'), 8), $entries->getUrl());?>
				</div>
			</div>
		<?php endforeach;?>
	</div>
	<div class="clear"></div>
<?php endif;?>

<?php
if($page){
	if (isset($page->page)) {

		if ($page->page->widget && $page->page->widget_position == InfoPages::POSITION_TOP){
			$this->renderPartial('_index_view_widget', array('widget' => $page->page->widget, 'page' => $page->page, 'widgetTitles' => $page->page->widget_titles));
			echo '<div class="clear"></div><br />';
		}

		if($page->page->body){
			echo HSite::parseText($page->page->body);
		}

		if ($page->page->widget && $page->page->widget_position == InfoPages::POSITION_BOTTOM){
			$this->renderPartial('_index_view_widget', array('widget' => $page->page->widget, 'page' => $page->page, 'widgetTitles' => $page->page->widget_titles));
		}
	}
}