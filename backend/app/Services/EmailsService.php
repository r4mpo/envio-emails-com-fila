<?php

namespace App\Services;

use App\Jobs\EmailsJob;
use App\Repositories\EmailsRepository;

class EmailsService
{
    public function enviar($request): array
    {
        try {
            $dados = $request->only("nome_destinatario", "email_destinatario", "assunto_email", "corpo_email");
            EmailsJob::dispatch($dados);
            $response = ["cod" => 111, "dados" => $dados];
        } catch (\Throwable $th) {
            $response = ["cod" => 333, "response" => $th->getMessage()];
        } finally {
            return $response;
        }
    }

    public function recuperar()
    {
        try {
            $emailsRepository = new EmailsRepository();
            $dados = $emailsRepository->buscar();

            $emails = [];

            foreach ($dados as $dado) {
                $emails[] = [
                    'id' => $dado->id,
                    'dados' => $this->decodificar($dado->payload),
                    'status' => $dado->defineStatus()
                ];
            }

            $response = ["cod" => 111, "dados" => $emails];
        } catch (\Throwable $th) {
            $response = ["cod" => 333, "response" => $th->getMessage()];
        } finally {
            return $response;
        }
    }

    private function decodificar($payload)
    {
        return unserialize($payload)->recuperarDados();
    }
}
