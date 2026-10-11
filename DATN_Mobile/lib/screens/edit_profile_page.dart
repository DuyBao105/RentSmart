import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import '../services/api_service.dart';

class EditProfilePage extends StatefulWidget {
  final Map<String, dynamic> oldData;

  const EditProfilePage({super.key, required this.oldData});

  @override
  State<EditProfilePage> createState() => _EditProfilePageState();
}

class _EditProfilePageState extends State<EditProfilePage> {
  final _formKey = GlobalKey<FormState>();

  late TextEditingController _nameCtl;
  late TextEditingController _emailCtl;
  late TextEditingController _phoneCtl;

  File? _avatarFile;
  String? _avatarUrl;

  bool _saving = false;
  final picker = ImagePicker();

  @override
  void initState() {
    super.initState();
    _nameCtl = TextEditingController(text: widget.oldData['ho_ten']);
    _emailCtl = TextEditingController(text: widget.oldData['email']);
    _phoneCtl = TextEditingController(text: widget.oldData['so_dien_thoai']);

    _avatarUrl = widget.oldData['anh_dai_dien'];
  }

  Future<void> pickAvatar() async {
    final picked = await picker.pickImage(
      source: ImageSource.gallery,
      imageQuality: 85,
    );

    if (picked != null) {
      setState(() {
        _avatarFile = File(picked.path);
      });
    }
  }

  Future<void> _save() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _saving = true);

    try {
      await ApiService.instance.updateProfile(
        hoTen: _nameCtl.text.trim(),
        email: _emailCtl.text.trim(),
        sdt: _phoneCtl.text.trim(),
        avatarFile: _avatarFile,
      );

      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Cập nhật thành công')),
      );

      Navigator.pop(context);
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Lỗi: $e')),
        );
      }
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final avatar = Stack(
      children: [
        Container(
          padding: const EdgeInsets.all(4),
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            gradient: LinearGradient(
              colors: [Colors.blue.shade300, Colors.purple.shade300],
            ),
          ),
          child: CircleAvatar(
            radius: 55,
            backgroundColor: Colors.white,
            backgroundImage: _avatarFile != null
                ? FileImage(_avatarFile!)
                : (_avatarUrl != null && _avatarUrl!.isNotEmpty)
                    ? NetworkImage(_avatarUrl!)
                    : null,
            child: (_avatarFile == null &&
                    (_avatarUrl == null || _avatarUrl!.isEmpty))
                ? const Icon(Icons.person, size: 55, color: Colors.grey)
                : null,
          ),
        ),
        Positioned(
          bottom: 0,
          right: 0,
          child: InkWell(
            onTap: pickAvatar,
            child: Container(
              padding: const EdgeInsets.all(7),
              decoration: BoxDecoration(
                color: Colors.blueAccent,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: Colors.blueAccent.withOpacity(0.4),
                    blurRadius: 6,
                    offset: const Offset(0, 3),
                  )
                ],
              ),
              child: const Icon(Icons.camera_alt, size: 20, color: Colors.white),
            ),
          ),
        ),
      ],
    );

    return Scaffold(
      backgroundColor: Colors.grey.shade100,
      appBar: AppBar(
        elevation: 0,
        backgroundColor: Colors.grey.shade100,
        foregroundColor: Colors.black,
        title: const Text("Chỉnh sửa hồ sơ",
            style: TextStyle(fontWeight: FontWeight.w600)),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              Center(child: avatar),
              const SizedBox(height: 25),

              _input("Họ tên", _nameCtl),
              const SizedBox(height: 14),

              _input("Email", _emailCtl),
              const SizedBox(height: 14),

              _input("Số điện thoại", _phoneCtl),
              const SizedBox(height: 22),

              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _saving ? null : _save,
                  style: ElevatedButton.styleFrom(
                    padding: const EdgeInsets.symmetric(vertical: 15),
                    backgroundColor: const Color(0xFF3A66FF),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(14),
                    ),
                    elevation: 2,
                  ),
                  child: _saving
                      ? const CircularProgressIndicator(
                          color: Colors.white, strokeWidth: 2)
                      : const Text(
                          "Lưu thay đổi",
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _input(String label, TextEditingController ctl) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(label,
            style: const TextStyle(
                fontWeight: FontWeight.w600, color: Colors.black87)),
        const SizedBox(height: 6),
        TextFormField(
          controller: ctl,
          decoration: InputDecoration(
            filled: true,
            fillColor: Colors.white,
            contentPadding:
                const EdgeInsets.symmetric(vertical: 14, horizontal: 14),
            border: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide:
                  BorderSide(color: Colors.grey.shade300, width: 1.2),
            ),
          ),
          validator: (v) =>
              (v == null || v.isEmpty) ? "Không được để trống" : null,
        ),
      ],
    );
  }
}
