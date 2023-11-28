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
        if (!$this->validateRequest($request)) {
            return response('Dados incorretos', 400);
        }

        try {
            Mail::to($request->input('email'), $request->input('name'))->send(new Export([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('data'),
            ]));
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return response('Erro no envio do email', 500);
        }

        return response('Email enviado com sucesso', 200);
    }

    private function validateRequest(Request $request)
    {
        if (gettype($request->input('name')) != "string") return false;
        if (gettype($request->input('email')) != "string") return false;
        if (gettype($request->input('data')) != "array") return false;
        if (count($request->input('data')) <= 0) return false;

        return true;
    }
}
