import 'dart:async';
import 'dart:convert';
import 'dart:io'; 
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:google_sign_in/google_sign_in.dart';
import '../models/ContractModel.dart';
class ApiService {
  ApiService._private();
  static final ApiService instance = ApiService._private();

  final GoogleSignIn _googleSignIn = GoogleSignIn(
    scopes: ['email', 'profile'],
    serverClientId: '465867292342-cugk82a72s4fh51qcho0q4sjertm5r10.apps.googleusercontent.com',
  );

  // ================= GOOGLE LOGIN =================
  Future<String> loginWithGoogle() async {
    try {
      await _googleSignIn.disconnect();
      await _googleSignIn.signOut();
    } catch (_) {}

    final googleUser = await _googleSignIn.signIn();
    if (googleUser == null) throw Exception('Người dùng đã hủy đăng nhập Google');

    final googleAuth = await googleUser.authentication;
    final idToken = googleAuth.idToken;

    if (idToken == null) throw Exception('Không lấy được id_token từ Google');

    final uri = Uri.parse('$baseUrl/api/auth/google/mobile-login');

    final response = await http.post(
      uri,
      headers: {'Accept': 'application/json'},
      body: {'id_token': idToken},
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final token = data['token'];
      final user = data['user'];

      _currentEmail = user?['email'];
      if (_currentEmail != null) {
        _roles[_currentEmail!] = 'khach_thue';
      }

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);
      if (_currentEmail != null) await prefs.setString('email', _currentEmail!);

      return token;
    } else {
      throw Exception(data['message'] ?? 'Đăng nhập Google thất bại');
    }
  }

  final String baseUrl = 'http://10.0.2.2:8000';

  final Map<String, String> _mockUsers = {
    'cuong01062004@gmail.com': '123456',
    'owner@example.com': 'owner123',
  };

  final Map<String, String> _roles = {
    'cuong01062004@gmail.com': 'tenant',
    'owner@example.com': 'owner',
  };

  final List<Map<String, dynamic>> _rooms = [
    {
      'id': 'A1',
      'name': 'Phòng A1',
      'tenant': 'cuong01062004@gmail.com',
      'prev_elec': 120,
      'prev_water': 15,
      'fixed_rent': 2500000
    },
    {
      'id': 'A2',
      'name': 'Phòng A2',
      'tenant': null,
      'prev_elec': 0,
      'prev_water': 0,
      'fixed_rent': 2000000
    },
    {
      'id': 'B1',
      'name': 'Phòng B1',
      'tenant': null,
      'prev_elec': 0,
      'prev_water': 0,
      'fixed_rent': 2000000
    },
  ];

  String? _currentEmail;

  // Lấy thông tin profile
  Future<Map<String, dynamic>> getProfile() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/profile');
    final headers = await _authHeaders();

    final res = await http.get(uri, headers: headers);
    final data = jsonDecode(res.body);

    if (res.statusCode != 200) {
      throw Exception(data['message'] ?? 'Không lấy được thông tin hồ sơ');
    }

    return Map<String, dynamic>.from(data);
  }

  // Cập nhật profile
  Future<void> updateProfile({
  required String hoTen,
  required String email,
  required String sdt,
  File? avatarFile, 
  }) async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/profile');
    final headers = await _authHeaders();

    final request = http.MultipartRequest('POST', uri)
      ..headers.addAll(headers)
      ..fields['ho_ten'] = hoTen
      ..fields['email'] = email
      ..fields['so_dien_thoai'] = sdt;

    if (avatarFile != null) {
      request.files.add(
        await http.MultipartFile.fromPath('anh_dai_dien', avatarFile.path),
      );
    }

    final streamed = await request.send();
    final body = await streamed.stream.bytesToString();
    final data = jsonDecode(body);

    if (streamed.statusCode != 200) {
      throw Exception(data['message'] ?? 'Không thể cập nhật');
    }
  }



  // ============= LOGIN THƯỜNG ===================
  Future<String> login(String email, String password) async {
    final uri = Uri.parse('$baseUrl/api/auth/login');

    final response = await http.post(
      uri,
      headers: {'Accept': 'application/json'},
      body: {'email': email, 'mat_khau': password},
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final token = data['token'];
      final user = data['user'];

      if (user == null || user['vai_tro'] != 'khach_thue') {
        throw Exception('Ứng dụng này chỉ dành cho khách thuê.');
      }

      _currentEmail = user['email'];
      _roles[_currentEmail!] = 'khach_thue';

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);
      await prefs.setString('email', _currentEmail!);

      return token;
    } else {
      throw Exception(data['message'] ?? 'Đăng nhập thất bại');
    }
  }

  // ============= LOGOUT ===================
  Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.clear();

    try {
      await _googleSignIn.disconnect();
    } catch (_) {}

    try {
      await _googleSignIn.signOut();
    } catch (_) {}

    _currentEmail = null;
  }

  // ============= REGISTER ===================
  Future<void> register({
    required String fullName,
    required String email,
    required String phoneNumber,
    required String password,
  }) async {
    final uri = Uri.parse('$baseUrl/api/auth/register');

    final response = await http.post(
      uri,
      headers: {'Accept': 'application/json'},
      body: {
        'full_name': fullName,
        'email': email,
        'phone_number': phoneNumber,
        'password': password,
        'password_confirmation': password,
        'role': 'khach_thue',
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode != 201) {
      throw Exception(data['message'] ?? 'Đăng ký thất bại');
    }
  }

  // ============= HÓA ĐƠN ===================

  Future<Map<String, String>> _authHeaders() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    if (token == null) throw Exception("Chưa đăng nhập");

    return {
      'Accept': 'application/json',
      'Authorization': 'Bearer $token',
    };
  }

  // 1) LẤY DANH SÁCH HÓA ĐƠN
  Future<List<dynamic>> getMyInvoices() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/hoa-don');
    final headers = await _authHeaders();

    final response = await http.get(uri, headers: headers);

    final rawBody = response.body;

    Map<String, dynamic> data;
    try {
      data = jsonDecode(rawBody) as Map<String, dynamic>;
    } on FormatException catch (e) {
      debugPrint('JSON ERROR: $e');
      debugPrint('BODY BỊ LỖI: $rawBody');
      throw Exception('Phản hồi từ server không phải JSON hợp lệ.');
    }

    if (response.statusCode == 200) {
      final list = data['data'];
      if (list is List) {
        return list;
      } else {
        throw Exception('Trường "data" của hóa đơn không phải là mảng.');
      }
    } else {
      throw Exception(data['message'] ?? 'Không lấy được danh sách hóa đơn');
    }
  }

    // LẤY DANH SÁCH YÊU CẦU SỬA CHỮA CỦA KHÁCH
  Future<List<Map<String, dynamic>>> getMyRequests() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/yeu-cau');
    final headers = await _authHeaders();

    final res = await http.get(uri, headers: headers);

    if (res.statusCode != 200) {
      try {
        final data = jsonDecode(res.body);
        final msg = data['error'] ?? data['message'] ?? 'Không lấy được yêu cầu';
        throw Exception(msg);
      } catch (_) {
        throw Exception('Lỗi server (${res.statusCode}) khi lấy yêu cầu');
      }
    }

    final data = jsonDecode(res.body);
    final list = (data['data'] as List?) ?? [];
    return list.cast<Map<String, dynamic>>();
  }
  // GỬI YÊU CẦU SỬA CHỮA
  Future<void> guiYeuCauSuaChua(String loai, String moTa) async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/yeu-cau');
    final headers = await _authHeaders();

    final res = await http.post(
      uri,
      headers: headers,
      body: {
        'loai': loai,
        'mo_ta': moTa,
      },
    );

    if (res.statusCode != 200 && res.statusCode != 201) {
      try {
        final data = jsonDecode(res.body);
        final msg = data['message'] ?? data['error'] ?? 'Gửi yêu cầu thất bại';
        throw Exception(msg);
      } catch (_) {
        throw Exception('Lỗi server (${res.statusCode}) khi gửi yêu cầu');
      }
    }
  }

  // 2) CHI TIẾT HÓA ĐƠN
  Future<Map<String, dynamic>> getInvoiceDetail(int id) async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/hoa-don/$id');
    final headers = await _authHeaders();

    final response = await http.get(uri, headers: headers);
    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      return Map<String, dynamic>.from(data);
    } else {
      throw Exception(data['error'] ?? 'Không lấy được chi tiết hóa đơn');
    }
  }

  // 3) KHÁCH XÁC NHẬN ĐÃ CHUYỂN KHOẢN
  Future<void> confirmInvoicePayment(int id) async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/hoa-don/$id/xac-nhan-thanh-toan');
    final headers = await _authHeaders();

    final response = await http.post(uri, headers: headers);
    final data = jsonDecode(response.body);

    if (response.statusCode != 200) {
      throw Exception(data['message'] ?? 'Không gửi được xác nhận thanh toán');
    }
  }

  // 4) TẠO BẢN GHI THANH TOÁN (tùy chọn)
  Future<void> createPayment({
    required int hoaDonId,
    required int amount,
    String method = 'chuyen_khoan',
  }) async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/thanh-toan');
    final headers = await _authHeaders();

    final response = await http.post(
      uri,
      headers: headers,
      body: {
        'hoa_don_id': hoaDonId.toString(),
        'so_tien': amount.toString(),
        'phuong_thuc': method,
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode != 201) {
      throw Exception(data['message'] ?? 'Thanh toán thất bại');
    }
  }

Future<List<ContractModel>> getMyContracts() async {
  final uri = Uri.parse('$baseUrl/api/khach-thue/hop-dong');
  final headers = await _authHeaders();

  final res = await http.get(uri, headers: headers);

  final data = jsonDecode(res.body);

  if (res.statusCode != 200) {
    throw Exception(data['message'] ?? "Không lấy được hợp đồng");
  }

  final List list = data['data'] ?? [];

  return list.map((e) => ContractModel.fromJson(e)).toList();
}




  // ========= MOCK FUNCTIONS VẪN GIỮ NGUYÊN ===========
  Future<List<Map<String, dynamic>>> getRoomsForOwner() async {
    await Future.delayed(const Duration(milliseconds: 200));
    return _rooms.map((r) => Map<String, dynamic>.from(r)).toList();
  }

  Future<Map<String, dynamic>?> getRoomForCurrentTenant() async {
    await Future.delayed(const Duration(milliseconds: 150));
    final email = _currentEmail;
    if (email == null) return null;
    final room = _rooms.firstWhere(
      (r) => r['tenant'] == email,
      orElse: () => {},
    );
    return room.isEmpty ? null : Map<String, dynamic>.from(room);
  }

  Future<Map<String, dynamic>?> getRoomById(String id) async {
    await Future.delayed(const Duration(milliseconds: 150));
    final room = _rooms.firstWhere((r) => r['id'] == id, orElse: () => {});
    return room.isEmpty ? null : Map<String, dynamic>.from(room);
  }

  // =================== THÔNG BÁO ========================
    // =================== THÔNG BÁO ========================

  // Lấy danh sách thông báo
  Future<List<Map<String, dynamic>>> getNotifications() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/thong-bao');
    final headers = await _authHeaders();

    final res = await http.get(uri, headers: headers);
    final data = jsonDecode(res.body);

    if (res.statusCode != 200) {
      throw Exception(data['error'] ?? 'Không lấy được thông báo');
    }

    return (data['data'] as List).cast<Map<String, dynamic>>();
  }

  // Lấy số thông báo chưa đọc
  Future<int> getUnreadNotiCount() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/thong-bao');
    final headers = await _authHeaders();

    final res = await http.get(uri, headers: headers);
    final data = jsonDecode(res.body);

    if (res.statusCode != 200) {
      throw Exception(data['error'] ?? 'Không lấy được số thông báo chưa đọc');
    }

    return data['chua_doc'] ?? 0;
  }

  // Mark 1 thông báo đã đọc
  Future<void> markAsRead(int id) async {
    final uri =
        Uri.parse('$baseUrl/api/khach-thue/thong-bao/$id/mark-as-read');
    final headers = await _authHeaders();

    final res = await http.post(uri, headers: headers);
    if (res.statusCode != 200) {
      final data = jsonDecode(res.body);
      throw Exception(data['error'] ?? 'Không thể đánh dấu đã đọc');
    }
  }

  // Mark all read
  Future<void> markAllAsRead() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/thong-bao/mark-all-read');
    final headers = await _authHeaders();

    final res = await http.post(uri, headers: headers);
    if (res.statusCode != 200) {
      final data = jsonDecode(res.body);
      throw Exception(data['error'] ?? 'Không thể đánh dấu tất cả đã đọc');
    }
  }

  // Xóa tất cả đã đọc
  Future<void> deleteRead() async {
    final uri = Uri.parse('$baseUrl/api/khach-thue/thong-bao/xoa-da-doc');
    final headers = await _authHeaders();

    final res = await http.delete(uri, headers: headers);
    if (res.statusCode != 200) {
      final data = jsonDecode(res.body);
      throw Exception(data['error'] ?? 'Không thể xóa thông báo đã đọc');
    }
  }

  String getCurrentEmail() => _currentEmail ?? '';

  Future<String> getCurrentUserRole() async {
    return 'khach_thue';
  }

}
