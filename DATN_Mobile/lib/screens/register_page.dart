import 'package:flutter/material.dart';
import '../services/api_service.dart';

class RegisterPage extends StatefulWidget {
  const RegisterPage({super.key});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final _fullNameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  final _confirmController = TextEditingController();

  final _formKey = GlobalKey<FormState>();
  bool _loading = false;

  @override
  void dispose() {
    _fullNameController.dispose();
    _phoneController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmController.dispose();
    super.dispose();
  }

  // ================== API REGISTER ==================
  Future<void> _handleRegister() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _loading = true);

    try {
      await ApiService.instance.register(
        fullName: _fullNameController.text.trim(),
        email: _emailController.text.trim(),
        phoneNumber: _phoneController.text.trim(),
        password: _passwordController.text.trim(),
      );

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Đăng ký thành công! Hãy đăng nhập.')),
      );

      Navigator.pop(context);
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Lỗi: $e')),
      );
    } finally {
      if (mounted) setState(() => _loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    const bgDark = Color(0xFF0F0F0F);
    const cardDark = Color(0xFF1A1A1A);
    const primaryBlue = Color(0xFF246BFD);

    return Scaffold(
      backgroundColor: bgDark,
      appBar: AppBar(
        backgroundColor: Colors.black,
        foregroundColor: Colors.white,
        title: const Text("Đăng ký"),
        centerTitle: true,
        elevation: 0,
      ),

      body: SingleChildScrollView(
        padding: const EdgeInsets.all(18),
        child: Column(
          children: [
            const SizedBox(height: 20),

            // ===== ICON HEADER =====
            Container(
              width: 90,
              height: 90,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                gradient: LinearGradient(
                  colors: [primaryBlue, Colors.purpleAccent],
                ),
              ),
              child: const Icon(
                Icons.person_add_alt_1_rounded,
                size: 40,
                color: Colors.white,
              ),
            ),

            const SizedBox(height: 16),
            const Text(
              "Tạo tài khoản",
              style: TextStyle(
                color: Colors.white,
                fontSize: 22,
                fontWeight: FontWeight.w700,
              ),
            ),
            const SizedBox(height: 6),
            const Text(
              "Đăng ký để quản lý hóa đơn, phòng trọ\nmột cách dễ dàng.",
              textAlign: TextAlign.center,
              style: TextStyle(color: Colors.white54),
            ),

            const SizedBox(height: 28),

            // ===== FORM CARD =====
            Container(
              padding: const EdgeInsets.all(18),
              decoration: BoxDecoration(
                color: cardDark,
                borderRadius: BorderRadius.circular(18),
              ),
              child: Form(
                key: _formKey,
                child: Column(
                  children: [
                    _inputField(
                      controller: _fullNameController,
                      label: "Họ và tên",
                      icon: Icons.person_outline,
                      validator: (v) =>
                          v!.isEmpty ? "Vui lòng nhập họ tên" : null,
                    ),
                    const SizedBox(height: 14),

                    _inputField(
                      controller: _phoneController,
                      label: "Số điện thoại",
                      icon: Icons.phone_outlined,
                      validator: (v) =>
                          v!.length < 8 ? "Số điện thoại không hợp lệ" : null,
                      keyboard: TextInputType.phone,
                    ),
                    const SizedBox(height: 14),

                    _inputField(
                      controller: _emailController,
                      label: "Email",
                      icon: Icons.email_outlined,
                      validator: (v) =>
                          !v!.contains("@") ? "Email không hợp lệ" : null,
                      keyboard: TextInputType.emailAddress,
                    ),
                    const SizedBox(height: 14),

                    _inputField(
                      controller: _passwordController,
                      label: "Mật khẩu",
                      icon: Icons.lock_outline,
                      obscure: true,
                      validator: (v) =>
                          v!.length < 6 ? "Ít nhất 6 ký tự" : null,
                    ),
                    const SizedBox(height: 14),

                    _inputField(
                      controller: _confirmController,
                      label: "Nhập lại mật khẩu",
                      icon: Icons.lock_reset_outlined,
                      obscure: true,
                      validator: (v) => v != _passwordController.text
                          ? "Mật khẩu nhập lại không khớp"
                          : null,
                    ),
                    const SizedBox(height: 20),

                    // ===== REGISTER BUTTON =====
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        onPressed: _loading ? null : _handleRegister,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: primaryBlue,
                          padding: const EdgeInsets.symmetric(vertical: 14),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(14),
                          ),
                        ),
                        child: _loading
                            ? const CircularProgressIndicator(
                                color: Colors.white, strokeWidth: 2)
                            : const Text(
                                "Đăng ký",
                                style: TextStyle(
                                    color: Colors.white,
                                    fontSize: 16,
                                    fontWeight: FontWeight.w600),
                              ),
                      ),
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 20),

            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text(
                "Đã có tài khoản? Đăng nhập",
                style: TextStyle(color: primaryBlue),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ================================================================
  //                    CUSTOM INPUT FIELD
  // ================================================================
  Widget _inputField({
    required TextEditingController controller,
    required String label,
    required IconData icon,
    required FormFieldValidator<String> validator,
    bool obscure = false,
    TextInputType keyboard = TextInputType.text,
  }) {
    return TextFormField(
      controller: controller,
      obscureText: obscure,
      keyboardType: keyboard,
      validator: validator,
      style: const TextStyle(color: Colors.white),
      decoration: InputDecoration(
        labelText: label,
        labelStyle: const TextStyle(color: Colors.white70),
        prefixIcon: Icon(icon, color: Colors.blueAccent),
        filled: true,
        fillColor: const Color(0xFF121212),
        focusedBorder: OutlineInputBorder(
          borderSide: const BorderSide(color: Colors.blueAccent, width: 1.2),
          borderRadius: BorderRadius.circular(12),
        ),
        enabledBorder: OutlineInputBorder(
          borderSide: BorderSide(color: Colors.grey.shade800),
          borderRadius: BorderRadius.circular(12),
        ),
      ),
    );
  }
}
