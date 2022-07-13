<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardTherapyLog extends \yii\bootstrap4\Widget
{
  public $id;

  public $nomeCar;
  public $cognomeCar;
  public $nome;
  public $cognome;
  public $data_nascita;
  public $data_fine;
  public $sesso;
  public $notify;


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
    $infoRole = 'caregiver '.$this->nomeCar.' '.$this->cognomeCar;

    $endtherapy_button = '<a href="/logopedista/end-therapy?idTerapia='.$this->id.'" class="btn btn-danger mb-2" role="button">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3z"/>
      </svg>&nbsp;
      Concludi terapia
    </a>';
    if ($this->data_fine!=null) {
      $endtherapy_button = '<a href="/logopedista/end-therapy?idTerapia='.$this->id.'" class="btn btn-danger disabled" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stop-circle" viewBox="0 0 16 16">
          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
          <path d="M5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3z"/>
        </svg>&nbsp;
        Terapia conclusa
      </a>';
    }

    $notify_button = '<a href="/logopedista/notify-therapy?idTerapia='.$this->id.'&notifiche='.$this->notify.'" class="btn btn-secondary mb-2" role="button">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
      </svg>&nbsp;
      Notifiche disattive, attivale
    </a>';
    if ($this->notify==1) {
      $notify_button = '<a href="/logopedista/notify-therapy?idTerapia='.$this->id.'&notifiche='.$this->notify.'" class="btn btn-secondary mb-2" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-slash-fill" viewBox="0 0 16 16">
          <path d="M5.164 14H15c-1.5-1-2-5.902-2-7 0-.264-.02-.523-.06-.776L5.164 14zm6.288-10.617A4.988 4.988 0 0 0 8.995 2.1a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 7c0 .898-.335 4.342-1.278 6.113l9.73-9.73zM10 15a2 2 0 1 1-4 0h4zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75L.625 15.625z"/>
        </svg>&nbsp;
        Notifiche attive, disattivale
      </a>';
    }

    echo '<div class="card col-lg-4 col-md-4 col-sm-6">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted">Terapia #'.$this->id.'</h6>
        <h5 class="card-title">'.$this->nome.' '.$this->cognome.'</h5>
        <p class="card-text">
          '.$this->sesso.' il '.$this->data_nascita.', 
          '.$infoRole.'
        </p>
        <a href="/logopedista/therapy-details?idTerapia='.$this->id.'" class="btn btn-info mb-2" role="button">
          Dettagli terapia
        </a>
        <br>
        '.$notify_button.'
        <br>
        '.$endtherapy_button.'
      </div>
    </div>';
  }

}
