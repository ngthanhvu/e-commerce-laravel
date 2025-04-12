<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Carts;
use App\Mail\RegistrationSuccess;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOtp;

class UserController extends Controller
{
    public function index()
    {
        $title = "Quản lý người dùng";
        $search = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->paginate($perPage)->appends(['search' => $search, 'per_page' => $perPage]);
        return view('admin.users.index', compact('title', 'users', 'search', 'perPage'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đa tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khâu phải nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng nhập lây mật khâu',
            'confirm_password.same' => 'Mật khâu khác nhau',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Mail::to($user->email)->send(new RegistrationSuccess($user));
        return redirect('/dang-nhap')->with('success', 'Đăng ký thành công');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khâu',
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        $oldSessionId = session()->getId();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $userId = Auth::id();

            Carts::where('session_id', $oldSessionId)
                ->whereNull('user_id')
                ->update(['user_id' => $userId]);
            return redirect('/')->with('success', 'Đăng nhập thành công');
        } else {
            return back()->withInput()->with('error', 'Email hoặc mật khâu không đúng');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/dang-nhap');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Người dùng đã được cập nhật!');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $oldSessionId = session()->getId();
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => null,
                    'oauth_provider' => 'google',
                    'oauth_id' => $googleUser->getId(),
                ]
            );

            Auth::login($user);

            $userId = $user->id;
            Carts::where('session_id', $oldSessionId)
                ->whereNull('user_id')
                ->update(['user_id' => $userId]);

            return redirect()->route('home')->with('success', 'Đăng nhập Google thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi đăng nhập Google: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('dang-nhap')->with('error', 'Đăng nhập Google thất bại.');
        }
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $oldSessionId = session()->getId();
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::updateOrCreate(
                ['email' => $facebookUser->getEmail()],
                [
                    'name' => $facebookUser->getName(),
                    'password' => null,
                    'oauth_provider' => 'facebook',
                    'oauth_id' => $facebookUser->getId(),
                ]
            );

            Auth::login($user);

            $userId = $user->id;
            Carts::where('session_id', $oldSessionId)
                ->whereNull('user_id')
                ->update(['user_id' => $userId]);

            return redirect()->route('home')->with('success', 'Đăng nhập Facebook thành công!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Đăng nhập Facebook thất bại.');
        }
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại trong hệ thống',
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        session(['email' => $user->email]);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Mail::raw("Mã OTP của bạn là: $otp. Mã này có hiệu lực trong 10 phút.", function ($message) use ($user) {
        //     $message->to($user->email)
        //         ->subject('Mã OTP đặt lại mật khẩu');
        // });

        Mail::to($user->email)->send(new SendOtp($user));

        return redirect()->route('reset.password')->with('success', 'Mã OTP đã được gửi đến email của bạn!');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại trong hệ thống',
            'otp.required' => 'Vui lòng nhập mã OTP',
            'otp.size' => 'Mã OTP phải có đúng 6 số',
            'otp.*.required' => 'Vui lòng nhập đầy đủ 6 số OTP',
            'otp.*.digits' => 'Mỗi ô OTP phải là 1 số',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $otp = implode('', $request->input('otp'));

        $user = User::where('email', $request->email)->first();

        if ($user->otp !== $otp || now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'Mã OTP không hợp lệ hoặc đã hết hạn!');
        }

        $user->update([
            'password' => bcrypt($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect('/dang-nhap')->with('success', 'Mật khẩu đã được đặt lại thành công!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'old_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = Auth::user();

        if (!$user || !Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không chính xác.');
        }

        if ($user instanceof User) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
        } else {
            return back()->with('error', 'Không thể cập nhật mật khẩu. Người dùng không hợp lệ.');
        }

        return back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
