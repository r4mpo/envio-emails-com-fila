<?php

namespace App\Services;

use App\Jobs\EmailsJob;
use App\Repositories\EmailsRepository;
use App\Repositories\JobsRepository;

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
            $emails = $emailsRepository->buscar();

            $jobsRepository = new JobsRepository();
            $jobs = $jobsRepository->buscar();


            $emailsFormatados = [];
            $jobsFormatados = [];

            foreach ($emails as $dado) {
                $emailsFormatados[] = [
                    'id' => base64_encode($dado->id . now()),
                    'dados' => $this->decodificar($dado->payload, 1),
                    'status' => $dado->defineStatus(),
                    'data_hora' => date('d/m/Y H:i:s', strtotime($dado->created_at))
                ];
            }

            foreach ($jobs as $dado) {
                $jobsFormatados[] = [
                    'id' => base64_encode($dado->id . now()),
                    'dados' => $this->decodificar($dado->payload, 0),
                    'status' => "Em fila",
                    'data_hora' => date('d/m/Y H:i:s', strtotime($dado->created_at))
                ];
            }

            $dados = array_merge($emailsFormatados, $jobsFormatados);
            $response = ["cod" => 111, "dados" => $dados];
        } catch (\Throwable $th) {
            $response = ["cod" => 333, "response" => $th->getMessage()];
        } finally {
            return $response;
        }
    }

    private function decodificar($payload, $type)
    {
        $payload = $type == 1 ? $payload : json_decode($payload)->data->command;
        return unserialize($payload)->recuperarDados();
    }
}
