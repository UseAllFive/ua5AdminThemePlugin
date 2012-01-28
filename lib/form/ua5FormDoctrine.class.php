<?php

/**
 * Project form base class.
 *
 * @package    ua5AdminThemePlugin
 * @subpackage form
 * @author     Matt Farmer <matt@useallfive.com>
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class ua5FormDoctrine extends sfFormDoctrine {

  protected
    $model_class = null;


  public function setup() {
  }


  /*
   * @param (string) Relation Alias
   * @param (string) New Form Label
   * @param (integer) New Form Count
   * @param (string) Name of new Form collection Class
   *
   */
  protected function _parseEmbedRelatedConfig($cfg) {

    $obj = $this->getObject();
    $class = get_class($obj);

    $rel_alias = $cfg[0];
    $rel_new_form_name = $cfg[1];

    if ( 3 <= count($cfg) ) {
      $rel_new_form_count = $cfg[2];
    } else {
      $rel_new_form_count = 1;
    }

    if ( 4 <= count($cfg) ) {
      $rel_collection_form_name = $cfg[3];
    } else {
      $rel_collection_form_name = sprintf(
        '%s%sCollectionForm',
        ucfirst(sfInflector::classify($class)),
        ucfirst(sfInflector::classify($rel_alias))
      );
    }
    return array($rel_alias, $rel_new_form_name, $rel_new_form_count, $rel_collection_form_name);
  }


  public function configure() {
    parent::configure();

    $this->configureVideoColumns();
    $this->configureImageColumns();

    $this->_embedRelated();
  }


  protected function _embedRelated() {

    if ( isset($this->embededRelations) ) {

      $obj = $this->getObject();
      $class = get_class($obj);

      foreach ( $this->embededRelations as $relation_cfg ) {

        list(
          $rel_alias,
          $rel_new_form_name,
          $rel_new_form_count,
          $rel_collection_form_name
        ) = $this->_parseEmbedRelatedConfig($relation_cfg);

        $this->embedRelation($rel_alias, null, array(), null, "<table class=\"embeded_form\">\n  %content%</table>");
        JSUtil::appendOnReady(sprintf("ua5_cms.deleteRelated('%s');", $rel_alias));
        $this->embedForm(
          $rel_new_form_name,
          new $rel_collection_form_name(null, array(
            sfInflector::tableize($class) => $obj,
            'size' => $rel_new_form_count,
          )),
          "<table class=\"embeded_form new\">\n  %content%</table>"
        );
      }
    }
  }

  public function save($con = null) {
    $ret = parent::save($con);

    $this->saveVideoColumns();
    $this->saveImageColumns();

    return $ret;
  }


  public function saveEmbeddedForms($con = null, $forms = null) {

    if ( null === $forms && isset($this->embededRelations) ) {

      $forms = $this->embeddedForms;
      foreach ( $this->embededRelations as $relation_cfg ) {

        list(
          $rel_alias,
          $rel_new_form_name,
          $rel_new_form_count,
          $rel_collection_form_name
        ) = $this->_parseEmbedRelatedConfig($relation_cfg);

        $obj_vals = $this->getValue($rel_new_form_name);
        foreach ($forms[$rel_new_form_name] as $name => $form) {
          if ( !isset($obj_vals[$name]) || "" == $obj_vals[$name] ) {
            unset($forms[$rel_new_form_name][$name]);
          }
        }
      }
    }

    return parent::saveEmbeddedForms($con, $forms);
  }


  protected function getModelClass() {
    if ( is_null($this->model_class) ) {
      $this->model_class = sfInflector::tableize(get_class($this->getObject()));
    }
    return $this->model_class;
  }


  protected function configureImageColumns() {
    if ( isset($this->image_columns) ) {
      foreach ( $this->image_columns as $col ) {
        $obj = $this->getObject();
        $required = $this->getValidator($col)->getOption('required');
        $view_link = !$obj[$col]? '' :
          sprintf(
            '<a href="%s" class="%s" data-thumb-url="%s" target="_blank">%s</a>',
            $obj->ThumbnailUrl($col, 'original'),
            'btn view image',
            $obj->ThumbnailUrl($col, 'thumb'),
            'View'
          );
        $this->setWidget($col, new sfWidgetFormInputFileEditable(array(
          'edit_mode' => !$this->isNew(),
          'is_image' => true,
          'with_delete' => $obj[$col] && !$required,
          'file_src' => $obj->ThumbnailUrl($col, 'thumb'),
          'template' => <<<EOT
<div class="media clearfix">
  <ul>
    <li>%input%</li>
    <li>$view_link</li>
    <li>%delete% %delete_label%</li>
  </ul>
</div>
EOT
        )));
        $this->setValidator($col, new sfValidatorFile(array(
          'required' => $required && $this->isNew(),
          'mime_types' => 'web_images',
          'path' => sfConfig::get('sf_upload_dir')
        )));
        if ( !$required ) {
          //-- Add validator for deletable images
          $this->setValidator($col.'_delete', new sfValidatorBoolean());
        }
      }
    }
  }


  protected function saveImageColumns() {
    if ( isset($this->image_columns) ) {
      foreach ( $this->image_columns as $col ) {
        if (
          ($file = $this->getValue($col))
        ) {
          $filename = substr($file->getSavedName(), 1+strlen($file->getPath()));
          $this->getWidget($col)->setOption(
            'file_src',
            sprintf(
              '/uploads/%s/%s/%s',
              $this->getModelClass(),
              $col,
              $filename
            )
          );
        }
      }
    }
  }


  protected function configureVideoColumns() {
    if ( isset($this->video_columns) ) {
      foreach ( $this->video_columns as $col ) {
        $obj = $this->getObject();
        $required = $this->getValidator($col)->getOption('required');
        $view_link = !$obj[$col]? '' :
          sprintf(
            '<a href="%s/%s" class="%s" target="_blank">%s</a>',
            $this->getObject()->getVideoEncodablePath($col, true),
            $this->getObject()->get($col),
            'btn view video',
            'View'
          );
        $this->setWidget($col, new sfWidgetFormInputFileEditable(array(
          'label' => ucfirst(sfInflector::humanize($col)),
          'edit_mode' => !$this->isNew(),
          'is_image' => false,
          'with_delete' => $obj[$col] && !$required,
          'file_src' =>  sprintf(
            '<a href="%s/%s" target="_blank"></a>',
            $this->getObject()->getVideoEncodablePath($col, true),
            $this->getObject()->get($col)
          ),
          'template' => <<<EOT
<div class="media clearfix">
  <ul>
    <li>%input%</li>
    <li>$view_link</li>
    <li>%delete% %delete_label%</li>
  </ul>
</div>
EOT
        )));
        $this->setValidator($col, new sfValidatorFile(array(
          'required' => $this->isNew(),
          'mime_types' => array('video/quicktime','video/x-flv', 'application/octet-stream', 'video/mp4'),
          'path' =>  $this->getObject()->getVideoEncodablePath($col, false)
        )));
      }
    }
  }


  protected function saveVideoColumns() {
    if ( isset($this->video_columns) ) {
      foreach ( $this->video_columns as $col ) {
        if (
          isset($this->widgetSchema[$col]) &&
          ($video = $this->getValue($col))
        ) {
          $filename = substr($video->getSavedName(), 1+strlen($video->getPath()));
          $this->getWidget($col)->setOption(
            'file_src',
            sprintf(
              '%s/%s',
              $this->getOjbect()->getVideoEncodablePath($col, true),
              $filename
            )
          );
        }
      }
    }
  }


}
