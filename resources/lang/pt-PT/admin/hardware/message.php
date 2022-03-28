<?php

return array(

    'undeployable' 		=> '<strong>Aviso: </strong> Este artigo foi assinalado como "não implementável".
                        Se este estado mudou, por favor atualize o estado do artigo.',
    'does_not_exist' 	=> 'Artigo não existente.',
    'does_not_exist_or_not_requestable' => 'Boa tentativa. Esse artigo não existe ou não é solicitável.',
    'no_requestID' 	    => 'Oops! O número de reserva não existe, por favor contactar o administrador.',
    'assoc_users'	 	=> 'Este artigo está correntemente alocado a um utilizador e não pode ser removido. Por favor devolva o artigo e de seguida tente remover novamente. ',
    'no_responsible'	=> 'A reserva tem de ter um responsável. Deve ser identiticado o responsável no campo da reserva. ',
    'canceled'	        => 'Nada para aprovar, a reserva foi cancelada ou já foi alocada.',
    'isnot_responsible'	=> 'O utilizador identificado como responsável não tem permissões de responsável, deverá ser indicado um responsável com permissões. ',
    'no_dates'	        => 'Faltou preencher uma das datas (levantamento ou devolução). A reserva deve identificar estas datas.',
    'dateOverlap'       => 'Datas sobrepostas. As datas foram alteradas manualmente, utilizar o calendário para ecolher a data correctamente.',
    'equal_dates'	=> 'A data/hora de levantamento não pode ser igual à data/hora entrega do ativo.',

    'create' => array(
        'error'   		=> 'Não foi possível criar o Artigo. Por favor, tente novamente. :(',
        'success' 		=> 'Artigo criado com sucesso. :)'
    ),

    'update' => array(
        'error'   			=> 'Artigo não foi atualizado. Por favor, tente novamente',
        'success' 			=> 'Artigo atualizado com sucesso.',
        'nothing_updated'	=>  'Nenhum atributo foi selecionado, portanto nada foi atualizado.',
    ),

    'restore' => array(
        'error'   		=> 'O Artigo não foi restaurado, por favor tente novamente',
        'success' 		=> 'Artigo restaurado com sucesso.'
    ),

    'audit' => array(
        'error'   		=> 'A auditoria de ativos não teve êxito. Por favor, tente novamente.',
        'success' 		=> 'Auditoria de ativos logada com sucesso.'
    ),


    'deletefile' => array(
        'error'   => 'Ficheiro não removido. Por favor, tente novamente.',
        'success' => 'Ficheiro removido com sucesso.',
    ),

    'upload' => array(
        'error'   => 'Ficheiro(s) não submetidos. Por favor, tente novamente.',
        'success' => 'Ficheiro(s) submetidos com sucesso.',
        'nofiles' => 'Não selecionou nenhum ficheiro para submissão, ou o ficheiro que pretende submeter é demasiado grande',
        'invalidfiles' => 'Um ou mais ficheiros são demasiado grandes ou trata-se de um tipo de ficheiro não permitido. Os tipos de ficheiro permitidos são png, gif, jpg, jpeg, doc, docx, pdf e txt.',
    ),

    'import' => array(
        'error'                 => 'Alguns itens não foram importados corretamente.',
        'errorDetail'           => 'Os seguintes itens não foram importados devido a erros.',
        'success'               => "O seu ficheiro foi importado",
        'file_delete_success'   => "Ficheiro eliminado com sucesso",
        'file_delete_error'      => "Não foi possível eliminar o ficheiro",
    ),


    'delete' => array(
        'confirm'   	=> 'Tem a certeza de que pretende eliminar este artigo?',
        'error'   		=> 'Ocorreu um problema ao remover o artigo. Por favor, tente novamente.',
        'nothing_updated'   => 'Nenhum recurso foi selecionado, então nada foi excluído.',
        'success' 		=> 'O artigo foi removido com sucesso.'
    ),

    'checkout' => array(
        'error'   		=> 'Não foi possível alocar o artigo, por favor tente novamente',
        'success' 		=> 'Artigo alocado com sucesso.',
        'user_does_not_exist' => 'O utilizador é inválido. Por favor, tente novamente.',
        'not_available' => 'Esse recurso não está disponível para checkout!',
        'no_assets_selected' => 'Deve escolher pelo menos um artigo da lista'
    ),

    'checkin' => array(
        'error'   		=> 'Não foi possível devolver o artigo, por favor tente novamente',
        'success' 		=> 'Artigo devolvido com sucesso.',
        'user_does_not_exist' => 'O utilizador é inválido. Por favor, tente novamente.',
        'already_checked_in'  => 'Este artigo já foi devolvido.',

    ),

    'requests' => array(
        'error'   		=> 'Ativo não foi solicitado, por favor tente novamente',
        'success' 		=> 'Ativo solicitado com sucesso.',
        'warning' 		=> 'O Ativo solicitado foi processado, mas a reserva estava incompleta. Deve ser identificado o projecto e o curso no campo das notas.',
        'incomplete'    => 'Não foram processadas todas as datas da reserva recorrente pois algumas das datas estão sobrepostas com outras reservas.',
        'canceled'      => 'Requisição cancelado com sucesso'
    )

);
