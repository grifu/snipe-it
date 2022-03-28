<?php

return array(

    'does_not_exist' => 'Το μοντέλο δεν υπάρχει.',
    'assoc_users'	 => 'Αυτό το μοντέλο συσχετίζεται επί του παρόντος με ένα ή περισσότερα στοιχεία και δεν μπορεί να διαγραφεί. Διαγράψτε τα στοιχεία και, στη συνέχεια, δοκιμάστε ξανά τη διαγραφή.',


    'create' => array(
        'error'   => 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά.',
        'success' => 'Το μοντέλο δημιουργήθηκε με επιτυχία.',
        'duplicate_set' => 'Ένα μοντέλο στοιχείων ενεργητικού με αυτό το όνομα, τον κατασκευαστή και τον αριθμό μοντέλου υπάρχει ήδη.',
    ),

    'update' => array(
        'error'   => 'Μοντέλο δεν ενημερώθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' => 'Το μοντέλο ενημερώθηκε επιτυχώς.'
    ),

    'delete' => array(
        'confirm'   => 'Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το περιουσιακό μοντέλο;',
        'error'   => 'Υπήρξε ένα ζήτημα διαγράφοντας αυτό το μοντέλο. Παρακαλώ δοκιμάστε ξανά.',
        'success' => 'Το μοντέλο διαγράφηκε με επιτυχία.'
    ),

    'restore' => array(
        'error'   		=> 'Το μοντέλο δεν δημιουργήθηκε, παρακαλώ προσπαθήστε ξανά',
        'success' 		=> 'Το μοντέλο επαναφέρθηκε με επιτυχία.'
    ),

    'bulkedit' => array(
        'error'   		=> 'Δεν άλλαξαν πεδία, επομένως τίποτα δεν ενημερώθηκε.',
        'success' 		=> 'Τα μοντέλα ενημερώθηκαν.'
    ),

    'bulkdelete' => array(
        'error'   		    => 'No models were selected, so nothing was deleted.',
        'success' 		    => ':success_count model(s) deleted!',
        'success_partial' 	=> ':success_count model(s) were deleted, however :fail_count were unable to be deleted because they still have assets associated with them.'
    ),

);
