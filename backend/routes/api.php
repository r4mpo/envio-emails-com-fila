<?php

use App\Http\Controllers\EmailsController as Emails;
use Illuminate\Support\Facades\Route;

Route::controller(Emails::class)->prefix("emails")->group(function (){
    Route::get("recuperar", "recuperar")->name("emails.recuperar");
    Route::post("enviar", "enviar")->name("emails.enviar");
});