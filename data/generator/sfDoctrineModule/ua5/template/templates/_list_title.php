[?php 
if ( $sf_request->hasAttribute('list.title') ) {
  echo $sf_request->getAttribute('list.title');
} else {
  echo <?php echo $this->getI18NString('list.title') ?>;
}
?]
