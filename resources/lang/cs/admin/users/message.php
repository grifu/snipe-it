<?php

return array(

    'accepted'                  => 'Úspěšně jste přijali tento majetek.',
    'declined'                  => 'Úspěšně jste odmítli tento majetek.',
    'bulk_manager_warn'	        => 'Uživatelé byli úspěšně aktualizováni, položka správce však nebyla uložena, protože správce, který jste si vybrali, byl také v seznamu uživatelů, který má být upraven, a uživatelé nemusí být jejich vlastní správce. Zvolte své uživatele znovu, kromě správce.',
    'user_exists'               => 'Uživatel již existuje!',
    'user_not_found'            => 'Uživatel [:id] neexistuje.',
    'user_login_required'       => 'Přihlašovací pole je povinné',
    'user_password_required'    => 'Je vyžadováno heslo.',
    'insufficient_permissions'  => 'Nedostatečná oprávnění.',
    'user_deleted_warning'      => 'Tento uživatel byl smazán. Budete muset uživatele obnovit, aby jste ho mohli upravil nebo přidělil nové majetky.',
    'ldap_not_configured'        => 'Integrace LDAP nebyla pro tuto instalaci nakonfigurována.',


    'success' => array(
        'create'    => 'Uživatel byl úspěšně vytvořen.',
        'update'    => 'Uživatel byl úspěšně aktualizován.',
        'update_bulk'    => 'Uživatelé byli úspěšně aktualizováni!',
        'delete'    => 'Uživatel byl úspěšně smazán.',
        'ban'       => 'Uživatel byl úspěšně zakázán.',
        'unban'     => 'Uživatel byl úspěšně povolen.',
        'suspend'   => 'Uživatel byl úspěšně pozastaven.',
        'unsuspend' => 'Uživatel byl úspěšně zrušen.',
        'restored'  => 'Uživatel byl úspěšně obnoven.',
        'import'    => 'Uživatelé úspěšně naimportování.',
    ),

    'error' => array(
        'create' => 'Vyskytl se problém při vytvářením uživatele. Zkuste to znovu.',
        'update' => 'Vyskytl se problém při aktualizování uživatele. Zkuste to znovu.',
        'delete' => 'Vyskytl se problém při mazání uživatele. Zkuste to znovu.',
        'delete_has_assets' => 'Tento uživatel má položky přiřazené a nelze je smazat.',
        'unsuspend' => 'Vyskytl se problém při rušení uživatele. Zkuste to znovu.',
        'import'    => 'Vyskytl se problém při importu uživatelů. Zkuste to znovu.',
        'asset_already_accepted' => 'Tento majetek již byl odsouhlasen.',
        'accept_or_decline' => 'Musíte přijmout nebo odmítnout tento majetek.',
        'incorrect_user_accepted' => 'Majetek, který jste se pokoušeli přijmout, nebyl vydán pro vás.',
        'ldap_could_not_connect' => 'Nelze se připojit k serveru LDAP. Zkontrolujte prosím konfiguraci serveru LDAP v konfiguračním souboru LDAP. <br>Chyba serveru LDAP:',
        'ldap_could_not_bind' => 'Nelze svázat server LDAP. Zkontrolujte prosím konfiguraci serveru LDAP v konfiguračním souboru LDAP. <br>Chyba serveru LDAP: ',
        'ldap_could_not_search' => 'Nelze vyhledat server LDAP. Zkontrolujte prosím konfiguraci serveru LDAP v konfiguračním souboru LDAP. <br>Chyba serveru LDAP:',
        'ldap_could_not_get_entries' => 'Nelze získat záznamy ze serveru LDAP. Zkontrolujte prosím konfiguraci serveru LDAP v konfiguračním souboru LDAP. <br>Chyba serveru LDAP:',
        'password_ldap' => 'Heslo pro tento účet je spravováno serverem LDAP / Active Directory. Obraťte se na oddělení IT a změňte heslo.',
    ),

    'deletefile' => array(
        'error'   => 'Soubor se nepodařilo smazat. Prosím zkuste to znovu.',
        'success' => 'Soubor byl úspěšně smazán.',
    ),

    'upload' => array(
        'error'   => 'Soubor(y) se nepodařilo nahrát. Prosím zkuste to znovu.',
        'success' => 'Soubor(y) byly v pořádku nahrány.',
        'nofiles' => 'Nevybrali jste žádné soubory pro nahrávání',
        'invalidfiles' => 'Jeden nebo více označených souborů je příliš velkých nebo nejsou podporované. Povolenými příponami jsou png, gif, jpg, doc, docx, pdf a txt.',
    ),

);
