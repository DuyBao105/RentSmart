import 'package:flutter/material.dart';
import '../services/api_service.dart';
import 'bill_detail_page.dart'; // ⬅️ thêm import để mở chi tiết hóa đơn

class NotificationsPage extends StatefulWidget {
  final void Function(int unread)? onUnreadChanged;

  const NotificationsPage({super.key, this.onUnreadChanged});

  @override
  State<NotificationsPage> createState() => _NotificationsPageState();
}

class _NotificationsPageState extends State<NotificationsPage> {
  List<Map<String, dynamic>> _notifications = [];
  int unread = 0;
  bool loading = true;

  @override
  void initState() {
    super.initState();
    loadNotifications();
  }

  Future<void> loadNotifications() async {
    setState(() => loading = true);
    try {
      final list = await ApiService.instance.getNotifications();
      final unreadCount = list.where((e) => e['da_xem'] == 0).length;

      setState(() {
        _notifications = list;
        unread = unreadCount;
      });

      widget.onUnreadChanged?.call(unreadCount);
    } catch (e) {
      debugPrint("Error loading notifications: $e");
    } finally {
      if (mounted) {
        setState(() => loading = false);
      }
    }
  }

  Future<void> markRead(int id) async {
    await ApiService.instance.markAsRead(id);
    await loadNotifications();
  }

  Future<void> markAll() async {
    await ApiService.instance.markAllAsRead();
    await loadNotifications();
  }

  Future<void> deleteRead() async {
    await ApiService.instance.deleteRead();
    await loadNotifications();
  }

  // ========= HANDLE TAP THÔNG BÁO =========
  Future<void> _handleNotificationTap(
    BuildContext context,
    Map<String, dynamic> tb,
  ) async {
    final id = tb['id'] as int;
    final loai = tb['loai']?.toString() ?? '';
    final lienKet = tb['lien_ket']?.toString() ?? '';

    // Đánh dấu đã đọc
    await markRead(id);

    // Nếu là thông báo về hóa đơn thì chuyển qua BillDetailPage
    if (loai == 'hoa_don') {
      final hoaDonId = _extractHoaDonIdFromLink(lienKet);
      if (hoaDonId != null && context.mounted) {
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (_) => BillDetailPage(billId: hoaDonId),
          ),
        );
      }
    }

    // Nếu sau này có loại khác (yêu cầu sửa chữa, tin nhắn...) thì xử lý thêm ở đây
  }

  /// Lấy id hóa đơn từ đường dẫn kiểu: /khach-thue/hoa-don/123
  int? _extractHoaDonIdFromLink(String link) {
    final regex = RegExp(r'/khach-thue/hoa-don/(\d+)');
    final match = regex.firstMatch(link);
    if (match != null) {
      return int.tryParse(match.group(1)!);
    }
    return null;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        foregroundColor: Colors.white,
        backgroundColor: Colors.transparent,
        elevation: 0,
        title: Row(
          children: [
            const Text("Thông báo"),
            const SizedBox(width: 8),

            // Badge chưa đọc
            if (unread > 0)
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 3),
                decoration: BoxDecoration(
                  color: Colors.red,
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  unread.toString(),
                  style: const TextStyle(color: Colors.white, fontSize: 13),
                ),
              ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: "Đánh dấu tất cả đã xem",
            onPressed: markAll,
            icon: const Icon(Icons.mark_email_read),
          ),
          IconButton(
            tooltip: "Xóa thông báo đã đọc",
            onPressed: deleteRead,
            icon: const Icon(Icons.delete_sweep),
          ),
        ],
      ),
      body: loading
          ? const Center(
              child: CircularProgressIndicator(color: Colors.white),
            )
          : _notifications.isEmpty
              ? const Center(
                  child: Text(
                    "Không có thông báo",
                    style: TextStyle(color: Colors.white70),
                  ),
                )
              : ListView.builder(
                  padding: const EdgeInsets.all(12),
                  itemCount: _notifications.length,
                  itemBuilder: (_, i) {
                    final tb = _notifications[i];
                    final isRead = tb["da_xem"] == 1;

                    return GestureDetector(
                      // ⬅️ ĐỔI CHỖ NÀY: dùng _handleNotificationTap
                      onTap: () => _handleNotificationTap(context, tb),
                      child: Container(
                        margin: const EdgeInsets.only(bottom: 12),
                        padding: const EdgeInsets.all(16),
                        decoration: BoxDecoration(
                          color: Colors.grey.shade900,
                          borderRadius: BorderRadius.circular(14),
                          border: Border.all(
                            color: isRead
                                ? Colors.grey.shade700
                                : Colors.blueAccent,
                            width: 1,
                          ),
                        ),
                        child: Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Icon(
                              isRead
                                  ? Icons.notifications_outlined
                                  : Icons.notifications_active,
                              color: isRead
                                  ? Colors.white54
                                  : Colors.blueAccent,
                              size: 28,
                            ),
                            const SizedBox(width: 12),
                            Expanded(
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(
                                    tb["noi_dung"] ?? '',
                                    style: TextStyle(
                                      color: isRead
                                          ? Colors.white70
                                          : Colors.white,
                                      fontSize: 15,
                                      fontWeight: isRead
                                          ? FontWeight.normal
                                          : FontWeight.bold,
                                    ),
                                  ),
                                  const SizedBox(height: 6),
                                  Text(
                                    tb["ngay_tao"] ?? '',
                                    style: const TextStyle(
                                      color: Colors.white38,
                                      fontSize: 12,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ),
                      ),
                    );
                  },
                ),
    );
  }
}
