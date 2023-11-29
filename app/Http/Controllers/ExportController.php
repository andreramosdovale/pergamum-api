<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Export;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $this->validateRequest($request);

            $email = $request->input('email');
            $name = $request->input('name');
            $data = $request->input('data');

            Mail::to($email, $name)->send(new Export([
                'name' => $name,
                'email' => $email,
                'message' => $data,
            ]));

            return response('Email enviado com sucesso', 200);
        } catch (Exception $e) {
            return response('Erro no envio do email', 500);
        }
    }

    public function getToken()
    {
        return csrf_token();
    }

    private function validateRequest(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $data = $request->input('data');

        if (!is_string($name) || !is_string($email) || !is_array($data) || empty($data)) {
            throw new Exception('Dados incorretos');
        }
    }
}
