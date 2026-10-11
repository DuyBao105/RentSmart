<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    private ApiClient $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /** Trang chủ */
    public function home()
    {
        // Load simple statistics from local DB tables
        try {
            $phongCount = DB::table('phong')->count();
        } catch (\Throwable $e) {
            Log::warning('Không thể đọc bảng `phong`: ' . $e->getMessage());
            $phongCount = 0;
        }

        try {
            $danhgiaCount = DB::table('danh_gia')->count();
        } catch (\Throwable $e) {
            Log::warning('Không thể đọc bảng `danh_gia`: ' . $e->getMessage());
            $danhgiaCount = 0;
        }

        try {
            $diachiCount = DB::table('dia_chi')->count();
        } catch (\Throwable $e) {
            Log::warning('Không thể đọc bảng `dia_chi`: ' . $e->getMessage());
            $diachiCount = 0;
        }

        // Trang chủ hiển thị danh sách bài đăng giống trang "Phòng trọ" nhưng rút gọn.
        // Ưu tiên các phòng vừa được cập nhật (ngay_cap_nhat mới nhất).
        $featured = $this->loadLatestPosts();

        return view('public.home', compact('phongCount', 'danhgiaCount', 'diachiCount', 'featured'));
    }

    /**
     * Normalize images for a single post array to ensure keys 'anh' (array of urls)
     * and 'anh_dai_dien' (first url) are present and consistent with detail page.
     */
    private function normalizePostImages(array $post, bool $allowApiLookup = true): array
    {
        $normalized = [];
        $rawImages = [];

        if (!empty($post['anh'])) {
            $raw = $post['anh'];
            if (!is_array($raw)) {
                $decoded = @json_decode($raw, true);
                if (is_array($decoded)) $rawImages = $decoded;
                elseif (is_string($raw)) $rawImages = [$raw];
            } else {
                $rawImages = $raw;
            }
        }

        if (empty($rawImages) && !empty($post['anh_dai_dien'])) {
            $rawImages = [$post['anh_dai_dien']];
        }

        // Prefer the API detail endpoint first (the API returns asset('storage/...') URLs
        // which match the detail page exactly). If API doesn't provide images, then
        // fall back to reading local DB tables (anh_bai_dang / anh_bai_viet).
        if (empty($rawImages) && !empty($post['id'])) {
            $postId = intval($post['id']);
            try {
                // 1) Try API detail first
                if ($allowApiLookup) {
                    try {
                        $resp = $this->api->get("bai-dang/{$postId}");
                        Log::debug('normalizePostImages: API detail response', ['post_id' => $postId, 'response' => $resp]);
                        if (isset($resp['status']) && $resp['status'] && !empty($resp['data'])) {
                            $data = $resp['data'];
                            Log::debug('normalizePostImages: API detail data fields', ['post_id' => $postId, 'has_anh' => isset($data['anh']), 'has_anh_dai_dien' => isset($data['anh_dai_dien'])]);

                            if (!empty($data['anh'])) {
                                if (is_array($data['anh'])) $rawImages = array_merge($rawImages, $data['anh']);
                                else {
                                    $dec = @json_decode($data['anh'], true);
                                    if (is_array($dec)) $rawImages = array_merge($rawImages, $dec);
                                    elseif (is_string($data['anh'])) $rawImages[] = $data['anh'];
                                }
                            } elseif (!empty($data['anh_dai_dien'])) {
                                $rawImages[] = $data['anh_dai_dien'];
                            }

                            if (!empty($rawImages)) {
                                Log::debug('normalizePostImages: sourced images from API detail', ['post_id' => $postId, 'count' => count($rawImages), 'raw' => $rawImages]);
                            }
                        }
                    } catch (\Throwable $e) {
                        Log::debug('normalizePostImages: API bai-dang lookup failed: ' . $e->getMessage());
                    }
                }

                // 2) If API returned nothing, try DB `anh_bai_dang` / `anh_bai_viet`
                if (empty($rawImages)) {
                    try {
                        $candidates = [
                            ['table' => 'anh_bai_dang', 'col' => 'bai_dang_id'],
                            ['table' => 'anh_bai_dang', 'col' => 'bai_dang_ai'],
                            ['table' => 'anh_bai_viet', 'col' => 'bai_dang_id'],
                            ['table' => 'anh_bai_viet', 'col' => 'bai_viet_id'],
                            ['table' => 'anh_bai_dang', 'col' => 'bai_viet_id'],
                        ];

                        $urls = [];
                        $sourcedFrom = null;

                        foreach ($candidates as $c) {
                            try {
                                $table = $c['table'];
                                $col = $c['col'];
                                $res = DB::table($table)
                                    ->where($col, $postId)
                                    ->orderBy('thu_tu')
                                    ->pluck('url')
                                    ->toArray();

                                if (!empty($res)) {
                                    $urls = $res;
                                    $sourcedFrom = $table . '.' . $col;
                                    break;
                                }
                            } catch (\Throwable $_e) {
                                continue;
                            }
                        }

                        foreach ($urls as $u) {
                            if (!empty($u)) $rawImages[] = $u;
                        }

                        if (!empty($rawImages)) {
                            Log::debug('normalizePostImages: sourced images from DB', ['post_id' => $postId, 'count' => count($rawImages), 'source' => $sourcedFrom, 'raw_urls' => $urls]);
                        }
                    } catch (\Throwable $e) {
                        Log::debug('normalizePostImages: anh_bai_* lookup failed: ' . $e->getMessage());
                    }
                }

            } catch (\Throwable $e) {
                Log::debug('normalizePostImages: unexpected failure while sourcing images: ' . $e->getMessage());
            }
        }

        $apiBase = str_replace('/api', '', config('services.api.base'));

        foreach ($rawImages as $entry) {
            $url = null;
            if (is_array($entry)) {
                $url = $entry['url'] ?? $entry['path'] ?? $entry['file'] ?? null;
            } elseif (is_string($entry)) {
                $url = $entry;
            }
            if (!$url) continue;
            $url = trim((string)$url);

            if (preg_match('/^https?:\/\//i', $url)) {
                $final = $url;
            } else {
                $checkPath = ltrim($url, '/');
                if (file_exists(public_path('storage/' . $checkPath))) {
                    // file exists in this app's public/storage -> serve locally
                    $final = asset('storage/' . $checkPath);
                } else {
                    // file not in this app's public. The images for posts are stored in the API
                    // app under its public/storage/bai_dang path. Build a URL that points to
                    // the API's public storage. Handle cases like:
                    //  - 'storage/bai_dang/xxx.jpg'
                    //  - 'bai_dang/xxx.jpg' (common)
                    //  - 'public/storage/bai_dang/xxx.jpg'
                    $u = $url;
                    // also check sibling paths on disk (when API project is on the same host)
                    $foundInApiStorage = false;
                    $matchedCandidate = null;
                    $candidates = [
                        base_path('../../NhaTro/nha-tro-api/public/storage/' . $checkPath),
                        base_path('../../NhaTro/nha-tro-api/public/' . $checkPath),
                        base_path('../../nha-tro-api/public/storage/' . $checkPath),
                        base_path('../../nha-tro-api/public/' . $checkPath),
                    ];
                    foreach ($candidates as $cand) {
                        if ($cand && file_exists($cand)) {
                            $foundInApiStorage = true;
                            $matchedCandidate = $cand;
                            break;
                        }
                    }
                    // strip leading 'public/' if present
                    if (str_starts_with($u, 'public/')) {
                        $u = substr($u, strlen('public/'));
                    }
                    // if it doesn't already include 'storage/', but references bai_dang, prefix storage
                    if (!str_contains($u, 'storage/') && str_contains($u, 'bai_dang')) {
                        $u = 'storage/' . ltrim($u, '/');
                    }

                    // If we detected the file in the sibling API project's storage, prefer
                    // building a URL to the API's storage path (same result), otherwise still
                    // build the API URL (covers remote API servers).
                    if (str_starts_with($u, '/')) {
                        $final = rtrim($apiBase, '/') . $u;
                    } else {
                        $final = rtrim($apiBase, '/') . '/' . ltrim($u, '/');
                    }

                    // Log if we found a match in the sibling API storage path
                    if (!empty($matchedCandidate)) {
                        Log::debug('normalizePostImages: matched file in API project storage', ['post_id' => $postId, 'candidate' => $matchedCandidate, 'final_url' => $final]);
                    } else {
                        Log::debug('normalizePostImages: built API storage url', ['post_id' => $postId, 'final_url' => $final]);
                    }
                }
            }
            $normalized[] = $final;
        }

        if (count($normalized) === 0) {
            $normalized[] = asset('upload/room1.jpg');
        }

        $post['anh'] = $normalized;
        $post['anh_dai_dien'] = $normalized[0] ?? asset('upload/room1.jpg');

        // Debug: log final image URLs for this post to help trace why homepage images
        // might differ from detail page. Remove or lower level after debugging.
        try {
            Log::debug('normalizePostImages: final image urls', ['post_id' => $post['id'] ?? null, 'urls' => $post['anh']]);
        } catch (\Throwable $__e) {
            // ignore logging errors
        }

        return $post;
    }

    /**
     * Lấy danh sách bài đăng mới nhất theo ngay_cap_nhat (hoặc updated_at nếu thiếu)
     * để hiển thị ở trang chủ.
     */
    private function loadLatestPosts(?int $limit = 18): array
    {
        try {
            $query = DB::table('bai_dang as bd')
                ->join('phong as p', 'p.id', '=', 'bd.phong_id')
                ->join('day_tro as d', 'd.id', '=', 'p.day_tro_id')
                ->where('bd.trang_thai', 'dang')
                ->orderByDesc(DB::raw('COALESCE(bd.ngay_cap_nhat, bd.ngay_tao)'))
                ->select('bd.*', 'p.id as phong_id', 'p.dien_tich', 'p.suc_chua', 'd.dia_chi', 'd.tien_ich');

            if ($limit !== null) {
                $query->limit($limit);
            } else {
                $query->limit(18);
            }

            $posts = $query->get()
                ->map(function ($row) {
                    $asArray = (array) $row;
                    return $this->normalizePostImages($asArray, false);
                })
                ->values()
                ->toArray();

            return $posts;
        } catch (\Throwable $e) {
            Log::warning('PublicController: loadLatestPosts failed: ' . $e->getMessage());
            return [];
        }
    }

    /** Danh sách bài đăng (Frontend gọi API port 8000) */
    public function listing(Request $request)
    {
        try {
            $mode = $request->input('mode', 'search');

            if ($mode !== 'ai') {
                session()->forget(['recommendations', 'recommend_error', 'recommend_payload', 'last_action']);
                $recommendations = [];
                $recommend_error = null;
                $recommend_payload = null;
                $showRecommendationsOnly = false;
            } else {
                $recommendations = session('recommendations', []);
                $recommend_error = session('recommend_error');
                $recommend_payload = session('recommend_payload');
                $showRecommendationsOnly = !empty($recommendations);
            }
            $apiParams = $request->only('min', 'max', 'page', 'dia_chi', 'area', 'search', 'category', 'district', 'sort');
            $response = $this->api->get('bai-dang', $apiParams);

            // Tiêu đề bộ lọc thân thiện hiển thị cho người dùng
            $filterParts = [];
            if ($request->filled('category')) {
                $catLabel = match ($request->category) {
                    'sinh_vien' => 'Trọ sinh viên (Từ 1.8tr • Gần ĐH)',
                    'studio' => 'Căn hộ Studio / Mini (Full nội thất)',
                    'o_ghep' => 'Ở ghép & Tìm bạn cùng phòng (Tiết kiệm 50%)',
                    'sleepbox' => 'Sleepbox & Ký túc xá (Bao trọn điện nước)',
                    'nguyen_can' => 'Nhà nguyên căn (Nhóm bạn & Gia đình)',
                    'smart_home' => 'Phòng trọ Smart Home (Khóa vân tay AI)',
                    default => 'Danh mục: ' . $request->category,
                };
                $filterParts[] = $catLabel;
            }

            $areaValue = $request->input('dia_chi') ?: $request->input('district') ?: $request->input('area') ?: $request->input('search');
            if (!empty($areaValue)) {
                $filterParts[] = 'Khu vực: ' . $areaValue;
            }

            $minPrice = $request->input('min');
            $maxPrice = $request->input('max');
            if (!empty($minPrice) && !empty($maxPrice)) {
                $minFmt = (floatval($minPrice) % 1000000 === 0) ? (intval($minPrice) / 1000000) : number_format(floatval($minPrice) / 1000000, 1);
                $maxFmt = (floatval($maxPrice) % 1000000 === 0) ? (intval($maxPrice) / 1000000) : number_format(floatval($maxPrice) / 1000000, 1);
                $filterParts[] = 'Giá: ' . $minFmt . 'tr - ' . $maxFmt . 'tr';
            } elseif (!empty($minPrice)) {
                $minFmt = (floatval($minPrice) % 1000000 === 0) ? (intval($minPrice) / 1000000) : number_format(floatval($minPrice) / 1000000, 1);
                $filterParts[] = 'Giá từ: ' . $minFmt . ' triệu';
            } elseif (!empty($maxPrice)) {
                $maxFmt = (floatval($maxPrice) % 1000000 === 0) ? (intval($maxPrice) / 1000000) : number_format(floatval($maxPrice) / 1000000, 1);
                $filterParts[] = 'Giá dưới: ' . $maxFmt . ' triệu';
            }

            $activeFilterTitle = !empty($filterParts) ? implode(' • ', $filterParts) : null;
            // Load regions (địa chỉ) from local table to populate datalist/select in view
            try {
                $regions = DB::table('dia_chi')->select('ten_dia_chi')->orderBy('ten_dia_chi')->get()->map(function($r){
                    return is_array($r) ? $r : (array) $r;
                })->toArray();
            } catch (\Throwable $e) {
                Log::warning('Không thể đọc bảng `dia_chi` để hiển thị gợi ý khu vực: ' . $e->getMessage());
                $regions = [];
            }

            $services = $this->loadServicesForPicker();

            if (!isset($response['status']) || !$response['status']) {
                Log::warning('⚠️ API /bai-dang trả về lỗi', ['response' => $response]);
                return view('public.listing', [
                    'data' => [],
                    'meta' => null,
                    'filters' => $apiParams,
                    'activeFilterTitle' => $activeFilterTitle,
                    'error' => $response['message'] ?? 'Không thể tải danh sách bài đăng.',
                    'regions' => $regions,
                    'services' => $services,
                    'recommendations' => $recommendations,
                    'recommend_error' => $recommend_error,
                    'recommend_payload' => $recommend_payload,
                    'showRecommendationsOnly' => $showRecommendationsOnly,
                    'activeMode' => $mode,
                ]);
            }

            $rawData = $response['data'] ?? [];
            if (!is_array($rawData)) {
                $rawData = [];
            }

            $normalizedData = array_map(function ($item) {
                $asArray = is_array($item) ? $item : (array) $item;
                $needsHydration = empty($asArray['anh_dai_dien']);

                return $needsHydration ? $this->normalizePostImages($asArray) : $asArray;
            }, $rawData);

            return view('public.listing', [
                'data' => $normalizedData,
                'meta' => $response['meta'] ?? null,
                'filters' => $apiParams,
                'activeFilterTitle' => $activeFilterTitle,
                'regions' => $regions,
                'services' => $services,
                'recommendations' => $recommendations,
                'recommend_error' => $recommend_error,
                'recommend_payload' => $recommend_payload,
                'showRecommendationsOnly' => $showRecommendationsOnly,
                'activeMode' => $mode,
            ]);
        } catch (\Throwable $e) {
            Log::error('❌ Lỗi khi gọi API /bai-dang', ['error' => $e->getMessage()]);
            // still attempt to load regions even if API fails
            try {
                $regions = DB::table('dia_chi')->select('ten_dia_chi')->orderBy('ten_dia_chi')->get()->map(function($r){
                    return is_array($r) ? $r : (array) $r;
                })->toArray();
            } catch (\Throwable $__e) {
                Log::warning('Không thể đọc bảng `dia_chi`: ' . $__e->getMessage());
                $regions = [];
            }

            $services = $this->loadServicesForPicker();

            return view('public.listing', [
                'data' => [],
                'meta' => null,
                'filters' => $request->only('min', 'max', 'dia_chi', 'area'),
                'error' => 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.',
                'regions' => $regions,
                'services' => $services,
                'recommendations' => $mode === 'ai' ? session('recommendations', []) : [],
                'recommend_error' => $mode === 'ai' ? session('recommend_error') : null,
                'recommend_payload' => $mode === 'ai' ? session('recommend_payload') : null,
                'showRecommendationsOnly' => $mode === 'ai' && !empty(session('recommendations', [])),
                'activeMode' => $mode,
            ]);
        }
    }

    public function recommend(Request $request)
    {
        $validated = $request->validate([
            'budget' => ['required', 'numeric', 'min:0'],
            'area' => ['required', 'numeric', 'min:0'],
            'people' => ['nullable', 'numeric', 'min:1'],
            'strict_budget' => ['nullable'],
            'strict_location' => ['nullable'],
            'dich_vu_id' => ['nullable', 'string'],
            'dia_chi' => ['nullable', 'string'],
        ]);

        $serviceIds = array_values(array_filter(array_map(function ($value) {
            $value = trim((string) $value);
            if ($value === '' || !is_numeric($value)) {
                return null;
            }
            $intVal = (int) $value;
            return $intVal > 0 ? $intVal : null;
        }, explode(',', $validated['dich_vu_id'] ?? ''))));

        $selectedServiceNames = $serviceIds
            ? $this->getServiceNamesByIds($serviceIds)
            : [];

        $peopleCount = intval($request->input('people', 1));
        if ($peopleCount < 1) {
            $peopleCount = 1;
        }

        $strictBudget = $request->has('strict_budget') ? $request->boolean('strict_budget') : true;
        $strictLocation = $request->boolean('strict_location', false);

        $payload = [
            'budget' => (float) $validated['budget'],
            'strict_budget' => $strictBudget,
            'area' => (float) $validated['area'],
            'people' => $peopleCount,
            'dich_vu_id' => $serviceIds,
            'dich_vu' => $selectedServiceNames,
            'dia_chi' => $validated['dia_chi'] ?? null,
            'strict_location' => $strictLocation,
            'user_id' => Auth::id() ?? null,
            'limit' => 3,
        ];

        $query = $this->buildListingQuery($request, 'ai');
        $endpoint = env('AI_RECOMMEND_ENDPOINT', 'http://127.0.0.1:8002/recommend_top3');

        $recommendations = [];
        $isNoMatch = false;
        $noMatchData = null;
        $auditTrail = null;

        try {
            Log::info('🚀 Calling AI recommendation service (Dueling DQN)', [
                'endpoint' => $endpoint,
                'payload' => $payload,
            ]);

            $response = Http::timeout(4)->post($endpoint, $payload);

            if ($response->successful()) {
                $status = $response->json('status');

                if ($status === 'no_match') {
                    $isNoMatch = true;
                    $noMatchData = [
                        'message' => $response->json('message', 'Không tìm thấy phòng trọ nào đáp ứng đồng thời tất cả các tiêu chí bắt buộc.'),
                        'suggested_adjustments' => $response->json('suggested_adjustments', []),
                        'audit' => $response->json('audit', []),
                    ];
                    $auditTrail = $response->json('audit');
                    Log::info('ℹ️ AI Engine reported no match for mandatory constraints', $noMatchData);
                } else {
                    $recommendations = $this->hydrateRecommendations((array) $response->json('recommend', []));
                    $auditTrail = $response->json('audit');
                    Log::info('✅ Recommend API response nhận thành công', [
                        'count' => count($recommendations),
                        'eligible_evaluated' => $response->json('eligible_count'),
                    ]);
                }
            } else {
                Log::warning('Recommend API returned non-200 status', ['status' => $response->status()]);
            }
        } catch (\Throwable $e) {
            Log::warning('Recommend API microservice unavailable or timeout, falling back to smart database matching', [
                'error' => $e->getMessage(),
            ]);
        }

        // Nếu microservice gặp sự cố hoặc timeout (chứ không phải trạng thái no_match có chủ đích)
        if (empty($recommendations) && !$isNoMatch) {
            $fallbackResult = $this->fallbackSmartRecommend($payload);
            $recommendations = $fallbackResult['recommendations'] ?? [];
            if (empty($recommendations)) {
                $isNoMatch = true;
                $noMatchData = $fallbackResult['no_match_data'] ?? [
                    'message' => 'Không tìm thấy phòng trọ nào đáp ứng đủ yêu cầu phòng trống và ngân sách.',
                    'suggested_adjustments' => ['Nới rộng ngân sách tối đa thêm 500.000₫ - 1.000.000₫', 'Mở rộng khu vực tìm kiếm'],
                ];
            }
            Log::info('✅ Smart DB fallback executed', ['count' => count($recommendations), 'no_match' => $isNoMatch]);
        }

        session()->put('recommendations', $recommendations);
        session()->put('recommend_no_match', $isNoMatch);
        session()->put('recommend_no_match_data', $noMatchData);
        session()->put('recommend_audit', $auditTrail);
        session()->put('recommend_payload', $payload);
        session()->put('last_action', 'ai');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'no_match' => $isNoMatch,
                'no_match_data' => $noMatchData,
                'recommendations' => $recommendations,
                'audit' => $auditTrail,
                'payload' => $payload,
            ]);
        }

        return redirect()->route('listing', $query)
            ->with([
                'recommendations' => $recommendations,
                'recommend_no_match' => $isNoMatch,
                'recommend_no_match_data' => $noMatchData,
                'recommend_audit' => $auditTrail,
                'recommend_error' => null,
                'recommend_payload' => $payload,
            ])
            ->withInput($request->only('budget', 'area', 'people', 'strict_budget', 'strict_location', 'dich_vu_id', 'dia_chi'));
    }

    private function fallbackSmartRecommend(array $payload): array
    {
        $budget = floatval($payload['budget'] ?? 3500000);
        $strictBudget = !empty($payload['strict_budget']);
        $targetArea = floatval($payload['area'] ?? 22.0);
        $people = intval($payload['people'] ?? 1);
        $location = trim((string)($payload['dia_chi'] ?? ''));
        $strictLocation = !empty($payload['strict_location']);

        try {
            $query = DB::table('bai_dang as bd')
                ->join('phong as p', 'p.id', '=', 'bd.phong_id')
                ->join('day_tro as d', 'd.id', '=', 'p.day_tro_id')
                ->join('nguoi_dung as nd', 'nd.id', '=', 'd.chu_tro_id')
                ->where('bd.trang_thai', 'dang')
                ->where('p.trang_thai', 'trong') // Ràng buộc cứng: chỉ phòng trống
                ->where('p.suc_chua', '>=', $people); // Ràng buộc cứng: đủ sức chứa

            // Ràng buộc ngân sách
            if ($strictBudget) {
                $query->where('bd.gia_niem_yet', '<=', $budget);
            } else {
                $query->where('bd.gia_niem_yet', '<=', $budget * 1.15);
            }

            // Ràng buộc khu vực
            if (!empty($location)) {
                if ($strictLocation) {
                    $query->where(function($q) use ($location) {
                        $q->where('d.dia_chi', 'like', "%{$location}%")
                          ->orWhere('bd.tieu_de', 'like', "%{$location}%");
                    });
                } else {
                    // Ưu tiên khớp khu vực nếu có
                    $query->orderByRaw("CASE WHEN d.dia_chi LIKE ? THEN 0 ELSE 1 END", ["%{$location}%"]);
                }
            }

            $query->select([
                'bd.id',
                'bd.tieu_de',
                'bd.gia_niem_yet',
                'p.dien_tich',
                'p.suc_chua',
                'p.so_phong',
                'p.tang',
                'd.ten_day_tro',
                'd.dia_chi',
                'd.tien_ich',
                'nd.ho_ten as chu_tro',
                'nd.so_dien_thoai as sdt_chu_tro'
            ]);

            $candidates = $query->limit(30)->get();

            // Nếu 0 phòng thỏa mãn ràng buộc cứng:
            if ($candidates->isEmpty()) {
                return [
                    'recommendations' => [],
                    'no_match_data' => [
                        'message' => 'Không tìm thấy phòng trọ nào đáp ứng đồng thời ngân sách ≤ ' . number_format($budget, 0, ',', '.') . '₫ và sức chứa ≥ ' . $people . ' người.',
                        'suggested_adjustments' => [
                            'Tăng ngân sách tối đa thêm 500.000₫ – 1.000.000₫ để mở rộng phạm vi lựa chọn',
                            'Bỏ chọn giới hạn ngân sách nghiêm ngặt để tìm thêm các phòng có giá chênh lệch nhẹ',
                            'Mở rộng tìm kiếm sang các quận lân cận'
                        ],
                    ]
                ];
            }

            $scored = $candidates->map(function($c, $idx) use ($budget, $targetArea, $location, $people) {
                // Điểm giá (35%)
                if ($c->gia_niem_yet <= $budget) {
                    $savings = ($budget - $c->gia_niem_yet) / max(1, $budget);
                    $priceScore = min(100.0, 95.0 + $savings * 10.0);
                } else {
                    $over = ($c->gia_niem_yet - $budget) / max(1, $budget);
                    $priceScore = max(0.0, 90.0 - $over * 180.0);
                }

                // Điểm diện tích (25%)
                $areaDiff = abs($c->dien_tich - $targetArea) / max(1, $targetArea);
                $areaScore = max(0.0, 100.0 - ($areaDiff * 100.0));

                // Điểm vị trí (15%)
                $locScore = (!empty($location) && (str_contains(mb_strtolower($c->dia_chi), mb_strtolower($location)) || str_contains(mb_strtolower($c->tieu_de), mb_strtolower($location))))
                    ? 100.0 : 75.0;

                // Điểm tiện ích mặc định (25%)
                $utilScore = 90.0;

                $totalScore = round((0.35 * $priceScore) + (0.25 * $areaScore) + (0.25 * $utilScore) + (0.15 * $locScore), 1);

                $factualMatches = [
                    'Phòng đang trống sẵn sàng nhận phòng ngay',
                    'Sức chứa ' . ($c->suc_chua ?? 2) . ' người (đáp ứng đủ ' . $people . ' người ở)',
                ];
                if ($c->gia_niem_yet <= $budget) {
                    $factualMatches[] = 'Giá ' . number_format($c->gia_niem_yet, 0, ',', '.') . '₫ nằm trong ngân sách (tiết kiệm ' . number_format($budget - $c->gia_niem_yet, 0, ',', '.') . '₫/tháng)';
                } else {
                    $factualMatches[] = 'Giá ' . number_format($c->gia_niem_yet, 0, ',', '.') . '₫/tháng';
                }

                $prefMatches = [];
                if (!empty($location) && str_contains(mb_strtolower($c->dia_chi), mb_strtolower($location))) {
                    $prefMatches[] = 'Đúng khu vực ' . $location;
                } else {
                    $prefMatches[] = 'Khu vực an ninh, kết nối thuận tiện';
                }
                $prefMatches[] = 'Diện tích ' . $c->dien_tich . 'm² thoáng mát';

                $tradeOffs = [];
                if ($c->gia_niem_yet > $budget) {
                    $tradeOffs[] = 'Vượt nhẹ ngân sách ' . number_format($c->gia_niem_yet - $budget, 0, ',', '.') . '₫/tháng';
                }

                $item = (array)$c;
                $item = $this->normalizePostImages($item);
                $item['satisfaction_score'] = $totalScore;
                $item['ranking_rank'] = $idx + 1;
                $item['ai_reasons'] = array_merge(array_slice($factualMatches, 0, 2), array_slice($prefMatches, 0, 2));
                $item['explanations'] = [
                    'factual_matches' => $factualMatches,
                    'preference_matches' => $prefMatches,
                    'trade_offs' => $tradeOffs,
                    'summary' => 'Phòng phù hợp tiêu chuẩn sức chứa, giá thuê và đang trống sẵn sàng nhận phòng.',
                ];
                $item['constraint_status'] = 'Đáp ứng 100% tiêu chí bắt buộc';

                return [
                    'item' => $item,
                    'score' => $totalScore
                ];
            })->sortByDesc('score')->take(3)->pluck('item')->values()->toArray();

            return [
                'recommendations' => $scored,
                'no_match_data' => null,
            ];
        } catch (\Throwable $e) {
            Log::error('Smart fallback error: ' . $e->getMessage());
            return [
                'recommendations' => [],
                'no_match_data' => null
            ];
        }
    }

    private function buildListingQuery(Request $request, ?string $modeOverride = null): array
    {
        $query = [
            'dia_chi' => $request->input('dia_chi'),
            'min' => $request->input('min'),
            'max' => $request->input('max'),
            'area' => $request->input('area'),
            'dich_vu_id' => $request->input('dich_vu_id'),
            'sort' => $request->input('sort'),
            'filters' => $request->input('filters', []),
            'page' => $request->input('page'),
            'mode' => $modeOverride ?? $request->input('mode'),
        ];

        return array_filter($query, function ($value) {
            if (is_array($value)) {
                return count(array_filter($value, fn($v) => $v !== null && $v !== '')) > 0;
            }

            return $value !== null && $value !== '';
        });
    }

    private function loadServicesForPicker(): array
    {
        try {
            $nameColumn = Schema::hasColumn('dich_vu', 'ten_dich_vu') ? 'ten_dich_vu' : 'ten';
            $priceColumn = Schema::hasColumn('dich_vu', 'gia') ? 'gia' : 'don_gia';

            return DB::table('dich_vu')
                ->select(
                    'id',
                    DB::raw($nameColumn . ' as ten_hien_thi'),
                    DB::raw($priceColumn . ' as gia_hien_thi'),
                    'don_vi',
                    'ma'
                )
                ->orderBy($nameColumn)
                ->get()
                ->map(function ($service) {
                    return is_array($service) ? $service : (array) $service;
                })
                ->toArray();
        } catch (\Throwable $e) {
            Log::warning('Không thể đọc bảng `dich_vu` để hiển thị gợi ý dịch vụ: ' . $e->getMessage());
            return [];
        }
    }

    private function getServiceNamesByIds(array $serviceIds): array
    {
        if (empty($serviceIds)) {
            return [];
        }

        try {
            $nameColumn = Schema::hasColumn('dich_vu', 'ten_dich_vu') ? 'ten_dich_vu' : 'ten';

            return DB::table('dich_vu')
                ->whereIn('id', $serviceIds)
                ->pluck($nameColumn)
                ->filter()
                ->map(function ($name) {
                    return trim((string) $name);
                })
                ->values()
                ->toArray();
        } catch (\Throwable $e) {
            Log::warning('Không thể load danh sách dịch vụ đã chọn: ' . $e->getMessage());
            return [];
        }
    }

    private function hydrateRecommendations(array $recommendations): array
    {
        $hydrated = [];

        foreach ($recommendations as $idx => $rec) {
            if (!is_array($rec)) continue;

            // AI trả về post_id hoặc id
            $postId = $rec['id'] ?? $rec['bai_dang_id'] ?? null;
            $rank = $rec['ranking_rank'] ?? ($idx + 1);

            if ($postId) {
                try {
                    $detail = $this->api->get("bai-dang/$postId");

                    if (!empty($detail['data'])) {
                        $detailData = is_array($detail['data']) ? $detail['data'] : (array) $detail['data'];
                        $normalized = $this->normalizePostImages($detailData);
                        $normalized['satisfaction_score'] = $rec['satisfaction_score'] ?? 95.0;
                        $normalized['ai_reasons'] = $rec['ai_reasons'] ?? [];
                        $normalized['explanations'] = $rec['explanations'] ?? null;
                        $normalized['q_value'] = $rec['q_value'] ?? null;
                        $normalized['ranking_rank'] = $rank;
                        $normalized['constraint_status'] = $rec['constraint_status'] ?? 'Đáp ứng 100% tiêu chí bắt buộc';
                        $hydrated[] = $normalized;
                        continue;
                    }
                } catch (\Throwable $e) {
                    Log::warning("Không load được bài đăng $postId từ API", ['error' => $e->getMessage()]);
                }
            }

            // fallback
            $fallback = [
                'id' => $postId,
                'tieu_de' => $rec['tieu_de'] ?? 'Phòng gợi ý',
                'dia_chi' => $rec['dia_chi'] ?? null,
                'gia_niem_yet' => $rec['gia'] ?? null,
                'dien_tich' => $rec['dien_tich'] ?? null,
                'suc_chua' => $rec['suc_chua'] ?? 2,
                'tang' => $rec['tang'] ?? null,
                'ten_day_tro' => $rec['ten_day_tro'] ?? null,
                'tien_ich' => $rec['tien_ich'] ?? null,
                'satisfaction_score' => $rec['satisfaction_score'] ?? 92.0,
                'ai_reasons' => $rec['ai_reasons'] ?? [],
                'explanations' => $rec['explanations'] ?? null,
                'q_value' => $rec['q_value'] ?? null,
                'ranking_rank' => $rank,
                'constraint_status' => $rec['constraint_status'] ?? 'Đáp ứng 100% tiêu chí bắt buộc',
                'anh_dai_dien' => asset("upload/room1.jpg"),
            ];

            $hydrated[] = $this->normalizePostImages($fallback, false);
        }

        return array_slice($hydrated, 0, 3);
    }


    /**Chi tiết bài đăng */
    public function detail($id)
    {
        try {
            $response = $this->api->get("bai-dang/{$id}");

            if (!isset($response['status']) || !$response['status']) {
                Log::warning("⚠️ Bài đăng không tồn tại hoặc đã bị ẩn (ID={$id})", ['response' => $response]);
                abort(404, $response['message'] ?? 'Không tìm thấy bài đăng này.');
            }

            $item = $response['data'] ?? null;

            if (!$item) {
                abort(404, 'Không tìm thấy dữ liệu bài đăng.');
            }
            // Tải danh sách phòng trọ tương tự để hiển thị gợi ý
            $similarPosts = [];
            try {
                $allPosts = $this->loadLatestPosts(8);
                $similarPosts = array_values(array_filter($allPosts, function($p) use ($id) {
                    return !empty($p['id']) && $p['id'] != $id;
                }));
                $similarPosts = array_slice($similarPosts, 0, 4);
            } catch (\Throwable $ex) {
                Log::debug('load similar posts error: ' . $ex->getMessage());
            }

            return view('public.detail', compact('item', 'similarPosts'));
        } catch (\Throwable $e) {
            Log::error("❌ Lỗi khi gọi API /bai-dang/{$id}", ['error' => $e->getMessage()]);
            abort(500, 'Có lỗi xảy ra khi tải thông tin bài đăng.');
        }
    }
}
