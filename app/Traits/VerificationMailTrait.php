<?php

namespace App\Traits;

use Exception;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait VerificationMailTrait
{
    public function SendMail($userEmail = NULL)
    {
        if ($userEmail == NULL)
        {
            return false;
        }

        $queryResult = DB::select("SELECT `id`, `name`, `created_at`, `email_verified_at` FROM `users` WHERE `email` = ?", [$userEmail]);
        
        if (empty($queryResult))
        {
            return false;
        }

        if ($queryResult[0]->email_verified_at != NULL)
        {
            return $queryResult[0]->email_verified_at;
        }

        $activationToken = md5($userEmail . $queryResult[0]->created_at);
        
        $data = array(
            "username" => $queryResult[0]->name,
            "hash" => $activationToken,
            "id" => $queryResult[0]->id
        );

        $correo = new VerificationMail($data);

        try
        {
            Mail::to($userEmail)->send($correo);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function emailValidated($userId = NULL)
    {
        if ($userId == NULL)
        {
            return false;
        }

        $queryResult = DB::select("SELECT `email_verified_at` FROM `users` WHERE `id` = ?", [$userId]);

        if (empty($queryResult))
        {
            return false;
        }

        if ($queryResult[0]->email_verified_at != NULL)
        {
            return true;
        }

        return false;
    }
}
