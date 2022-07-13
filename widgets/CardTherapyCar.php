<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardTherapyCar extends \yii\bootstrap4\Widget
{
  public $id;

  public $nomeLog;
  public $cognomeLog;
  public $nome;
  public $cognome;
  public $data_nascita;
  public $data_fine;
  public $sesso;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $this->data_nascita = DateHandler::getLiteralDate($this->data_nascita);
    if ($this->sesso==1) {
      $this->sesso = 'nato';
    }
    else if ($this->sesso==0) {
      $this->sesso = 'nata';
    }
    else if ($this->sesso==2) {
      $this->sesso = 'nat*';
    }
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    $infoRole = 'logopedista '.$this->nomeLog.' '.$this->cognomeLog;    
    $disabled = $this->data_fine==null ? '' : 'disabled';

    echo '<div class="card col-lg-4 col-md-4 col-sm-6">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted">Terapia #'.$this->id.'</h6>
        <h5 class="card-title">'.$this->nome.' '.$this->cognome.'</h5>
        <p class="card-text">
          '.$this->sesso.' il '.$this->data_nascita.', 
          '.$infoRole.'
        </p>
        <a href="/caregiver/therapy-details?idTerapia='.$this->id.'" '.$disabled.' class="btn btn-secondary" role="button">
          Dettagli terapia
        </a>
      </div>
    </div>';
  }

}
