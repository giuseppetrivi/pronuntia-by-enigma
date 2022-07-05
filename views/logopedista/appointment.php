<?php

use yii\bootstrap4\Html;
use app\views\custom_utility_class\DateHandler;
use app\widgets\AlertNoInfo;
use app\widgets\CardCalendar;

$this->title = 'Appuntamenti';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="logopedista-appointments">

  <h1><?= Html::encode($this->title) ?></h1>

  <br>

  <div class="row" style="margin: 0;">

    <?php

      if (count($appuntamenti)==0) {
        echo AlertNoInfo::widget([
          'content' => 'Nessun appuntamento recente (passato e futuro)'
        ]);
      }
      else {
        echo CardCalendar::widget([
          'referDate' => $dates['prev_day'],
          'appointments' => $appuntamenti
        ]);

        echo CardCalendar::widget([
          'referDate' => $dates['today'],
          'appointments' => $appuntamenti
        ]);

        echo CardCalendar::widget([
          'referDate' => $dates['next_day'],
          'appointments' => $appuntamenti
        ]);

        echo CardCalendar::widget([
          'referDate' => $dates['next2_day'],
          'appointments' => $appuntamenti
        ]);
      }

    ?>

  </div>
    

</div>