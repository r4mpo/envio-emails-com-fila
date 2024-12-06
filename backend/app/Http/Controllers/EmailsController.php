<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Emails\EnviarRequest;
use App\Jobs\EmailsJob;
use App\Services\EmailsService;

class EmailsController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new EmailsService();
    }

    public function enviar(EnviarRequest $request)
    {
        $response = $this->service->enviar($request);
        return response()->json($response);
    }

    public function recuperar()
    {
        $response = $this->service->recuperar();
        return response()->json($response);
    }
}