<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\RowLogopedistiList;

$this->title = 'Lista di logopedisti da confermare';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderator-logopedisti-list">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <!-- Tabella lista di logopedisti -->
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">Cognome</th>
        <th scope="col">Nome</th>
        <th scope="col">Data di registrazione</th>
        <th scope="col">Azioni</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($logopedisti_list as $value) {
                echo RowLogopedistiList::widget([
                    'id' => $value['id'],
                    'cognome' => $value['cognome'],
                    'nome' => $value['nome'],
                    'data_registrazione' => $value['data_registrazione']
                ]);
            }
        ?>
    </tbody>
    </table>
</div>


