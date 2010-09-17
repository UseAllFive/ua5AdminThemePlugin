<ul id="hd-actions">
<?php if(sfContext::getInstance()->has("top_menu")){
  foreach(sfContext::getInstance()->get("top_menu") as $record_key => $tabs_record){
?>
  <li class="tab"><a href="<?php echo url_for($tabs_record['url'])?>"><?php echo $tabs_record['text']?></a></li>
<?php 
  }
}?>
  <li class="help"><a href="<?php echo url_for(sfConfig::get('app_ua5_theme_help_index','@homepage'))?>">Help</a></li>
</ul> 