<?php

namespace app\views\custom_utility_class;


/**
 * Class to handle the format of the date
 */
class DateHandler {

  public static function getLiteralDate($date) {
    $explodedParts = explode(' ', $date);

    $explodedDate = explode('-', $explodedParts[0]);
    $day = $explodedDate[2];
    $month = $explodedDate[1];
    $year = $explodedDate[0];
    switch ($month) {
      case '01': $month = 'Gennaio'; break;
      case '02': $month = 'Febbraio'; break;
      case '03': $month = 'Marzo'; break;
      case '04': $month = 'Aprile'; break;
      case '05': $month = 'Maggio'; break;
      case '06': $month = 'Giugno'; break;
      case '07': $month = 'Luglio'; break;
      case '08': $month = 'Agosto'; break;
      case '09': $month = 'Settembre'; break;
      case '10': $month = 'Ottobre'; break;
      case '11': $month = 'Novembre'; break;
      case '12': $month = 'Dicembre'; break;
      default: return $date; break;
    }
    $literalDate = $day . ' ' . $month . ' ' . $year;

    if (array_key_exists(1, $explodedParts)) {
      $explodedTime = explode(':', $explodedParts[1]);
      $hour = $explodedTime[0];
      $minutes = $explodedTime[1];
      return $literalDate . ' alle ' . $hour . ':' . $minutes;
    }

    return $literalDate;
  }

}

?>