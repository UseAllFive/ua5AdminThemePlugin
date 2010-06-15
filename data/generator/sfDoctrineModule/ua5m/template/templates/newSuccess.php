[?php use_helper('I18N', 'Date');
include_partial('media/assets');
slot("list_title");
New <?php echo sfInflector::humanize($this->getSingularName()) ?>
end_slot("list_title");
?]

[?php include_partial('form', array('form' => $form)) ?]
