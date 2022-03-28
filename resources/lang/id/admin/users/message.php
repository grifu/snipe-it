<?php

return array(

    'accepted'                  => 'Anda sukses menerima aset ini.',
    'declined'                  => 'Anda sukses menolak aset ini.',
    'bulk_manager_warn'	        => 'Pengguna Anda telah berhasil diperbarui, namun entri pengelola Anda tidak disimpan karena manajer yang Anda pilih juga ada dalam daftar pengguna untuk diedit, dan pengguna mungkin bukan manajer mereka sendiri. Silakan pilih pengguna Anda lagi, tidak termasuk manajernya.',
    'user_exists'               => 'Pengguna sudah ada!',
    'user_not_found'            => 'Pengguna [:id] tidak terdaftar.',
    'user_login_required'       => 'Kolom login wajib di-isi',
    'user_password_required'    => 'Kata sandi wajib di-isi.',
    'insufficient_permissions'  => 'Tidak ada hak akses.',
    'user_deleted_warning'      => 'Pengguna ini telah di hapus. Anda harus kembalikan dahulu pengguna ini jika ingin menyunting atau di berikan hak kelola aset.',
    'ldap_not_configured'        => 'Integrasi LDAP belum dikonfigurasi untuk instalasi ini.',


    'success' => array(
        'create'    => 'Pengguna sukses di buat.',
        'update'    => 'Pengguna sukses di perbarui.',
        'update_bulk'    => 'Pengguna berhasil diperbarui!',
        'delete'    => 'Pengguna sukses di hapus.',
        'ban'       => 'Pengguna sukses di blokir.',
        'unban'     => 'Pengguna sukses tidak di blokir.',
        'suspend'   => 'Pengguna sukses di tangguhkan.',
        'unsuspend' => 'Pengguna sukses tidak di tangguhkan.',
        'restored'  => 'Pengguna sukses di kembalikan.',
        'import'    => 'Sukses mengimpor pengguna.',
    ),

    'error' => array(
        'create' => 'Terdapat kesalahan ketika membuat pengguna. Silahkan coba kembali.',
        'update' => 'Terdapat masalah ketika memperbarui pengguna. Silahkan coba kembali.',
        'delete' => 'Terdapat masalah ketika menghapus pengguna. Silahkan coba kembali.',
        'delete_has_assets' => 'Pengguna ini memiliki item yang ditugaskan dan tidak dapat dihapus.',
        'unsuspend' => 'Terdapat masalah ketika menangguhkan pengguna. Silahkan coba kembali.',
        'import'    => 'Terdapat masalah ketika mengimpor pengguna. Silahkan coba kembali.',
        'asset_already_accepted' => 'Aset ini telah di terima.',
        'accept_or_decline' => 'Anda harus menolak atau menerima aset ini.',
        'incorrect_user_accepted' => 'Aset yang akan di berikan ke anda, belum di setujui.',
        'ldap_could_not_connect' => 'Gagal koneksi ke server LDAP. Silahkan periksa konfigurasi server LDAP di berkas config. <br>Eror dari server LDAP:',
        'ldap_could_not_bind' => 'Server LDAP gagal mengikat. Silahkan cek kembali konfigurasi server LDAP di berkas config. <br>Eror dari server LDAP: ',
        'ldap_could_not_search' => 'Gagal mencari server LDAP. Silahkan cek konfigurasi server LDAP di berkas config LDAP. <br>Eror dari server LDAP:',
        'ldap_could_not_get_entries' => 'Gagal menerima catatan dari server LDAP. Silahkan cek konfigurasi server LDAP di berkas config LDAP. <br>Eror dari server LDAP:',
        'password_ldap' => 'Kata sandi untuk akun ini dikelola oleh LDAP / Active Directory. Silakan menghubungi departemen TI Anda untuk mengganti kata sandi Anda.',
    ),

    'deletefile' => array(
        'error'   => 'Berkas belum terhapus. Silahkan coba kembali.',
        'success' => 'Berkas sukses di hapus.',
    ),

    'upload' => array(
        'error'   => 'Berkas belum terunggah. Silakan coba kembali.',
        'success' => 'Berkas sukses terunggah.',
        'nofiles' => 'Anda belum memilih berkas untuk di unggah',
        'invalidfiles' => 'Satu atau lebih dari file Anda terlalu besar atau jenis berkas yang tidak diperbolehkan. Tipe file diizinkan adalah png, gif, jpg, doc, docx, pdf, dan txt.',
    ),

);
