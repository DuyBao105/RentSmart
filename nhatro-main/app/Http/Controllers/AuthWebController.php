<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    protected ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    // =======================
    // 🧩 HIỂN THỊ FORM LOGIN
    // =======================
    public function showLogin(Request $request)
    {
        if ($request->has('google_error')) {
            $raw = $request->query('google_error');
            $msg = base64_decode($raw, true) ?: $raw;
            session()->flash('error', 'Lỗi đăng nhập Google: ' . $msg);
        }

        return view('auth.login');
    }

    // =======================
    // XỬ LÝ ĐĂNG NHẬP
    // =======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required|string|min:3',
        ]);

        $apiUrl = rtrim(config('services.api.base'), '/');
        $response = null;

        try {
            $response = Http::timeout(3)
                ->post("$apiUrl/auth/login", $credentials)
                ->json();
        } catch (\Throwable $e) {
            Log::info('API /auth/login không khả dụng, chuyển sang xác thực cơ sở dữ liệu: ' . $e->getMessage());
        }

        // Nếu API trả về token thành công
        if (!empty($response['token'])) {
            $token = $response['token'];
            session([
                'api_token' => $token,
                'js_token' => $token,
            ]);
            session()->save();

            try {
                $profile = Http::withToken($token)->timeout(4)->get("$apiUrl/me")->json();
                if (is_array($profile) && !empty($profile)) {
                    if (empty($profile['anh_dai_dien'])) {
                        $profile['anh_dai_dien'] = '/images/default-avatar.png';
                    }
                    session([
                        'user' => $profile,
                        'admin_user' => ($profile['vai_tro'] ?? '') === 'quan_tri' ? $profile : null,
                        'avatar_bust' => time(),
                    ]);
                    $role = $profile['vai_tro'] ?? 'nguoi_dung';
                    return $this->redirectAfterLogin($role);
                }
            } catch (\Throwable $e) {
                Log::debug('Không lấy được profile từ API, fallback DB');
            }
        }

        // 🛡️ Fallback xác thực trực tiếp qua Database (TiDB Cloud)
        $user = DB::table('nguoi_dung')->where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại trong hệ thống!')->withInput();
        }

        // Kiểm tra mật khẩu (hỗ trợ cả plain text trim và Hash::check)
        $matched = (trim($user->mat_khau) === trim($credentials['mat_khau'])) 
                   || Hash::check($credentials['mat_khau'], $user->mat_khau);

        if (!$matched) {
            return back()->with('error', 'Sai mật khẩu!')->withInput();
        }

        if (($user->trang_thai ?? null) !== 'hoat_dong') {
            return back()->with('error', 'Tài khoản chưa được kích hoạt hoặc đã bị khóa!')->withInput();
        }

        $profile = [
            'id' => $user->id,
            'ho_ten' => $user->ho_ten,
            'email' => $user->email,
            'so_dien_thoai' => $user->so_dien_thoai,
            'vai_tro' => $user->vai_tro,
            'anh_dai_dien' => $user->anh_dai_dien ?: '/images/default-avatar.png',
        ];

        session([
            'api_token' => 'local_' . $user->id,
            'js_token' => 'local_' . $user->id,
            'user' => $profile,
            'admin_user' => ($user->vai_tro === 'quan_tri') ? $profile : null,
            'avatar_bust' => time(),
        ]);
        session()->save();

        return $this->redirectAfterLogin($user->vai_tro);
    }

    private function redirectAfterLogin(string $role)
    {
        $messages = [
            'quan_tri' => '👑 Chào mừng Quản trị viên!',
            'chu_tro' => '🏠 Xin chào Chủ trọ!',
            'khach_thue' => '🎉 Chào mừng bạn trở lại!',
            'nguoi_dung' => '🎉 Đăng nhập thành công!',
        ];

        if ($role === 'quan_tri') {
            return redirect()->route('admin.dashboard')->with('ok', $messages['quan_tri']);
        }
        if ($role === 'chu_tro') {
            return redirect()->route('chu-tro.dashboard')->with('ok', $messages['chu_tro']);
        }

        return redirect('/')->with('ok', $messages[$role] ?? $messages['nguoi_dung']);
    }


    // =======================
    // 🚪 ĐĂNG XUẤT
    // =======================
    public function logout(Request $request)
    {
        try {
            if (session('api_token')) {
                $this->api->setToken(session('api_token'));
                $this->api->post('auth/logout');
            }
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi khi logout API', ['error' => $e->getMessage()]);
        }

        session()->flush();
        Cookie::queue(Cookie::forget('api_token'));
        echo "<script>localStorage.removeItem('token');</script>";
        return redirect('/')->with('ok', 'Đã đăng xuất!');
    }

    // ======================
    // FORM ĐĂNG KÝ
    // =======================
    public function showRegister()
    {
        return view('auth.register');
    }

    // =======================
    // XỬ LÝ ĐĂNG KÝ
    // =======================
    public function register(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            // 'cccd' => $request->input('role') === 'khach_thue'
            // ? 'required|string|max:20'
            //: 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:khach_thue,chu_tro,quan_tri',
        ]);

        $payload = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            //'cccd' => $data['cccd'] ?? null,
            'password' => $data['password'],
            'password_confirmation' => $request->input('password_confirmation'),
            'role' => $data['role'],
        ];

        $apiUrl = rtrim(config('services.api.base'), '/');

        try {
            $response = Http::timeout(10)->post("$apiUrl/auth/register", $payload);

            if ($response->failed()) {
                $msg = $response->json('message') ?? 'Lỗi không xác định từ API.';
                return back()->with('error', '❌ Đăng ký thất bại: ' . $msg)->withInput();
            }

            return redirect('/login')->with('ok', '🎉 Đăng ký thành công! Hãy đăng nhập.');

        } catch (\Throwable $e) {
            return back()->with('error', '⚠️ Không thể kết nối API: ' . $e->getMessage())->withInput();
        }
    }
}
