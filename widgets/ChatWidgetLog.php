<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;
use Exception;

class ChatWidgetLog extends \yii\bootstrap4\Widget
{
  public $nomeCar;
  public $cognomeCar;

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
    $this->m_data_ora = DateHandler::getLiteralDate($this->m_data_ora);
    $this->r_data_ora = $this->r_data_ora!=null ? DateHandler::getLiteralDate($this->r_data_ora) : null;
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    $risposta = Html::beginForm(['logopedista/messages-rispondi'], 'post', [
        'class' => 'mb-2'
      ]
    )
    . Html::input('hidden', 'idMessaggio', $this->id)
    . Html::textarea('risposta', '', [
      'class' => 'form-control mb-2',
      'rows' => '3',
      'required' => 'true',
      'max' => '255'
    ])
    . Html::submitButton('Rispondi', ['class' => 'btn btn-light'])
    . Html::endForm();

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

    echo '<div class="col-lg-6 mb-2">
      <div class="card">
        <div class="card-header">
          Inviato da <b>'.$this->nomeCar.' '.$this->cognomeCar.'</b> il '.$this->m_data_ora.'
        </div>
        <div class="card-body">
          <h5 class="card-title">'.$this->titolo.'</h5>
          <p class="card-text">'.$this->m_contenuto.'</p>
          '.$risposta.'
        </div>
      </div>
    </div>';
  }

}
