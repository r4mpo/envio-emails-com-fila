<?php

namespace App\Http\Requests\Emails;

use Illuminate\Foundation\Http\FormRequest;

class EnviarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "nome_destinatario"     => ["required","string"],
            "email_destinatario"    => ["required","email"],
            "assunto_email"         => ["required","string","max:255"],
            "corpo_email"           => ["required","string"],
        ];
    }

    public function messages(): array
    {
        return [
            "required"  => "O campo :attribute é obrigatório",
            "email"     => "O campo :attribute deve ser um endereço de e-mail válido",
            "string"    => "O campo :attribute deve ser uma string válida",
            "max"       => "O campo :attribute não deve ultrapassar o limite de :max caracteres"
        ];
    }
}