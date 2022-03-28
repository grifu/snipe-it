<?php

return array(

    'undeployable' 		=> '<strong>Warning: </strong> This asset has been marked as currently undeployable.
                        If this status has changed, please update the asset status.',
    'does_not_exist' 	=> 'Asset does not exist.',
    'no_requestID' 	    => 'Oops! The request ID does not exist, please contact the administrator.',
    'does_not_exist_or_not_requestable' => 'Nice try. That asset does not exist or is not requestable.',
    'assoc_users'	 	=> 'This asset is currently checked out to a user and cannot be deleted. Please check the asset in first, and then try deleting again. ',
    'no_responsible'	=> 'The reservation must have a responsible, please choose a person that will be the responsible for thre reservation.',
    'canceled'	        => 'Nothing to aprove, the reservation was already canceled, or checked out.',
    'isnot_responsible'	=> 'The user identifed as responsible does not have permissions as responsible, the reservation should be submited again with a valid responsible.',
    'no_dates'	        => 'Missing dates (checkin or checkout). The reservation must have both dates filled.',
    'dateOverlap'       => 'Date overlap. The dates were changed manually, use the calendar to select the correct date',
    'equal_dates'	    => 'The date/time of checkout must be different from the date/time of checkin.',


    'create' => array(
        'error'   		=> 'Asset was not created, please try again. :(',
        'success' 		=> 'Asset created successfully. :)'
    ),

    'update' => array(
        'error'   			=> 'Asset was not updated, please try again',
        'success' 			=> 'Asset updated successfully.',
        'nothing_updated'	=>  'No fields were selected, so nothing was updated.',
    ),

    'restore' => array(
        'error'   		=> 'Asset was not restored, please try again',
        'success' 		=> 'Asset restored successfully.'
    ),

    'audit' => array(
        'error'   		=> 'Asset audit was unsuccessful. Please try again.',
        'success' 		=> 'Asset audit successfully logged.'
    ),


    'deletefile' => array(
        'error'   => 'File not deleted. Please try again.',
        'success' => 'File successfully deleted.',
    ),

    'upload' => array(
        'error'   => 'File(s) not uploaded. Please try again.',
        'success' => 'File(s) successfully uploaded.',
        'nofiles' => 'You did not select any files for upload, or the file you are trying to upload is too large',
        'invalidfiles' => 'One or more of your files is too large or is a filetype that is not allowed. Allowed filetypes are png, gif, jpg, doc, docx, pdf, and txt.',
    ),

    'import' => array(
        'error'                 => 'Some items did not import correctly.',
        'errorDetail'           => 'The following Items were not imported because of errors.',
        'success'               => "Your file has been imported",
        'file_delete_success'   => "Your file has been been successfully deleted",
        'file_delete_error'      => "The file was unable to be deleted",
    ),


    'delete' => array(
        'confirm'   	=> 'Are you sure you wish to delete this asset?',
        'error'   		=> 'There was an issue deleting the asset. Please try again.',
        'nothing_updated'   => 'No assets were selected, so nothing was deleted.',
        'success' 		=> 'The asset was deleted successfully.'
    ),

    'checkout' => array(
        'error'   		=> 'Asset was not checked out, please try again',
        'success' 		=> 'Asset checked out successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'not_available' => 'That asset is not available for checkout!',
        'no_assets_selected' => 'You must select at least one asset from the list'
    ),

    'checkin' => array(
        'error'   		=> 'Asset was not checked in, please try again',
        'success' 		=> 'Asset checked in successfully.',
        'user_does_not_exist' => 'That user is invalid. Please try again.',
        'already_checked_in'  => 'That asset is already checked in.',

    ),

    'requests' => array(
        'error'   		=> 'Asset was not requested, please try again',
        'success' 		=> 'Asset requested successfully.',
        'warning' 		=> 'Asset requested was processed but it was incomplete (the notes should be filled indentifying the class and the project) .',
        'incomplete'    => 'Some of the dates from the recurrent reservation were not processed due to some overlaping dates with other reservations.',
        'canceled'      => 'Checkout request successfully canceled'
    )

);
