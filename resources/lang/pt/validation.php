<?php

return [
    'required' => 'O campo ":attribute" é obrigatório.',
    'confirmed'  => 'O campo ":attribute" não coincide.',
    'attributes' => [
        'titulo' => 'título',
        'introducao' => 'introdução',
        'corpo' => 'texto principal',
        'designacao' => 'designação',
        'password_confirmation' => 'repetir password'
    ],
    'email'  => 'O campo ":attribute" deverá conter um endereço de email válido.',
    'min' => [
        'string'  => 'O campo ":attribute" deverá conter pelo menos 6 caracteres.'
    ],
    'max'  => [
        'file'  => 'O campo :attribute não poderá exceder de :max kilobytes.'
    ],
    'image' => 'O campo ":attribute" deve ser uma imagem.',
    'mimes' => 'O campo ":attribute" deverá ter um dos seguintes formatos: :values.',
    
];