<?php

return array(

    'does_not_exist' => 'Status-etiketten finnes ikke.',
    'assoc_assets'	 => 'Denne status-etiketten er for øyeblikket i bruk på minst en eiendel, og kan ikke slettes. Vennligst endre dine eiendeler til å ikke bruke denne statusen, og prøv igjen. ',


    'create' => array(
        'error'   => 'Statusmerket ble ikke opprettet. Prøv igjen.',
        'success' => 'Statusmerket ble opprettet.'
    ),

    'update' => array(
        'error'   => 'Statusmerket ble ikke oppdatert. Prøv igjen',
        'success' => 'Vellykket oppdatering av statusmerke.'
    ),

    'delete' => array(
        'confirm'   => 'Er du sikker på at du vil slette dette statusmerket?',
        'error'   => 'Det oppstod et problem under sletting av statusmerket. Prøv igjen.',
        'success' => 'Vellykket sletting av statusmerke.'
    ),

    'help' => array(
        'undeployable'   => 'Disse eiendelene kan ikke tilordnes noen.',
        'deployable'   => 'Disse eiendelene kan sjekkes ut. Når de er tildelt, antar de en metastatus på <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Disse eiendelene kan ikke sjekkes ut, og vises bare i arkivert visning. Dette er nyttig for å beholde informasjon om eiendeler for budsjettering / historiske formål, men å holde dem ut av den daglige aktivitetslisten.',
        'pending'   => 'Disse eiendelene kan ikke tildeles til noen, ofte brukt til gjenstander som er ute for reparasjon, men forventes å komme tilbake til omløp.',
    ),

);
