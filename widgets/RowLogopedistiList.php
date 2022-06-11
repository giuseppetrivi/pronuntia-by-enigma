<?php

namespace app\widgets;

use Yii;
use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;

class RowLogopedistiList extends \yii\bootstrap4\Widget
{
  public $id;
  public $nome;
  public $cognome;
  public $data_registrazione;


  /**
   * {@inheritdoc}
   */
  public function init() {
    parent::init();
    $this->data_registrazione = DateHandler::getLiteralDate($this->data_registrazione);  
  }


  /**
   * {@inheritdoc}
   */
  //inserire tutta la tabella
  public function run() {
    echo '<tr>
    <th scope="row">' . $this->cognome . '</th>
    <td>' . $this->nome . '</td>
    <td>' . $this->data_registrazione . '</td>
    <td>'
        . Html::beginForm(['moderatore/logopedista-info?id='.$this->id], 'post', ['class' => 'form-inline'])
        . Html::submitButton(
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
            </svg>&nbsp;&nbsp;Mostra info',
            ['class' => 'btn btn-primary']
        )
        . Html::endForm() . '
    </td>
    </tr>';
  }
}
