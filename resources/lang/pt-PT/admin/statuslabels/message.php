<?php

return array(

    'does_not_exist' => 'Etiqueta de estado não existe.',
    'assoc_assets'	 => 'Esta etiqueta de estado está associada a pelo menos um Asset e não pode ser apagada. Atualize os seus Assets para que não sejam usados novamente como referência a estes estado e tente novamente. ',


    'create' => array(
        'error'   => 'Etiqueta de estado não foi criada, tente novamente.',
        'success' => 'Etiqueta de estado criada com sucesso.'
    ),

    'update' => array(
        'error'   => 'Etiqueta de estado não foi atulizada, tente novamente',
        'success' => 'Etiqueta de estado atualizada com sucesso.'
    ),

    'delete' => array(
        'confirm'   => 'Tem a certeza que pretende eliminar esta etiqueta de estado?',
        'error'   => 'Ocorreu um erra ao eliminar a etiqueta de estado. Tente novamente.',
        'success' => 'A etiqueta de estado foi eliminada com sucesso.'
    ),

    'help' => array(
        'undeployable'   => 'Esses ativos não podem ser atribuídos a ninguém.',
        'deployable'   => 'Esses ativos podem ser verificados. Uma vez que são atribuídos, eles assumirão um status meta de <i class="fa fa-circle text-blue"></i> <strong>Deployed</strong>.',
        'archived'   => 'Esses ativos não podem ser verificados, e só aparecerão na visão arquivada. Isso é útil para manter informações sobre recursos para fins orçamentários / históricos, mas mantendo-os fora da lista de ativos do dia-a-dia.',
        'pending'   => 'Esses ativos ainda não podem ser atribuídos a qualquer pessoa, muitas vezes usado para itens que estão fora de reparo, mas é esperado que retornem à circulação.',
    ),

);
