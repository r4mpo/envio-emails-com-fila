@extends('layouts.main')
@section('titulo', 'E-mail...')
@section('conteudo')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
    </head>

    <div class="container">

        <div class="message">
            <p>Prezado (a) {{ $dados['nome_destinatario'] }} ({{ $dados['email_destinatario'] }}),</p>
            <p>{{ $dados['corpo_email'] }}</p>
        </div>

    </div>

@endsection
