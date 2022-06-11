<?php

namespace app\widgets;

use Yii;

class ListGroupLogopedistaInfo extends \yii\bootstrap4\Widget
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
    echo '<div class="col-lg-12">
      <a class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
        <div class="d-flex gap-2 w-100 justify-content-between">
          <div>
            <h6 class="mb-0">' . $this->field_name . '</h6>
            <p class="mb-0 opacity-75">' . $this->content . '</p>
          </div>
        </div>
      </a>
    </div>';
  }
}
