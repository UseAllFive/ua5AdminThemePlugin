<ul id="hd-nav">
<?php if(sfContext::getInstance()->has("tabs")){
	if(sfContext::getInstance()->has("active_tab"))
	{
		$active = sfContext::getInstance()->get("active_tab");
	}
  foreach(sfContext::getInstance()->get("tabs") as $record_key => $tabs_record){
  	if(!isset($tabs_record['credits']) || $sf_user->hasSfPermissions($tabs_record['credits'])):
?>
  <li class="tab"><a <?php if ($active == $record_key) {echo "class='active'";}?> href="<?php echo url_for($tabs_record['url'])?>"><?php echo $tabs_record['text']?></a></li>
<?php 
endif;
  }
}?>
</ul> 