<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'Ang: katangian na kailangan tanggapin.',
    'active_url'           => 'Ang: katangian ay hindi isang balidong URL.',
    'after'                => 'Ang :katangian ay dapat na gawin ang petsa pagkatapos ng :petsa.',
    'after_or_equal'       => 'Ang :katangian ay dapat na gawin ang petsa pagkatapos ng o katumbas sa:petsa.',
    'alpha'                => 'Ang :katangian ay maaaring naglalaman lang ng mga letra.',
    'alpha_dash'           => 'Ang :katangian ay maaaring naglalaman lamang ng mga letra, mga numero, at mga dashes.',
    'alpha_num'            => 'Ang :katangian ay maaaring naglalaman lamang ng mga letra at mga numero.',
    'array'                => 'Ang :katangian ay dapat isang hanay.',
    'before'               => 'Ang :katangian ay dapat na gawing petsa bago ang :petsa.',
    'before_or_equal'      => 'Ang :katangian ay dapat na gawin ang petsa pagkatapos ng o katumbas sa:petsa.',
    'between'              => [
        'numeric' => 'Ang: katangian dapat na nasa pagitan ng: min -: max.',
        'file'    => 'Ang: katangian dapat nasa pagitan ng: min -: max na kilobytes.',
        'string'  => 'Ang: katangiang dapat na nasa pagitan ng: min -: ni max na mga karakter.',
        'array'   => 'Ang :katangian na dapat magkaroon ng pagitan sa :min and :max na mga aytem.',
    ],
    'boolean'              => 'Ang :katangian na dapat maging tama o mali.',
    'confirmed'            => 'Ang :kompermasyong sa katangian ay hindi nagtugma.',
    'date'                 => 'Ang :hindi balidong petsa ng katangian.',
    'date_format'          => 'Ang :hindi nagtugma sa katangian nag pormat:pormat.',
    'different'            => 'Ang :katangian at ang :iba pa dapat na hindi magkapareho.',
    'digits'               => 'Ang :katangian ay dapat na :mga digit digit.',
    'digits_between'       => 'Ang :katangian ay dapat nasa pagitan ng :min at :max na mga digit.',
    'dimensions'           => 'Ang :katangian ay mayroong hindi balidong dimensyon ng mga imahe.',
    'distinct'             => 'Ang :field na katangian ay mayroong dobleng balyu.',
    'email'                => 'Ang :pormat ng katangian ay hindi balido o wasto.',
    'exists'               => 'Ang napili na :katangian ay hindi balido.',
    'file'                 => 'Ang :katangian ay dapat na isang file.',
    'filled'               => 'Ang :field na katangian ay dapat na mayroong balyu.',
    'image'                => 'Ang :katangian at dapat na isang imahe.',
    'in'                   => 'Ang napili na :katangian ay hindi balido.',
    'in_array'             => 'Ang :field na katangian ay hindi umiiral sa :iba pa.',
    'integer'              => 'Ang :katangian ay dapat ns isang integer.',
    'ip'                   => 'Ang :katangian ay dapat na isang balidong mga IP address.',
    'ipv4'                 => 'Ang :katangian ay dapat na isang balidong IPv4 address.',
    'ipv6'                 => 'Ang :katangian ay dapat na isang balidong IPv6 address.',
    'json'                 => 'Ang :katangian ay dapa na isang balidong JSON na string.',
    'max'                  => [
        'numeric' => 'Ang :katangian ay maaaring hindi lalagpas sa :max.',
        'file'    => 'Ang :katangian ay maaaring hindi lalagpas sa :max na kilobytes.',
        'string'  => 'Ang :katangian ay maaaring hindi lalagpas sa :max na mga karakter.',
        'array'   => 'Ang :katangian ay maaaring hindi magkaroon ng higit sa :max na mga aytem.',
    ],
    'mimes'                => 'Ang :katangian ay dapat na isang uri ng file :mga balyu.',
    'mimetypes'            => 'Ang :katangian ay dapat na isang uri ng file :mga balyu.',
    'min'                  => [
        'numeric' => 'Ang :katangian ay dapat na hindi bumaba sa :min.',
        'file'    => 'Ang :katangian ay dapat na hindi bumaba sa :min na kilobytes.',
        'string'  => 'Ang :katangian ay dapat na hindi bumaba sa :min na mga karakter.',
        'array'   => 'Ang :katangian ay dapat na magkaroon ng hindi bumaba sa :min na mga aytem.',
    ],
    'not_in'               => 'Ang napili na :katangian ay hindi balido.',
    'numeric'              => 'Ang :katangian ay dapat na isang numero.',
    'present'              => 'Ang :field ng katangian ay dapat na naroroon.',
    'valid_regex'          => 'Hindi ito balidong regex. ',
    'regex'                => 'Ang :promat ng katangian ay hindi balido.',
    'required'             => 'Ang :field ng katangian ay kinakailangan.',
    'required_if'          => 'Ang :field ng katangian ay kinakailangan kapag :ang iba ay :balyu.',
    'required_unless'      => 'Ang :field ng katangian ay kinakailangan maliban kung :ang iba ay nasa :mga balyu.',
    'required_with'        => 'Ang :field.ng katangian ay kinakailangan kapag :ang mga balyu ay naroroon.',
    'required_with_all'    => 'Ang :field ng katangian ay kinakailangan kapag :ang mga balyu ay naroroon.',
    'required_without'     => 'Ang :field ng katangian ay kinakailangan kapag :ang mga balyu ay naroroon.',
    'required_without_all' => 'Ang :field ng katangian ay kinakailangan kapag wala sa :mga balyu ay naroroon.',
    'same'                 => 'Ang :katangian at :ang iba ay dapat magkatugma.',
    'size'                 => [
        'numeric' => 'Ang :katangian ay dapat na :sukat.',
        'file'    => 'Ang :katangian ay dapat na :sukat na kilobytes.',
        'string'  => 'Ang :katangian ay dapat na maging :sukat ng mga karakter.',
        'array'   => 'Ang :katangian ay dapat na magkaroon ng :sukat ng mga aytem.',
    ],
    'string'               => 'Ang :katangian ay dapat na isang string.',
    'timezone'             => 'Ang :katangian ay dapat na isang balidong zone.',
    'unique'               => 'Ang :katangian ay nakuha na.',
    'uploaded'             => 'Ang :katangian ay hindi nagtagumpay sa pag-upload.',
    'url'                  => 'Ang :pormat ng katangian ng pormat ay hindi balido.',
    "unique_undeleted"     => "Ang :katangian ay dapat na natatangi.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'alpha_space' => "Ang :field ng katangian ay naglalaman ng karakter na hindi pinapayagan.",
        "email_array"      => "Imbalido ang isa o higit pang mga email address.",
        "hashed_pass"      => "Ang iyong kasalukuyang password ay hindi wasto",
        'dumbpwd'          => 'Ang password ay sobrang pangkaraniwan.',
        "statuslabel_type" => "Kinakailangang pumili ng balidong uri ng label ng estado",
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

);
