import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class AuthService {
  // Android emulator:
  static const String baseUrl = 'http://10.0.2.2:8000';

  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final url = Uri.parse('$baseUrl/api/login');

    final response = await http.post(
      url,
      headers: {
        'Accept': 'application/json',
      },
      body: {
        'email': email,
        'mat_khau': password, // phải trùng với backend Laravel
      },
    );

    final data = jsonDecode(response.body);

    if (response.statusCode == 200) {
      final token = data['token'];
      final user = data['user'];

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('token', token);
      await prefs.setString('user', jsonEncode(user));

      return {
        'success': true,
        'message': data['message'] ?? 'Đăng nhập thành công',
      };
    } else {
      return {
        'success': false,
        'message': data['message'] ?? 'Đăng nhập thất bại',
        'errors': data['errors'],
      };
    }
  }

  static Future<void> logout() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');

    if (token != null) {
      final url = Uri.parse('$baseUrl/api/logout');

      await http.post(
        url,
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );
    }

    await prefs.remove('token');
    await prefs.remove('user');
  }

  static Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token') != null;
  }

  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('token');
  }
}
