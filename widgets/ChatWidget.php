<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;
use Exception;

class ChatWidget extends \yii\bootstrap4\Widget
{
  public $attore;

  public $nomeLog;
  public $cognomeLog;

  public $id;
  public $titolo;
  public $m_contenuto;
  public $m_data_ora;
  public $r_contenuto;
  public $r_data_ora;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    if ($this->attore!='caregiver' && $this->attore!='logopedista') {
      throw new Exception("Errore nell'attore del widget");
    }
    $this->m_data_ora = DateHandler::getLiteralDate($this->m_data_ora);
    $this->r_data_ora = $this->r_data_ora!=null ? DateHandler::getLiteralDate($this->r_data_ora) : null;
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    if ($this->attore=='caregiver') {
      echo $this->chatCaregiver();
    }
    else if ($this->attore=='logopedista') {
      echo $this->chatLogopedista();
    }
  }


  private function chatCaregiver() {
    $risposta = '<i>(ancora nessuna risposta)</i>';
    if ($this->r_data_ora!=null) {
      $risposta = '<div class="card">
        <div class="card-header" style="font-size: 12px; padding: 0.5rem 1rem;">
          Risposto il '.$this->r_data_ora.'
        </div>
        <div class="card-body">
          <p class="card-text">'.$this->r_contenuto.'</p>
        </div>
      </div>';
    }

    return '<div class="col-lg-6 mb-2">
      <div class="card">
        <div class="card-header">
          Inviato a <b>'.$this->nomeLog.' '.$this->cognomeLog.'</b> il '.$this->m_data_ora.'
        </div>
        <div class="card-body">
          <h5 class="card-title">'.$this->titolo.'</h5>
          <p class="card-text">'.$this->m_contenuto.'</p>
          '.$risposta.'
        </div>
      </div>
    </div>';
  }

  private function chatLogopedista() {
    echo 'ciao';
  }

}
