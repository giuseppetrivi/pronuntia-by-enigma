<?php

namespace app\widgets;

use Yii;

class AccountInformation extends \yii\bootstrap4\Widget
{
  public $field_name;
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
    $content = $this->content===null ? '<i>(vuoto)</i>' : $this->content;
    echo '<div class="mb-3">
      <p style="margin-bottom: 1px">' . $this->field_name . '</p>
      <h4>' . $content . '</h4>
    </div>';
  }
}
