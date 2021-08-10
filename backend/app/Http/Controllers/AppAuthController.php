<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Config\Response;

use App\Models\AppUser;
use App\Models\Mailer;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AppAuthController extends Controller
{
    
    public function login(Request $req)
    {
        $validation = $this->validate($req, [
            'au_email' => 'required|email',
            'au_password' => 'required'
        ]);

        $email = $req->input('au_email');
        $password = $req->input('au_password');

        $data = AppUser::where('au_email', $email)->first();

        if (!$data) {
            return Response::error('Unauthorized', 401);
        } else {
            if (Hash::check($password, $data->au_password)) {
                $token = sha1(time());
                $createToken = $data->where('au_id', $data->au_id)->update([
                    'au_token' => $token,
                    'au_expired' => date("Y-m-d", strtotime("+12 month")),
                ]);

                if ($createToken) {
                    $res = [
                        'user' => $data,
                        'token' => $token,
                        'expires_in' => time() * 60,
                    ];
                    
                    return Response::successWithData('Authorized', $res);
                }
            } else {
                return Response::error('Unauthorized', 401);
            }
        }
    }

    public function forgotPassword(Request $req)
    {
        $this->validate($req, [
            'au_email' => 'required|email'
        ]);

        function random($length = 5)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $email = $req->input('au_email');
        $string = random();

        AppUser::where('au_email', $email)->update([
            'au_2fa' => $string
        ]);

        $data = Appuser::where('au_email', $email)->first();

        Mailer::sendEmail($email, $string, "http://localhost:8080/auth/resetPassword");

        return Response::successWithData("SUCCESS", $data['au_email']);
    }

    public function checkCodeOtp(Request $req){
        $this->validate($req, [
            'au_email' => 'required|email',
            'au_2fa' => 'required'
        ]);

        $email = $req->input('au_email');
        $code = $req->input('au_2fa');

        $appUser = AppUser::where('au_email', $email)->first();

        if($code == $appUser->au_2fa)
        {
            return Response::successWithData("SUCCESS", $appUser->au_email);
        } else{
            return Response::error("Code Tidak Valid");
        }
    }
    
    public function resetPassword(Request $req)
    {
        $this->validate($req, [
            'au_email' => 'required|email',
            'au_password' => 'required'
        ]);

        $email = $req->input('au_email');
        $newPassword = $req->input('au_password');

        AppUser::where('au_email', $email)->update([
            'au_password' => Hash::make($newPassword)
        ]);

        AppUser::where('au_email', $email)->update([
            'au_2fa' => null
        ]);

        return Response::success("SUCCESS");
    }

    public function logout(Request $req)
    {
        $id = $req->input('au_id');
        
        $appUser = AppUser::where('au_id', $id)->first();

        if(!$appUser) {
            return Response::error('UserNotFound', 404);
        } else {
            $token = explode(' ', $req->header('Authorization'));

            if($appUser->au_token == $token[1]){
                AppUser::findOrFail($id)->update([
                    'au_token' => null,
                    'au_expired' => null,
                ]);
        
                return Response::success('Logout Successfully');
            } else{
                return Response::error('Not Allow');
            }
        }
    }
}
