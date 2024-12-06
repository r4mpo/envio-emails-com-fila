<?php

namespace App\Providers;

use App\Models\Email;
use App\Repositories\EmailsRepository;
use Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Queue::failing(callback: function (JobFailed $event) {
            $gravarEmail = new EmailsRepository();
            $gravarEmail->gravar($event->job->payload()['data']['command'], Email::EMAIL_FALHA);
        });

        Queue::after(function (JobProcessed $event) {
            $gravarEmail = new EmailsRepository();
            $gravarEmail->gravar($event->job->payload()['data']['command'], Email::EMAIL_SUCESSO);
        });
    }
}
