<?php

namespace App\Repositories;

use App\Models\Email;

class EmailsRepository
{
    public function gravar($payload, $status)
    {
        $dados = [];
        $dados["payload"] = $payload;
        $dados["status"] = $status;

        $email = Email::create($dados);
        return $email;
    }

    public function buscar()
    {
        return Email::all();
    }
}
