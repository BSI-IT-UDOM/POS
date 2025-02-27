<?php



namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\LoginInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'sys_name';
    }

    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['status' => 'Active']
        );
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where($this->username(), $request->{$this->username()})->first();

        if ($user && $user->status === 'Inactive') {
            throw ValidationException::withMessages([
                $this->username() => ['Your account is inactive. Please contact support.'],
            ]);
        }

        if (Auth::attempt($this->credentials($request))) {
            $this->storeLoginInfo($user, $request);
            return true;
        }

        return false;
    }

    /**
     * Store login information in the database.
     *
     * @param User $user
     * @param Request $request
     */
    protected function storeLoginInfo($user, $request)
    {
        $loginInfo = new LoginInfo();
        $loginInfo->U_id = $user->U_id;
        $loginInfo->public_ip = $request->ip();
        $loginInfo->mac_add = $this->getMacAddress();
        $loginInfo->login_datetime = now();
        $loginInfo->save();
    }

    /**
     * Retrieve the MAC address of the user (example implementation).
     * Note: This may require a custom approach based on your environment.
     */
    protected function getMacAddress()
    {
        return exec('getmac'); // For demonstration, ensure this suits your environment
    }
}
