import 'package:flutter/material.dart';

import '../models/billing.dart'; // vẫn dùng RoomSummary từ đây
import '../services/api_service.dart';
import 'room_detail_page.dart';
import 'bills_page.dart';
import 'contracts_page.dart';

class DashboardPage extends StatelessWidget {
  const DashboardPage({super.key});

  // ================== HÀM HỖ TRỢ ==================

  num _toNum(dynamic v) {
    if (v == null) return 0;
    if (v is num) return v;
    if (v is String) {
      return num.tryParse(v.replaceAll('.', '').replaceAll(',', '')) ?? 0;
    }
    return 0;
  }

  String _money(num v) {
    final s = v.toStringAsFixed(0);
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      final revIndex = s.length - i - 1;
      buf.write(s[revIndex]);
      if (i % 3 == 2 && revIndex != 0) buf.write('.');
    }
    return String.fromCharCodes(buf.toString().runes.toList().reversed) + ' đ';
  }

  bool _isUnpaidStatus(String s) {
    return s == 'chua_thanh_toan' || s == 'mot_phan';
  }

  Future<_DashboardData> _loadDashboard() async {
    // 1) hóa đơn của khách
    final invoices = await ApiService.instance.getMyInvoices();

    // 2) thông báo
    final notifications = await ApiService.instance.getNotifications();

    // ---- Thống kê phòng & nợ ----
    final Map<int, RoomSummary> roomMap = {};
    int unpaidCount = 0;
    num totalUnpaidAmount = 0;

    // ---- Thống kê chi tiêu theo tháng ----
    final Map<String, num> totalByMonth = {}; // key: '2025-11', value: tổng tiền tháng đó

    for (final raw in invoices) {
      if (raw is! Map<String, dynamic>) continue;

      final status = (raw['trang_thai'] ?? '').toString();
      final thangStr = (raw['thang'] ?? '').toString();

      final tongTien = _toNum(raw['tong_tien']);
      final daTra = _toNum(raw['so_tien_da_tra']);
      final soTienConLai = tongTien - daTra;

      // đếm hóa đơn chưa hoàn tất
      if (_isUnpaidStatus(status)) unpaidCount++;

      // cộng tổng theo tháng (dùng tổng tiền, không trừ đã trả – cho mục "chi tiêu")
      if (thangStr.isNotEmpty) {
        totalByMonth[thangStr] = (totalByMonth[thangStr] ?? 0) + tongTien;
      }

      // gom theo phòng
      final hopDong = raw['hop_dong'] as Map<String, dynamic>?;
      final phong = hopDong?['phong'] as Map<String, dynamic>?;

      if (phong == null) continue;

      final roomId = phong['id'];
      if (roomId is! int) continue;

      final roomName = phong['so_phong']?.toString() ?? 'N/A';

      if (_isUnpaidStatus(status) && soTienConLai > 0) {
        totalUnpaidAmount += soTienConLai;
      }

      final current = roomMap[roomId];
      int newDue = current?.currentDue ?? 0;

      if (_isUnpaidStatus(status) && soTienConLai > 0) {
        newDue += soTienConLai.toInt();
      }

      roomMap[roomId] = RoomSummary(
        id: roomId,
        name: roomName,
        note: null,
        currentDue: newDue,
      );

      roomMap[roomId] = RoomSummary(
        id: roomId,
        name: roomName,
        note: null,
        currentDue: newDue.toInt(),
      );
    }

    // sort phòng
    final rooms = roomMap.values.toList()
      ..sort((a, b) => a.name.compareTo(b.name));

    // lấy 3 thông báo mới nhất
    final latestNoti = notifications.take(3).toList();

    // build list 6 tháng gần nhất cho biểu đồ
    final monthEntries = totalByMonth.entries.toList()
      ..sort((a, b) {
        // thang kiểu '2025-11'
        DateTime pa, pb;
        try {
          pa = DateTime.parse('${a.key}-01');
          pb = DateTime.parse('${b.key}-01');
        } catch (_) {
          return a.key.compareTo(b.key);
        }
        return pa.compareTo(pb);
      });

    final last6 = monthEntries.length <= 6
        ? monthEntries
        : monthEntries.sublist(monthEntries.length - 6);

    final monthStats = last6.map((e) {
      DateTime? dt;
      try {
        dt = DateTime.parse('${e.key}-01');
      } catch (_) {}
      final label = dt == null
          ? e.key
          : '${dt.month.toString().padLeft(2, '0')}/${dt.year.toString().substring(2)}';
      return _MonthSpend(label: label, total: e.value);
    }).toList();

    return _DashboardData(
      rooms: rooms,
      unpaidCount: unpaidCount,
      totalUnpaidAmount: totalUnpaidAmount,
      latestNotifications: latestNoti,
      monthStats: monthStats,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        centerTitle: true,
        backgroundColor: Colors.transparent,
        elevation: 0,
      ),
      body: FutureBuilder<_DashboardData>(
        future: _loadDashboard(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(
              child: CircularProgressIndicator(color: Colors.white),
            );
          }

          if (snapshot.hasError) {
            return Center(
              child: Text(
                'Lỗi: ${snapshot.error}',
                style: const TextStyle(color: Colors.redAccent),
              ),
            );
          }

          if (!snapshot.hasData) {
            return const Center(
              child: Text(
                'Không có dữ liệu',
                style: TextStyle(color: Colors.white70),
              ),
            );
          }

          final data = snapshot.data!;
          final rooms = data.rooms;
          final unpaidCount = data.unpaidCount;
          final totalUnpaidAmount = data.totalUnpaidAmount;
          final latestNoti = data.latestNotifications;
          final monthStats = data.monthStats;

          return Padding(
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                // ====== Hàng thống kê nhanh ======
                Row(
                  children: [
                    Expanded(
                      child: _StatCard(
                        title: 'Số phòng đang trả',
                        value: rooms.length.toString(),
                        icon: Icons.meeting_room_outlined,
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: _StatCard(
                        title: 'Hóa đơn chưa hoàn tất',
                        value: unpaidCount.toString(),
                        color: Colors.orangeAccent,
                        icon: Icons.receipt_long_outlined,
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 12),
                _StatCard(
                  title: 'Tổng số tiền còn phải trả',
                  value: _money(totalUnpaidAmount),
                  color: Colors.redAccent,
                  icon: Icons.payments_outlined,
                ),

                const SizedBox(height: 20),

                // ====== Biểu đồ chi tiêu 6 tháng gần đây ======
                if (monthStats.isNotEmpty) ...[
                  const _SectionTitle('Chi tiêu 6 tháng gần đây'),
                  const SizedBox(height: 8),
                  _MiniBarChart(monthStats: monthStats),
                  const SizedBox(height: 24),
                ],

                // ====== Danh sách phòng ======
                const _SectionTitle('Các phòng tôi đang trả tiền'),
                const SizedBox(height: 8),
                if (rooms.isEmpty)
                  const _EmptyCard(text: 'Bạn chưa có phòng nào đang thuê.')
                else
                  Column(
                    children: rooms
                        .map((r) => Padding(
                              padding: const EdgeInsets.only(bottom: 12),
                              child: _RoomItem(room: r),
                            ))
                        .toList(),
                  ),

                const SizedBox(height: 24),

                // ====== Thông báo gần đây ======
                const _SectionTitle('Thông báo gần đây'),
                const SizedBox(height: 8),
                if (latestNoti.isEmpty)
                  const _EmptyCard(text: 'Không có thông báo mới.')
                else
                  Column(
                    children: [
                      for (final tb in latestNoti) ...[
                        _NotificationItem(tb: tb),
                        const SizedBox(height: 8),
                      ]
                    ],
                  ),
              ],
            ),
          );
        },
      ),
    );
  }
}

// ================== MODEL DASHBOARD NỘI BỘ ==================

class _DashboardData {
  final List<RoomSummary> rooms;
  final int unpaidCount;
  final num totalUnpaidAmount;
  final List<Map<String, dynamic>> latestNotifications;
  final List<_MonthSpend> monthStats;

  _DashboardData({
    required this.rooms,
    required this.unpaidCount,
    required this.totalUnpaidAmount,
    required this.latestNotifications,
    required this.monthStats,
  });
}

class _MonthSpend {
  final String label; // ví dụ: 11/25
  final num total;

  _MonthSpend({required this.label, required this.total});
}

// ================== UI WIDGETS ==================

class _StatCard extends StatelessWidget {
  final String title;
  final String value;
  final Color? color;
  final IconData? icon;

  const _StatCard({
    required this.title,
    required this.value,
    this.color,
    this.icon,
  });

  @override
  Widget build(BuildContext context) {
    final c = color ?? Colors.blueAccent;
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.grey.shade900,
        borderRadius: BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.4),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          if (icon != null) ...[
            CircleAvatar(
              radius: 18,
              backgroundColor: c.withOpacity(0.15),
              child: Icon(icon, color: c, size: 20),
            ),
            const SizedBox(width: 10),
          ],
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style:
                      const TextStyle(fontSize: 12, color: Colors.white70),
                ),
                const SizedBox(height: 6),
                Text(
                  value,
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                    color: c,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class _MiniBarChart extends StatelessWidget {
  final List<_MonthSpend> monthStats;

  const _MiniBarChart({required this.monthStats});

  @override
  Widget build(BuildContext context) {
    final maxValue = monthStats.fold<num>(
        0, (prev, e) => e.total > prev ? e.total : prev);
    if (maxValue <= 0) {
      return const _EmptyCard(text: 'Chưa có dữ liệu chi tiêu.');
    }

    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: Colors.grey.shade900,
        borderRadius: BorderRadius.circular(18),
      ),
      child: SizedBox(
        height: 170,
        child: LayoutBuilder(
          builder: (context, constraints) {
            const maxBarHeight = 110.0;

            return Row(
              crossAxisAlignment: CrossAxisAlignment.end,
              children: () {
                final children = <Widget>[];
                for (var i = 0; i < monthStats.length; i++) {
                  final m = monthStats[i];
                  final ratio = (m.total / maxValue).clamp(0, 1).toDouble();
                  final height = ratio * maxBarHeight + 10; 

                  children.add(
                    Expanded(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.end,
                        children: [
                          Text(
                            _shortMoney(m.total),
                            style: const TextStyle(
                              color: Colors.white70,
                              fontSize: 11,
                            ),
                          ),
                          const SizedBox(height: 4),
                          Container(
                            height: height,
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(8),
                              gradient: LinearGradient(
                                begin: Alignment.bottomCenter,
                                end: Alignment.topCenter,
                                colors: [
                                  Colors.deepPurpleAccent.withOpacity(0.9),
                                  Colors.purpleAccent.withOpacity(0.7),
                                ],
                              ),
                            ),
                          ),
                          const SizedBox(height: 6),
                          Text(
                            m.label,
                            style: const TextStyle(
                              color: Colors.white70,
                              fontSize: 11,
                            ),
                          ),
                        ],
                      ),
                    ),
                  );

                  if (i < monthStats.length - 1) {
                    children.add(const SizedBox(width: 6));
                  }
                }
                return children;
              }(),
            );
          },
        ),
      ),
    );
  }

  // hiển thị tiền ngắn gọn trên cột, vd: 3.5m, 800k
  static String _shortMoney(num v) {
    if (v >= 1000000) {
      final val = (v / 1000000).toStringAsFixed(1);
      return '${val}m';
    } else if (v >= 1000) {
      final val = (v / 1000).toStringAsFixed(0);
      return '${val}k';
    }
    return v.toStringAsFixed(0);
  }
}

class _RoomItem extends StatelessWidget {
  final RoomSummary room;

  const _RoomItem({required this.room});

  String _money(num v) {
    final s = v.toStringAsFixed(0);
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      final revIndex = s.length - i - 1;
      buf.write(s[revIndex]);
      if (i % 3 == 2 && revIndex != 0) buf.write('.');
    }
    return String.fromCharCodes(buf.toString().runes.toList().reversed) + ' đ';
  }

  @override
  Widget build(BuildContext context) {
    final hasDebt = room.currentDue > 0;

    return InkWell(
      onTap: () {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (_) => BillsPage(filterRoomId: room.id),
        ),
      );
    },

      borderRadius: BorderRadius.circular(16),
      child: Container(
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: Colors.grey.shade900,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(
            color: hasDebt ? Colors.orangeAccent : Colors.greenAccent,
            width: 1,
          ),
        ),
        child: Row(
          children: [
            const Icon(Icons.meeting_room, size: 32, color: Colors.white),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Phòng ${room.name}',
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  if (room.note != null) ...[
                    const SizedBox(height: 4),
                    Text(
                      room.note!,
                      style: const TextStyle(
                        color: Colors.grey,
                        fontSize: 12,
                      ),
                    ),
                  ],
                  const SizedBox(height: 4),
                  Text(
                    hasDebt
                        ? 'Còn nợ: ${_money(room.currentDue)}'
                        : 'Đã thanh toán hết',
                    style: TextStyle(
                      color:
                          hasDebt ? Colors.orangeAccent : Colors.greenAccent,
                    ),
                  ),
                ],
              ),
            ),
            IconButton(
              icon: const Icon(Icons.receipt_long, color: Colors.white70),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => BillsPage(filterRoomId: room.id),
                  ),
                );
              },
              tooltip: 'Xem hóa đơn',
            ),
            IconButton(
              icon:
                  const Icon(Icons.description_outlined, color: Colors.white70),
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => const ContractsPage(),
                  ),
                );
              },
              tooltip: 'Xem hợp đồng',
            ),
          ],
        ),
      ),
    );
  }
}

class _EmptyCard extends StatelessWidget {
  final String text;

  const _EmptyCard({required this.text});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.grey.shade900,
        borderRadius: BorderRadius.circular(16),
      ),
      child: Text(
        text,
        style: const TextStyle(color: Colors.white70),
      ),
    );
  }
}

class _SectionTitle extends StatelessWidget {
  final String text;
  const _SectionTitle(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: const TextStyle(
        fontSize: 16,
        fontWeight: FontWeight.w600,
        color: Colors.white,
      ),
    );
  }
}

class _NotificationItem extends StatelessWidget {
  final Map<String, dynamic> tb;

  const _NotificationItem({required this.tb});

  @override
  Widget build(BuildContext context) {
    final noiDung = tb['noi_dung']?.toString() ?? '';
    final ngayTao = tb['ngay_tao']?.toString() ?? '';

    return Container(
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: Colors.grey.shade900,
        borderRadius: BorderRadius.circular(14),
      ),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Icon(
            Icons.notifications,
            color: Colors.blueAccent,
          ),
          const SizedBox(width: 10),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  noiDung,
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 14,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  ngayTao,
                  style: const TextStyle(
                    color: Colors.white38,
                    fontSize: 11,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
