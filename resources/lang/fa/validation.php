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

    'accepted'             => 'ویژگی باید تایید شود.',
    'active_url'           => 'ویژگی یک URL معتبر نیست.',
    'after'                => 'ویژگی باید در تاریخی بعد از تاریخ باشد.',
    'after_or_equal'       => 'attribute باید یک تاریخ بعد باشد یا برابر باشد: date.',
    'alpha'                => 'ویژگی ممکن است فقط شامل حروف باشد.',
    'alpha_dash'           => 'ویژگی ممکن است فقط شامل حروف، اعداد و خط های فاصله باشد.',
    'alpha_num'            => 'ویژگی ممکن است فقط شامل حروف و اعداد باشد.',
    'array'                => 'attribute باید یک آرایه باشد.',
    'before'               => 'ویژگی باید در تاریخی قبل از تاریخ باشد.',
    'before_or_equal'      => 'attribute باید تاریخ قبل یا برابر باشد: date.',
    'between'              => [
        'numeric' => 'ویژگی باید بین حداقل حداکثر باشد.',
        'file'    => 'ویژگی باید بین حداقل حداکثر کیلوبایت باشد.',
        'string'  => 'ویژگی باید بین حداقل حداکثر کاراکتر باشد.',
        'array'   => 'خصیصه باید بین: min و: max items باشد.',
    ],
    'boolean'              => 'فیلد attribute باید درست یا غلط باشد.',
    'confirmed'            => 'تایید ویژگی منطبق نیست.',
    'date'                 => 'تاریخ ویژگی معتبر نیست.',
    'date_format'          => 'ویژگی منطبق بر شکل شکل نیست.',
    'different'            => 'ویژگی و دیگر باید متفاوت باشد.',
    'digits'               => 'ویژگی باید رقم رقم باشد.',
    'digits_between'       => 'ویژگی باید بین حداقل و حداکثر رقم باشد.',
    'dimensions'           => 'attribute: ابعاد تصویر نامعتبر است.',
    'distinct'             => 'فیلد attribute دارای مقدار تکراری است.',
    'email'                => 'شکل ویژگی نامعتبر است.',
    'exists'               => 'ویژگی انتخاب شده نامعتبر است.',
    'file'                 => 'attribute باید یک فایل باشد.',
    'filled'               => 'فیلد attribute باید مقدار داشته باشد.',
    'image'                => 'ویژگی باید یک عکس باشد.',
    'in'                   => 'ویژگی انتخاب شده نامعتبر است.',
    'in_array'             => 'فیلد attribute در هیچ موجودی وجود ندارد: دیگر.',
    'integer'              => 'ویژگی باید یک عدد باشد.',
    'ip'                   => 'ویژگی باید یک آدرس IP معتبر باشد.',
    'ipv4'                 => 'attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6'                 => 'attribute باید یک آدرس IPv6 معتبر باشد.',
    'json'                 => 'attribute باید یک رشته معتبر JSON باشد.',
    'max'                  => [
        'numeric' => 'ویژگی نباید بزرگتر از حداکثر باشد.',
        'file'    => 'ویژگی نباید بزرگتر از حداکثر کیلوبایت باشد.',
        'string'  => 'ویژگی نباید بزرگتر از حداکثر کاراکتر باشد.',
        'array'   => 'ویژگی: ممکن است بیش از موارد حداکثر داشته باشد.',
    ],
    'mimes'                => 'ویژگی باید فایلی از نوع ارزش ها باشد.',
    'mimetypes'            => 'attribute باید یک فایل از نوع:: values ​​باشد.',
    'min'                  => [
        'numeric' => 'ویژگی باید حداقل: حداقل باشد.',
        'file'    => 'ویژگی باید حداقل: حداقل کیلوبایت باشد.',
        'string'  => 'ویژگی باید حداقل: حداقل کاراکتر باشد.',
        'array'   => 'ویژگی: باید دارای حداقل موارد: min باشد.',
    ],
    'not_in'               => 'ویژگی انتخاب شده نامعتبر است.',
    'numeric'              => 'ویژگی باید عدد باشد.',
    'present'              => 'فیلد attribute باید باشد.',
    'valid_regex'          => 'That is not a valid regex. ',
    'regex'                => 'شکل ویژگی نامعتبر است.',
    'required'             => 'فیلد ویژگی ضروری است.',
    'required_if'          => 'فیلد ویژگی ضروری است، وقتی که دیگری ارزش است.',
    'required_unless'      => 'فیلد attribute: مورد نیاز است مگر اینکه: دیگر در: مقادیر باشد.',
    'required_with'        => 'فیلد ویژگی ضروری است، وقتی که ارزش موجود باشد.',
    'required_with_all'    => 'فیلد attribute: زمانی که: مقادیر وجود دارد.',
    'required_without'     => 'فیلد ویژگی ضروری است، وقتی که ارزش ها حاضر نباشند.',
    'required_without_all' => 'فیلد attribute: وقتی که هیچ یک از: مقادیر وجود ندارد، مورد نیاز است.',
    'same'                 => 'ویژگی و دیگری باید بر هم منطبق باشند.',
    'size'                 => [
        'numeric' => 'ویژگی باید به اندازه ی : سایز باشد.',
        'file'    => 'ویژگی باید به اندازه ی: سایز کیلوبایت باشد.',
        'string'  => 'ویژگی باید به اندازه ی : سایز کاراکتر باشد.',
        'array'   => 'attribute باید شامل موارد زیر باشد:',
    ],
    'string'               => 'attribute باید یک رشته باشد.',
    'timezone'             => ': attribute باید یک منطقه معتبر باشد.',
    'unique'               => 'ویژگی در حال حاضر گرفته شده است.',
    'uploaded'             => 'ویژگی: attribute failed to upload.',
    'url'                  => 'شکل ویژگی نامعتبر است.',
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
        'alpha_space' => "فیلد attribute شامل یک شخصیت است که مجاز نیست.",
        "email_array"      => "یک یا چند آدرس ایمیل نامعتبر است",
        "hashed_pass"      => "رمز عبور فعلی شما اشتباه است",
        'dumbpwd'          => 'این رمز عبور خیلی رایج است',
        "statuslabel_type" => "شما باید نوع برچسب معتبر را انتخاب کنید",
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
