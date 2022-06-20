<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardLogopedista extends \yii\bootstrap4\Widget
{
  public $id;
  public $nome;
  public $cognome;
  public $email;
  public $bio;
  public $salvato;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $this->salvato = $this->salvato ? 1 : 0;
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    $textButton = $this->salvato ? 'Rimuovi dai salvati' : 'Salva';
    $classButton = $this->salvato ? 'remove-log' : 'add-log';
    echo '<div class="col-lg-4">
      <div class="card">
        <svg class="card-img-top" style="padding: 25px;" xmlns="http://www.w3.org/2000/svg" width="8rem" height="8rem" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
          <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/>
        </svg>
        <div class="card-body">
          <h5 class="card-title" style="text-align: center; margin-bottom: 20px">' . $this->nome . ' ' . $this->cognome . '</h5>'
          . Html::beginForm(['caregiver/save-logopedista'], 'post', [
              'class' => 'mb-2'
            ]
          )
          . Html::input('hidden', 'idLogopedista', $this->id)
          . Html::input('hidden', 'saved', $this->salvato)
          . Html::submitButton($textButton, [
            'class' => 'btn '.$classButton.' col-lg-12 col-md-12 col-sm-12'
          ])
          . Html::endForm() . '
          <button class="btn btn-link col-lg-12 col-md-12 col-sm-12" data-toggle="collapse" data-target="#'.$this->formatEmailToId().'" aria-expanded="false" aria-controls="collapseExample">Altre info utili</button>
          <div class="collapse mt-2" id="' . $this->formatEmailToId() . '">
            <div class="card card-body">
              <h6>Indirizzo email</h6>
              <p>' . $this->email . '</p>
              <h6>Bio</h6>
              <p>' . ($this->bio ? $this->bio : '<i>(vuoto)</i>') . '</p>
            </div>
          </div>
        </div>
      </div>
    </div>';
  }


  private function formatEmailToId() {
    $id = str_replace('@', '', $this->email);
    $id = str_replace('.', '-', $id);
    return $id;
  }
}
