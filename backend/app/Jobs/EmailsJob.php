<?php

namespace App\Jobs;

use App\Mail\EmailsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class EmailsJob implements ShouldQueue
{
    use Queueable;
    private $dados;
    public $tries = 1;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function recuperarDados()
    {
        return $this->dados;
    }

    public function handle(): void
    {
        Mail::to($this->dados["email_destinatario"])->send(new EmailsMail($this->dados, $this->dados["assunto_email"]));
    }
}