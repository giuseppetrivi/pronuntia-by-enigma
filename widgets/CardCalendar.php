<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardCalendar extends \yii\bootstrap4\Widget
{
  public $referDate;
  public $referDateLiteral;
  public $appointments;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $this->referDateLiteral = DateHandler::getLiteralDate($this->referDate);
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    $appointmentsList = '';
    foreach ($this->appointments as $value) {
      $explodedDataOra = explode(' ', $value['data_ora']);
      $data = $explodedDataOra[0];
      $ora = substr($explodedDataOra[1], 0, 5);

      if ($data==$this->referDate) {
        $appointmentsList .= '<li class="list-group-item"><b>'.$ora.'</b>  '
          .$value['nome'].' '.$value['cognome'];
        if ($value['info']!=null) {
          $appointmentsList .= '<br><i>' . $value['info'] . '</i>';
        }
        $appointmentsList .= '</li>';
      }
    }

    if ($appointmentsList=='') {
      $appointmentsList = '<li class="list-group-item">//</li>';
    }

    echo '<div class="card col-lg-3 col-md-3 col-sm-6">
      <div class="card-header">
        <b>'.$this->referDateLiteral.'</b>
        '. ( ($this->referDate==date('Y-m-d')) ? 
              '&nbsp;<span class="badge badge-primary">Oggi</span>' :
              '' ) .'
      </div>
      <ul class="list-group list-group-flush">
        '.$appointmentsList.'
      </ul>
    </div>';
  }


}
