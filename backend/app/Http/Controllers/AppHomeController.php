<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Config\Response;
use App\Models\AppUser;
use Illuminate\Http\Request;

class AppHomeController extends Controller
{
    public function index()
    {
      return Response::success('HELLO ADMIN');
    }

    public function profile(Request $req, $id)
    {
      // $id = $req->header()['au-id'];
      $appUser = AppUser::where('au_id', $id)->first();

      if(!$appUser) {
        return Response::error('UserNotFound', 404);
      } else {
        $token = explode(' ', $req->header('Authorization'));

        if($appUser->au_token == $token[1]){
          return Response::successWithData('Success', $appUser);
        } else{
          return Response::error('Not Allow');
        }
      }
    }
}
