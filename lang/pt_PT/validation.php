
<?php

return [

    'accepted' => 'O campo :attribute tem de ser aceite.',
    'active_url' => 'O campo :attribute não contém um URL válido.',
    'after' => 'O campo :attribute tem de conter uma data posterior a :date.',
    'after_or_equal' => 'O campo :attribute tem de conter uma data igual ou posterior a :date.',
    'alpha' => 'O campo :attribute só pode conter letras.',
    'alpha_dash' => 'O campo :attribute só pode conter letras, números, hífenes e sublinhados.',
    'alpha_num' => 'O campo :attribute só pode conter letras e números.',
    'array' => 'O campo :attribute tem de ser uma lista.',
    'before' => 'O campo :attribute tem de conter uma data anterior a :date.',
    'before_or_equal' => 'O campo :attribute tem de conter uma data igual ou anterior a :date.',
    'between' => [
        'array' => 'O campo :attribute tem de conter entre :min e :max elementos.',
        'file' => 'O ficheiro :attribute tem de ter entre :min e :max KB.',
        'numeric' => 'O campo :attribute tem de estar entre :min e :max.',
        'string' => 'O campo :attribute tem de ter entre :min e :max caracteres.',
    ],
    'boolean' => 'O campo :attribute tem de ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação do campo :attribute não corresponde.',
    'current_password' => 'A palavra-passe introduzida está incorreta.',
    'date' => 'O campo :attribute não contém uma data válida.',
    'date_equals' => 'O campo :attribute tem de ser uma data igual a :date.',
    'date_format' => 'O campo :attribute não corresponde ao formato :format.',
    'different' => 'Os campos :attribute e :other têm de ser diferentes.',
    'digits' => 'O campo :attribute tem de conter :digits algarismos.',
    'digits_between' => 'O campo :attribute tem de conter entre :min e :max algarismos.',
    'dimensions' => 'A imagem :attribute tem dimensões inválidas.',
    'distinct' => 'O campo :attribute contém um valor duplicado.',
    'email' => 'O campo :attribute tem de conter um endereço de e-mail válido.',
    'ends_with' => 'O campo :attribute tem de terminar com um dos seguintes valores: :values.',
    'exists' => 'O valor selecionado para :attribute é inválido.',
    'file' => 'O campo :attribute tem de ser um ficheiro.',
    'filled' => 'O campo :attribute é obrigatório quando está presente.',
    'gt' => [
        'array' => 'O campo :attribute tem de conter mais de :value elementos.',
        'file' => 'O ficheiro :attribute tem de ser superior a :value KB.',
        'numeric' => 'O campo :attribute tem de ser superior a :value.',
        'string' => 'O campo :attribute tem de ter mais de :value caracteres.',
    ],
    'gte' => [
        'array' => 'O campo :attribute tem de conter :value elementos ou mais.',
        'file' => 'O ficheiro :attribute tem de ter pelo menos :value KB.',
        'numeric' => 'O campo :attribute tem de ser igual ou superior a :value.',
        'string' => 'O campo :attribute tem de ter pelo menos :value caracteres.',
    ],
    'image' => 'O campo :attribute tem de ser uma imagem.',
    'in' => 'O valor selecionado para :attribute é inválido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O campo :attribute tem de ser um número inteiro.',
    'ip' => 'O campo :attribute tem de conter um endereço IP válido.',
    'ipv4' => 'O campo :attribute tem de conter um endereço IPv4 válido.',
    'ipv6' => 'O campo :attribute tem de conter um endereço IPv6 válido.',
    'json' => 'O campo :attribute tem de conter um JSON válido.',
    'lt' => [
        'array' => 'O campo :attribute tem de conter menos de :value elementos.',
        'file' => 'O ficheiro :attribute tem de ser inferior a :value KB.',
        'numeric' => 'O campo :attribute tem de ser inferior a :value.',
        'string' => 'O campo :attribute tem de ter menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'O campo :attribute não pode conter mais de :value elementos.',
        'file' => 'O ficheiro :attribute não pode ter mais de :value KB.',
        'numeric' => 'O campo :attribute tem de ser igual ou inferior a :value.',
        'string' => 'O campo :attribute não pode ter mais de :value caracteres.',
    ],
    'max' => [
        'array' => 'O campo :attribute não pode conter mais de :max elementos.',
        'file' => 'O ficheiro :attribute não pode ter mais de :max KB.',
        'numeric' => 'O campo :attribute não pode ser superior a :max.',
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
    ],
    'mimes' => 'O campo :attribute tem de ser um ficheiro do tipo: :values.',
    'mimetypes' => 'O campo :attribute tem de ser um ficheiro do tipo: :values.',
    'min' => [
        'array' => 'O campo :attribute tem de conter pelo menos :min elementos.',
        'file' => 'O ficheiro :attribute tem de ter pelo menos :min KB.',
        'numeric' => 'O campo :attribute tem de ser, no mínimo, :min.',
        'string' => 'O campo :attribute tem de ter pelo menos :min caracteres.',
    ],
    'not_in' => 'O valor selecionado para :attribute é inválido.',
    'not_regex' => 'O formato do campo :attribute é inválido.',
    'numeric' => 'O campo :attribute tem de ser um número.',
    'password' => [
        'letters' => 'A palavra-passe tem de conter pelo menos uma letra.',
        'mixed' => 'A palavra-passe tem de conter letras maiúsculas e minúsculas.',
        'numbers' => 'A palavra-passe tem de conter pelo menos um número.',
        'symbols' => 'A palavra-passe tem de conter pelo menos um símbolo.',
        'uncompromised' => 'A palavra-passe escolhida foi identificada numa fuga de dados. Escolha outra.',
    ],
    'present' => 'O campo :attribute tem de estar presente.',
    'prohibited' => 'O campo :attribute não é permitido.',
    'prohibited_if' => 'O campo :attribute não é permitido quando :other é :value.',
    'prohibited_unless' => 'O campo :attribute não é permitido, exceto quando :other tem um dos seguintes valores: :values.',
    'prohibits' => 'O campo :attribute impede a presença de :other.',
    'regex' => 'O formato do campo :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório, exceto quando :other tem um dos seguintes valores: :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando todos os campos :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos campos :values está presente.',
    'same' => 'Os campos :attribute e :other têm de corresponder.',
    'size' => [
        'array' => 'O campo :attribute tem de conter :size elementos.',
        'file' => 'O ficheiro :attribute tem de ter :size KB.',
        'numeric' => 'O campo :attribute tem de ser igual a :size.',
        'string' => 'O campo :attribute tem de ter :size caracteres.',
    ],
    'starts_with' => 'O campo :attribute tem de começar com um dos seguintes valores: :values.',
    'string' => 'O campo :attribute tem de ser um texto.',
    'timezone' => 'O campo :attribute tem de conter um fuso horário válido.',
    'unique' => 'O valor introduzido para :attribute já está a ser utilizado.',
    'uploaded' => 'Não foi possível carregar o ficheiro :attribute.',
    'url' => 'O campo :attribute tem de conter um URL válido.',
    'uuid' => 'O campo :attribute tem de conter um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'nome',
        'email' => 'endereço de e-mail',
        'password' => 'palavra-passe',
        'current_password' => 'palavra-passe atual',
        'new_password' => 'nova palavra-passe',
        'password_confirmation' => 'confirmação da palavra-passe',
        'phone' => 'número de telefone',
        'message' => 'mensagem',
        'subject' => 'assunto',
        'title' => 'título',
        'description' => 'descrição',
        'image' => 'imagem',
        'file' => 'ficheiro',
        'date' => 'data',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Messages
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'email' => [
            'required' => 'Por favor, introduza o seu endereço de e-mail.',
            'email' => 'Introduza um endereço de e-mail válido.',
        ],
        'password' => [
            'required' => 'Por favor, introduza a sua palavra-passe.',
            'min' => 'A palavra-passe deve ter pelo menos :min caracteres.',
        ],
    ],

];
