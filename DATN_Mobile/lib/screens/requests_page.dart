import 'package:flutter/material.dart';
import '../services/api_service.dart';

class RequestsPage extends StatefulWidget {
  const RequestsPage({super.key});

  @override
  State<RequestsPage> createState() => _RequestsPageState();
}

class _RequestsPageState extends State<RequestsPage> {
  final _frmKey = GlobalKey<FormState>();
  final _ctCtl = TextEditingController();
  String _type = 'Điện';

  bool _sending = false;
  bool _loadingList = true;
  List<Map<String, dynamic>> _requests = [];

  @override
  void initState() {
    super.initState();
    _loadRequests();
  }

  @override
  void dispose() {
    _ctCtl.dispose();
    super.dispose();
  }

  Future<void> _loadRequests() async {
    setState(() => _loadingList = true);
    try {
      final list = await ApiService.instance.getMyRequests();
      if (!mounted) return;
      setState(() => _requests = list);
    } catch (e) {
      debugPrint("Lỗi load yêu cầu: $e");
    } finally {
      if (mounted) setState(() => _loadingList = false);
    }
  }

  Future<void> _submit() async {
    if (!_frmKey.currentState!.validate()) return;

    setState(() => _sending = true);

    try {
      await ApiService.instance.guiYeuCauSuaChua(_type, _ctCtl.text.trim());

      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Đã gửi yêu cầu thành công'),
          backgroundColor: Colors.green,
        ),
      );

      _ctCtl.clear();
      _loadRequests();
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Lỗi: $e'),
          backgroundColor: Colors.redAccent,
        ),
      );
    } finally {
      if (mounted) setState(() => _sending = false);
    }
  }

  // ================= STATUS UI =================
  Color _statusColor(String s) {
    switch (s) {
      case 'da_xu_ly':
        return Colors.greenAccent;
      case 'tu_choi':
        return Colors.redAccent;
      default:
        return Colors.orangeAccent;
    }
  }

  String _statusLabel(String s) {
    switch (s) {
      case 'da_xu_ly':
        return 'Đã xử lý';
      case 'tu_choi':
        return 'Từ chối';
      default:
        return 'Đang xử lý';
    }
  }

  IconData _statusIcon(String s) {
    switch (s) {
      case 'da_xu_ly':
        return Icons.check_circle_outline;
      case 'tu_choi':
        return Icons.cancel_outlined;
      default:
        return Icons.pending_outlined;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        elevation: 0,
        centerTitle: true,
        title: const Text(
          'Yêu cầu sửa chữa',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
      ),

      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          children: [
            // ================= FORM ================
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: const Color(0xFF1E1E1E),
                borderRadius: BorderRadius.circular(18),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.4),
                    blurRadius: 12,
                    offset: const Offset(0, 4),
                  )
                ],
              ),
              child: Form(
                key: _frmKey,
                child: Column(
                  children: [
                    DropdownButtonFormField<String>(
                      value: _type,
                      dropdownColor: Colors.grey.shade900,
                      style: const TextStyle(color: Colors.white),
                      items: const [
                        DropdownMenuItem(value: 'Điện', child: Text('Điện')),
                        DropdownMenuItem(value: 'Nước', child: Text('Nước')),
                        DropdownMenuItem(value: 'Wifi', child: Text('Wifi')),
                        DropdownMenuItem(value: 'Khác', child: Text('Khác')),
                      ],
                      onChanged: (v) => setState(() => _type = v ?? 'Điện'),
                      decoration: InputDecoration(
                        labelText: 'Loại vấn đề',
                        labelStyle:
                            const TextStyle(color: Colors.white70),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                        enabledBorder: OutlineInputBorder(
                          borderSide: BorderSide(color: Colors.grey.shade600),
                        ),
                      ),
                    ),

                    const SizedBox(height: 16),

                    TextFormField(
                      controller: _ctCtl,
                      maxLines: 4,
                      style: const TextStyle(color: Colors.white),
                      decoration: InputDecoration(
                        labelText: 'Mô tả chi tiết',
                        labelStyle: const TextStyle(color: Colors.white70),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                        enabledBorder: OutlineInputBorder(
                          borderSide: BorderSide(color: Colors.grey.shade600),
                        ),
                      ),
                      validator: (v) =>
                          (v == null || v.trim().isEmpty) ? 'Nhập mô tả' : null,
                    ),

                    const SizedBox(height: 16),

                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.deepPurpleAccent,
                          padding: const EdgeInsets.symmetric(vertical: 14),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                        onPressed: _sending ? null : _submit,
                        child: _sending
                            ? const SizedBox(
                                height: 18,
                                width: 18,
                                child: CircularProgressIndicator(
                                  strokeWidth: 2,
                                  color: Colors.white,
                                ),
                              )
                            : const Text(
                                'Gửi yêu cầu',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold,
                                    fontSize: 15),
                              ),
                      ),
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 20),

            // ================= LIST =================
            Expanded(
              child: _loadingList
                  ? const Center(
                      child: CircularProgressIndicator(color: Colors.white),
                    )
                  : _requests.isEmpty
                      ? const Center(
                          child: Text(
                            'Bạn chưa có yêu cầu nào',
                            style: TextStyle(color: Colors.white54),
                          ),
                        )
                      : ListView.separated(
                          itemCount: _requests.length,
                          separatorBuilder: (_, __) =>
                              const SizedBox(height: 12),
                          itemBuilder: (context, i) {
                            final r = _requests[i];

                            final loai = (r['loai'] ?? '').toString();
                            final moTa = (r['mo_ta'] ?? '').toString();
                            final trangThai =
                                (r['trang_thai'] ?? '').toString();
                            final createdAt =
                                (r['created_at'] ?? '').toString();

                            return Container(
                              padding: const EdgeInsets.all(16),
                              decoration: BoxDecoration(
                                color: const Color(0xFF1E1E1E),
                                borderRadius: BorderRadius.circular(16),
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withOpacity(0.35),
                                    blurRadius: 10,
                                    offset: const Offset(0, 4),
                                  ),
                                ],
                              ),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Icon(
                                    _statusIcon(trangThai),
                                    color: _statusColor(trangThai),
                                    size: 30,
                                  ),
                                  const SizedBox(width: 14),

                                  // Text info
                                  Expanded(
                                    child: Column(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          loai.isEmpty
                                              ? 'Yêu cầu sửa chữa'
                                              : loai,
                                          style: const TextStyle(
                                            color: Colors.white,
                                            fontSize: 16,
                                            fontWeight: FontWeight.w600,
                                          ),
                                        ),

                                        const SizedBox(height: 6),

                                        Text(
                                          moTa,
                                          style: const TextStyle(
                                            color: Colors.white70,
                                            fontSize: 14,
                                          ),
                                        ),

                                        const SizedBox(height: 6),

                                        Text(
                                          createdAt,
                                          style: const TextStyle(
                                            color: Colors.white38,
                                            fontSize: 11,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),

                                  // STATUS
                                  Container(
                                    padding: const EdgeInsets.symmetric(
                                        vertical: 6, horizontal: 12),
                                    decoration: BoxDecoration(
                                      color: _statusColor(trangThai)
                                          .withOpacity(0.2),
                                      borderRadius: BorderRadius.circular(12),
                                      border: Border.all(
                                        color: _statusColor(trangThai),
                                        width: 1,
                                      ),
                                    ),
                                    child: Text(
                                      _statusLabel(trangThai),
                                      style: TextStyle(
                                        color: _statusColor(trangThai),
                                        fontSize: 12,
                                        fontWeight: FontWeight.w600,
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                            );
                          },
                        ),
            ),
          ],
        ),
      ),
    );
  }
}
