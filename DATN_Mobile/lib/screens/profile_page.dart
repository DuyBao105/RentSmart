import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'edit_profile_page.dart';
import 'change_password_page.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  bool loading = true;
  Map<String, dynamic> user = {};

  @override
  void initState() {
    super.initState();
    loadProfile();
  }

  Future<void> loadProfile() async {
    try {
      final data = await ApiService.instance.getProfile();
      if (!mounted) return;
      setState(() {
        user = data;
        loading = false;
      });

     print("=== PROFILE DATA ===");
    print(user);
    print("Avatar = ${user['anh_dai_dien']}");
    } catch (e) {
      setState(() => loading = false);
    }
  }

  Future<void> _logout() async {
    await ApiService.instance.logout();
    if (!mounted) return;
    Navigator.pushNamedAndRemoveUntil(context, '/login', (_) => false);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0F0F0F),
      appBar: AppBar(
        title: const Text('Hồ sơ cá nhân'),
        centerTitle: true,
        backgroundColor: Colors.black,
        elevation: 0,
      ),
      body: loading
          ? const Center(child: CircularProgressIndicator())
          : ListView(
              padding: const EdgeInsets.all(16),
              children: [
                // =================== AVATAR ===================
                Center(
                  child: Column(
                    children: [
                      Container(
                        padding: const EdgeInsets.all(3),
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          gradient: LinearGradient(
                            colors: [
                              Colors.blue.shade400,
                              Colors.purple.shade400,
                            ],
                          ),
                        ),
                        child: Container(
                          padding: const EdgeInsets.all(3),
                          decoration: BoxDecoration(
                            shape: BoxShape.circle,
                            gradient: LinearGradient(
                              colors: [
                                Colors.blue.shade400,
                                Colors.purple.shade400,
                              ],
                            ),
                          ),
                          child: ClipOval(
                            child: Image.network(
                              user["anh_dai_dien"] ?? "",
                              width: 96,
                              height: 96,
                              fit: BoxFit.cover,
                              headers: const {
                                "Connection": "keep-alive",
                                "Accept": "*/*"
                              },
                              errorBuilder: (context, error, stackTrace) {
                                return Container(
                                  width: 96,
                                  height: 96,
                                  color: Colors.grey.shade900,
                                  child: const Icon(Icons.person,
                                      size: 48, color: Colors.white70),
                                );
                              },
                            ),
                          ),
                        )

                      ),
                      const SizedBox(height: 12),
                      Text(
                        user["ho_ten"] ?? "",
                        style: const TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        user["email"] ?? "",
                        style:
                            const TextStyle(color: Colors.white70, fontSize: 14),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 30),

                // =================== THÔNG TIN ===================
                Container(
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  decoration: BoxDecoration(
                    color: const Color(0xFF1A1A1A),
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Column(
                    children: [
                      _infoRow(Icons.person, 'Họ tên', user['ho_ten'] ?? ''),
                      _divider(),
                      _infoRow(Icons.phone, 'Số điện thoại',
                          user['so_dien_thoai'] ?? ''),
                      _divider(),
                      _infoRow(Icons.email, 'Email', user['email'] ?? ''),
                    ],
                  ),
                ),

                const SizedBox(height: 30),

                // =================== BUTTONS ===================
                _actionButton(
                  icon: Icons.edit,
                  label: "Chỉnh sửa thông tin",
                  onTap: () async {
                    await Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => EditProfilePage(oldData: user),
                      ),
                    );
                    loadProfile();
                  },
                ),
                const SizedBox(height: 12),

                _actionButton(
                  icon: Icons.lock_reset,
                  label: "Đổi mật khẩu",
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => const ChangePasswordPage(),
                      ),
                    );
                  },
                ),
                const SizedBox(height: 12),

                _logoutButton(),
              ],
            ),
    );
  }

  Widget _divider() => Divider(color: Colors.grey.shade800, height: 20);

  Widget _infoRow(IconData icon, String label, String value) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 6),
      child: Row(
        children: [
          Icon(icon, color: Colors.blueAccent, size: 22),
          const SizedBox(width: 12),
          Text(label, style: const TextStyle(color: Colors.white70)),
          const Spacer(),
          Text(value,
              style: const TextStyle(
                color: Colors.white,
                fontWeight: FontWeight.w500,
              )),
        ],
      ),
    );
  }

  Widget _actionButton({
  required IconData icon,
  required String label,
  required Function() onTap,
  }) {
    return SizedBox(
      width: double.infinity,
      child: ElevatedButton(
        style: ElevatedButton.styleFrom(
          padding: const EdgeInsets.symmetric(vertical: 16),
          backgroundColor: const Color(0xFF246BFD), 
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(14),
          ),
          elevation: 3,
        ),
        onPressed: onTap,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(icon, color: Colors.white, size: 20),
            const SizedBox(width: 8),
            Text(
              label,
              style: const TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w600,
                color: Colors.white,
              ),
            ),
          ],
        ),
      ),
    );
  }


  Widget _logoutButton() {
    return SizedBox(
      width: double.infinity,
      child: OutlinedButton.icon(
        style: OutlinedButton.styleFrom(
          foregroundColor: Colors.redAccent,
          side: const BorderSide(color: Colors.redAccent),
          padding: const EdgeInsets.symmetric(vertical: 14),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(14),
          ),
        ),
        onPressed: _logout,
        icon: const Icon(Icons.logout),
        label: const Text(
          'Đăng xuất',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
        ),
      ),
    );
  }
}
