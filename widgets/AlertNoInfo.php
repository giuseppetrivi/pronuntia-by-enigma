<?php

namespace app\widgets;

use Yii;

class AlertNoInfo extends \yii\bootstrap4\Widget
{
  public $content;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 alert alert-secondary" role="alert">
      '.$this->content.'
    </div>';
  }


}
