<?php

return array(

    'does_not_exist' => 'O fornecedor não existe.',


    'create' => array(
        'error'   => 'O fornecedor não foi criado, tente novamente.',
        'success' => 'Fornecedor criado com sucesso.'
    ),

    'update' => array(
        'error'   => 'O fornecedor não foi atualizado, tente novamente',
        'success' => 'Fornecedor atualizado com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem certeza de que deseja excluir este fornecedor?',
        'error'   => 'Houve um problema ao excluir o fornecedor. Tente novamente.',
        'success' => 'O fornecedor foi excluído com sucesso.',
        'assoc_assets'	 => 'Este fornecedor está no momento associado com :asset_count asset(s) e não pode ser excluído. Atualize seus modelos para não referenciarem mais este fornecedor e tente novamente. ',
        'assoc_licenses'	 => 'Este fornecedor está no momento associado com :asset_count asset(s) e não pode ser excluído. Atualize seus modelos para não referenciarem mais este fornecedor e tente novamente. ',
        'assoc_maintenances'	 => 'Este fornecedor está no momento associado com :asset_maintenances_count asset maintenance(s) e não pode ser excluído. Atualize seus modelos para não referenciarem mais este fornecedor e tente novamente. ',
    )

);
