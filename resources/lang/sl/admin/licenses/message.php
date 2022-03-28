<?php

return array(

    'does_not_exist' => 'Licenca ne obstaja.',
    'user_does_not_exist' => 'Uporabnik ne obstaja.',
    'asset_does_not_exist' 	=> 'Sredstev, katero poskušate povezati s to licenco, ne obstaja.',
    'owner_doesnt_match_asset' => 'Sredstev, ki ga poskušate povezati s to licenco, je v lasti nekoga drugega, in ne v lasti uporabnika ki je izbran v spustnem seznamu.',
    'assoc_users'	 => 'Ta licenca je trenutno izdana uporabniku in je ni mogoče izbrisati. Najprej preverite licenco in poskusite znova izbrisati. ',
    'select_asset_or_person' => 'Izbrati morate sredstvo ali uporabnika, vendar ne obojega.',


    'create' => array(
        'error'   => 'Licenca ni bila ustvarjena, poskusite znova.',
        'success' => 'Licenca je bila ustvarjena uspešno.'
    ),

    'deletefile' => array(
        'error'   => 'Datoteka ni izbrisana. Prosim poskusite ponovno.',
        'success' => 'Datoteka je uspešno izbrisana.',
    ),

    'upload' => array(
        'error'   => 'Datoteka(e) niso naložene. Prosim poskusite ponovno.',
        'success' => 'Datoteka(e) so bile uspešno naložene.',
        'nofiles' => 'Niste izbrali nobenih datotek za nalaganje, ali je datoteka ki jo poskušate naložiti prevelika',
        'invalidfiles' => 'Ena ali več vaših datotek je prevelika ali pa je tip datoteke, ki ni dovoljen. Dovoljeni tipi datotek so png, gif, jpg, jpeg, doc, docx, pdf, txt, zip, rar, rtf, xml in lic.',
    ),

    'update' => array(
        'error'   => 'Licenca ni bila posodobljena, poskusite znova',
        'success' => 'Licenca je bila posodobljena uspešno.'
    ),

    'delete' => array(
        'confirm'   => 'Ali ste prepričani, da želite izbrisati to licenco?',
        'error'   => 'Prišlo je do težave z brisanjem licence. Prosim poskusite ponovno.',
        'success' => 'Licenca je bila uspešno izbrisana.'
    ),

    'checkout' => array(
        'error'   => 'Prišlo je do težave pri izdji licence. Prosim poskusite ponovno.',
        'success' => 'Licenca je uspešno izdana'
    ),

    'checkin' => array(
        'error'   => 'Prišlo je do težave pri prevzemu licence. Prosim poskusite ponovno.',
        'success' => 'Licenca je uspešno prevzeta'
    ),

);
