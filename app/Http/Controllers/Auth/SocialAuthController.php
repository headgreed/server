<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use App\SocialAccount;
use App\User;
use GuzzleHttp\Client;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function callback()
    {
        $data = Socialite::driver('facebook')->user();

        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($data->id)
            ->first();

        if ($account) {
            $user = $account->user;
        }
        else {
            $account = new SocialAccount([
               'provider' => 'facebook',
               'provider_user_id' => $data->id,
               'avatar_url' => $data->avatar,
               'avatar_original' => $data->avatar_original,
               'profileUrl' => $data->profileUrl
            ]);

            $user = User::whereEmail($data->email)->first();

            if (!$user) {
                $file = file_get_contents($data->avatar);
                $new_name = uniqid().".jpg";
                $new_path = storage_path("app/public/avatar/{$new_name}");
                file_put_contents($new_path, $file);

                $user = User::create([
                    'slug' => uniqid(),
                    'ori_name' => $data->name,
                    'name' => $data->name,
                    'email' => $data->email,
                    'gender' => $data->user['gender'],
                    'avatar' => $new_name,
                    'api_token' => str_random(60)
                ]);
            }

            $account->user()->associate($user);
            $account->save();
        }

        auth()->login($user);
        return redirect('/home#');
    }
}
