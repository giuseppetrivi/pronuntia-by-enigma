<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardAppointment extends \yii\bootstrap4\Widget
{
  public $id;
  public $data_ora;
  public $nomeLog;
  public $cognomeLog;
  public $info;

  private $valid = true;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $timestampToday = strtotime(date('Y-m-d'));
    $timestampDataora = strtotime($this->data_ora);
    if ($timestampToday >= $timestampDataora) {
      $this->valid = false;
    }
    $this->data_ora = DateHandler::getLiteralDate($this->data_ora);
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    echo '<div class="col-lg-3 mb-2">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">'.$this->data_ora.'</h5>
          <h6 class="card-subtitle mb-2 text-muted">
            con '.$this->nomeLog.' '.$this->cognomeLog.'
          </h6>
          <p class="card-text">'.$this->info.'</p>
          '. ($this->valid ? 
            Html::beginForm(['caregiver/appointment-cancel'], 'post', [
                'class' => 'mb-4'
              ]
            )
            . Html::input('hidden', 'idAppuntamento', $this->id)
            . Html::submitButton('Annulla prenotazione', ['class' => 'btn btn-danger'])
            . Html::endForm()
          : '')  . '
        </div>
      </div>
    </div>';
  }


}
