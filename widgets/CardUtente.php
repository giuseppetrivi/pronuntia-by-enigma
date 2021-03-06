<?php

namespace app\widgets;

use app\views\custom_utility_class\DateHandler;
use Yii;
use yii\helpers\Html;

class CardUtente extends \yii\bootstrap4\Widget
{
  public $id;
  public $nome;
  public $cognome;
  public $eta;
  public $peso;
  public $sesso;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $this->eta = DateHandler::getAge($this->eta);
    $this->sesso = $this->formatSex($this->sesso);
  }


  /**
   * {@inheritdoc}
   */
  public function run() {
    echo '<div class="col-lg-3">

      <div class="card">
        <svg class="card-img-top" style="padding: 20px" xmlns="http://www.w3.org/2000/svg" width="8rem" height="8rem" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
          <path fill="cornflowerblue" d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
        </svg>

        <div class="card-body">
          <h5 class="card-title" style="text-align: center">' . $this->nome . ' ' . $this->cognome . '</h5>
        </div>

        <ul class="list-group list-group-flush" style="text-align: center; font-size: 1.1rem">
          <li class="list-group-item">
            <label style="font-size: 1rem; margin-bottom: 2px; font-weight: 600">Età :</label>
            ' . $this->eta . ' anni
          </li>
          <li class="list-group-item">
            <label style="font-size: 1rem; margin-bottom: 2px; font-weight: 600">Peso :</label>
            ' . $this->peso . ' kg
          </li>
          <li class="list-group-item">
            <label style="font-size: 1rem; margin-bottom: 2px; font-weight: 600">Sesso :</label>
            ' . $this->sesso . '
          </li>
        </ul>

        <div class="card-body"> ' .
          Html::beginForm(['caregiver/utente-form?type=modify'], 'post', [
              'class' => 'mb-4'
            ]
          )
          . Html::input('hidden', 'idUtente', $this->id)
          . Html::submitButton('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
          </svg>&nbsp; Modifica info', ['class' => 'btn btn-link'])
          . Html::endForm() . '
        </div>
      </div>

    </div>';
  }


  private function formatSex($sesso) {
    if ($sesso==1) {
      return 'Maschio';
    }
    else if ($sesso==0) {
      return 'Femmina';
    }
    else {
      return 'Non specificato';
    }
  }
}
