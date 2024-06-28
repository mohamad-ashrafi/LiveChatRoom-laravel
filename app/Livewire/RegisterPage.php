<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('ورود به چت آنلاین')]
class RegisterPage extends Component
{
    use WithFileUploads;

    /** Login form fields */
    public string $login_user_name = '';
    public string $login_password = '';
    /** Registration form fields */
    public string $register_user_name = '';
    public string $email = '';
    public string $register_password = '';
    public $avatar = null;
    public ?string $customErrorMessage = null;

//    protected array $rules = [
//        'login_user_name' => ['required', 'string', 'min:3', 'max:20'],
//        'login_password' => ['required', 'string', 'min:6', 'max:20'],
//        'register_user_name' => ['required', 'string', 'min:3', 'max:20'],
//        'email' => ['required', 'email', 'max:30'],
//        'register_password' => ['required', 'string', 'min:6', 'max:20'],
//        'avatar' => ['image', 'max:1024'],
//    ];

    public function submitLogin()
    {
        $this->validate([
            'login_user_name' => 'required|string|min:3|max:20',
            'login_password' => 'required|string|min:6|max:20',
        ]);


        $user = User::where('user_name', $this->login_user_name)->first();

        if ($user && Hash::check($this->login_password, $user->password)) {
            auth()->login($user);
            return redirect()->route('lobby');
        } else {
            $this->customErrorMessage = 'نام کاربری یا کلمه عبور اشتباه است';
        }
    }


    public function submitRegister()
    {
        $this->validate([
            'register_user_name' => 'required|string|min:3|max:20',
            'email' => 'required|email|max:30',
            'register_password' => 'required|string|min:6|max:20',
            'avatar' => 'nullable|image|max:1024',
        ]);
        try {
        //$path = $this->avatar->store('avatars', 'public');
         $image_filename = null;
        if ($this->avatar) {
            $image_path = $this->avatar;
            $image_filename =   uniqid() . '.' . $image_path->getClientOriginalExtension();
            $image_path->storeAs('public', $image_filename);
        }else{
            $image_filename = 'login.png';
        }
        $user = User::create([
            'user_name' => $this->register_user_name,
            'email' => $this->email,
            'password' => Hash::make($this->register_password),
            'avatar' => $image_filename,
        ]);

        auth()->login($user);

        return redirect()->route('lobby');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Error code for duplicate entry
                $this->customErrorMessage = 'این ایمیل قبلاً ثبت شده است';
            } else {
                $this->customErrorMessage = 'خطایی رخ داده است، لطفاً دوباره تلاش کنید';
            }
        }
    }

    public function render()
    {
        return view('livewire.register-page');
    }
}
