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

    'accepted'             => ':attribute turi būti patvirtintas.',
    'active_url'           => ':attribute nėra tinkamas interentinis puslapis.',
    'after'                => ':attribute privalo būti data po :date.',
    'after_or_equal'       => 'Atributas turi būti datos, kuri yra arba lygi: data.',
    'alpha'                => ':attribute gali būti tik raidės.',
    'alpha_dash'           => ':attribute gali būti tik raidės, skaičiai ir brūkšneliai.',
    'alpha_num'            => ':attribute gali būti tik raidės ir skaičiai.',
    'array'                => 'Atributas turi būti masyvas.',
    'before'               => ':attribute turi būti data prieš :date.',
    'before_or_equal'      => 'Atributas turi būti data prieš arba lygus: data.',
    'between'              => [
        'numeric' => ':attribute privalo būti tarp :min - :max.',
        'file'    => ':attribute privalo būti tarp :min - :max kilobaitų.',
        'string'  => ':attribute privalo būti tarp :min - :max ženklų.',
        'array'   => 'Atributas turi būti tarp: min ir: max elementų.',
    ],
    'boolean'              => 'Laukas: attribute turi būti teisingas arba klaidingas.',
    'confirmed'            => ':attribute patvirtinimas nesutampa.',
    'date'                 => ':attribute nėra galiojanti data.',
    'date_format'          => ':attribute nesutampa su formatu :format.',
    'different'            => ':attribute ir :other turi būti skirtingi.',
    'digits'               => ':attribute privalo būti :digits skaičiai.',
    'digits_between'       => ':attribute privalo būti tarp :min ir:max skaičių.',
    'dimensions'           => 'Atributui yra netinkamų vaizdo matmenų.',
    'distinct'             => 'Atributo laukas turi dvigubą reikšmę.',
    'email'                => ':attribute formatas neteisingas.',
    'exists'               => 'Pasirinktas :attribute neteisingas.',
    'file'                 => 'Atributas turi būti failas.',
    'filled'               => 'Atributo laukas turi turėti reikšmę.',
    'image'                => ':attribute privalo būti paveikslėlis.',
    'in'                   => 'Pasirinktas :attribute neteisingas.',
    'in_array'             => 'Atributo laukas neegzistuoja: kitame.',
    'integer'              => ':attribute turi būti sveikas skaičius.',
    'ip'                   => ':attribute privalo būti tinkamas IP adresas.',
    'ipv4'                 => 'Atributas turi būti galiojantis IPv4 adresas.',
    'ipv6'                 => 'Atributas turi būti galiojantis IPv6 adresas.',
    'json'                 => 'Atributas turi būti galiojantis JSON eilutė.',
    'max'                  => [
        'numeric' => ':attribute negali būti didesnis nei :max.',
        'file'    => ':attribute negali būti didesnis nei :max kilobaitų.',
        'string'  => ':attribute negali būti didesnis nei :max ženklai.',
        'array'   => 'Atributas gali būti ne daugiau kaip: max elementai.',
    ],
    'mimes'                => ':attribute privalo būti failas, kurio formatas :values.',
    'mimetypes'            => 'Atributas turi būti failo tipas:: reikšmės.',
    'min'                  => [
        'numeric' => ':attribute privalo būti ne mažesnis nei :min.',
        'file'    => ':attribute turi būti bent :min kilobaitų.',
        'string'  => ':attribute privalo būti bent :min ženklai.',
        'array'   => 'Atributui turi būti bent: min elementai.',
    ],
    'not_in'               => 'Pasirinktas :attribute neteisingas.',
    'numeric'              => ':attribute privalo būti skaičius.',
    'present'              => 'Atributo laukas turi būti.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => ':attribute formatas neteisingas.',
    'required'             => ':attribute laukelis privalomas.',
    'required_if'          => ':attribute laukelis yra privalomas kai :other yra :value.',
    'required_unless'      => 'Atributo laukas reikalingas, nebent: kitame yra: reikšmės.',
    'required_with'        => ':attribute laukelis privalomas kai :values yra nurodytas.',
    'required_with_all'    => 'Atributo laukas reikalingas tada, kai yra reikšmės.',
    'required_without'     => ':attribute laukelis privalomas kai :values yra nenurodytas.',
    'required_without_all' => 'Atributo laukas reikalingas, kai nėra nė vieno iš: vertės.',
    'same'                 => ':attribute ir :other privalo sutapti.',
    'size'                 => [
        'numeric' => ':attribute privalo būti :size.',
        'file'    => ':attribute privalo būti :size kilobaitų.',
        'string'  => ':attribute privalo būti :size ženklų.',
        'array'   => 'Atributas turi būti: dydžio elementai.',
    ],
    'string'               => 'Atributas turi būti eilutė.',
    'timezone'             => 'Atributas turi būti tinkama zona.',
    'unique'               => ':attribute jau užimtas.',
    'uploaded'             => 'Nepavyko įkelti atributo.',
    'url'                  => ':attribute formatas neteisingas.',
    "unique_undeleted"     => "The :attribute must be unique.",

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
        'alpha_space' => "Lauke: atributo lauke yra simbolis, kuris nėra leidžiamas.",
        "email_array"      => "Vienas ar keli el. Pašto adresai yra netinkami.",
        "hashed_pass"      => "Jūsų dabartinis slaptažodis yra neteisingas",
        'dumbpwd'          => 'Šis slaptažodis yra per dažnas.',
        "statuslabel_type" => "Turite pasirinkti tinkamą statuso etiketės tipą",
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
