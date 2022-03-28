<?php

return array(

    'accepted'                  => '您已接受這項資產。',
    'declined'                  => '您已拒絕這項資產。',
    'bulk_manager_warn'	        => '您的使用者已成功更新，但主管條目未保存，因為您選擇的主管也在要編輯的使用者列表中，使用者不能是自己的主管。 請再次選擇您的使用者並排除主管。',
    'user_exists'               => '使用者已存在！',
    'user_not_found'            => '使用者 [:id] 不存在',
    'user_login_required'       => '登入欄位是必需的',
    'user_password_required'    => '密碼欄位是必需的',
    'insufficient_permissions'  => '權限不足',
    'user_deleted_warning'      => '此使用者已被刪除。您必須先還原此使用者才能進行編輯或分配新的資產。',
    'ldap_not_configured'        => 'LDAP 整合尚未設定',


    'success' => array(
        'create'    => '新增使用者成功。',
        'update'    => '更新使用者成功。',
        'update_bulk'    => '使用者更新成功 ！',
        'delete'    => '刪除使用者成功。',
        'ban'       => '禁止使用者成功。',
        'unban'     => '解禁使用者成功。',
        'suspend'   => '停用使用者成功。',
        'unsuspend' => '解除停用使用者成功。',
        'restored'  => '恢復使用者成功。',
        'import'    => '匯入使用者成功。',
    ),

    'error' => array(
        'create' => '新增使用者失敗，請重試。',
        'update' => '更新使用者失敗，請重試。',
        'delete' => '刪除使用者失敗，請重試。',
        'delete_has_assets' => '此使用者已分配物件，無法刪除。',
        'unsuspend' => '解除停用使用者失敗，請重試。',
        'import'    => '匯入使用者失敗，請重試。',
        'asset_already_accepted' => '資產已被接受',
        'accept_or_decline' => '您必須選擇接受或拒絕該資產。',
        'incorrect_user_accepted' => '您正嘗試接受的資產未分配給您',
        'ldap_could_not_connect' => '無法連接到 LDAP 伺服器，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_bind' => '無法綁定 LDAP 伺服器，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_search' => '查詢 LDAP 伺服器失敗，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'ldap_could_not_get_entries' => ' LDAP 伺服器取得資訊條目失敗，請檢查 LDAP 設定文件中的相關設定。<br>LDAP 伺服器錯誤訊息：',
        'password_ldap' => '此帳戶的密碼由 LDAP/AD 管理。若要更改您的密碼，請聯繫您的 IT 部門。 ',
    ),

    'deletefile' => array(
        'error'   => '刪除檔案失敗，請重試',
        'success' => '刪除檔案成功。',
    ),

    'upload' => array(
        'error'   => '上傳檔案失敗，請重試',
        'success' => '上傳檔案成功。',
        'nofiles' => '尚未選擇要上傳的檔案',
        'invalidfiles' => '一個或多個檔案太大或屬於不被允許的檔案類型。允許上傳的檔案類型：png, gif, jpg, doc, docx, pdf, txt。',
    ),

);
