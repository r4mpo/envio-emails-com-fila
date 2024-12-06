<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ["payload", "status"];

    const EMAIL_FALHA = 1;
    const EMAIL_PENDENCIA = 2;
    const EMAIL_SUCESSO = 3;

    public function defineStatus()
    {
        switch ($this->status) {
            case self::EMAIL_FALHA:
                return "Falha no envio";
            case self::EMAIL_SUCESSO:
                return "Enviado";
            default:
                return "Em fila";
        }
    }
}
