<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\ServiceException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/products';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        //获取邀请码
        $invitCode = null;
        $uri = explode('?', $request->getRequestUri());

        if (count($uri) > 1) {
            $invitCode = array_pop($uri);
        }
        redirect()->setIntendedUrl(url()->previous());

        return view('auth.register',['inviteCode'=>$invitCode]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => 'required|string|string|size:11|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $inviteCode = md5(uniqid(microtime(true), true));

        $level = 0;

//        dd($data);
        if (!empty($data['invitationCode'])) {
            $parent = User::where('invitation_code', $data['invitationCode'])->first();

            if (!$parent) {
                throw new ServiceException('邀请码查询失败', 404);
            }


            $level = $parent->level_relation ? $parent->level_relation . '_' . $parent->id : $parent->id;

            //目前二级用户不能邀请新人
            $inviteCode = '';
        }

        return User::create([
            'phone' => $data['phone'],
            'invitation_code' => $inviteCode,
            'level_relation' => $level,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        flash(__('A fresh verification link has been sent to your email address.'))->info()->important();

        return redirect()->intended($this->redirectTo);
    }
}
