import 'package:flutter/material.dart';
import 'bill_detail_page.dart';
import '../services/api_service.dart';

class BillsPage extends StatefulWidget {
  final int? filterRoomId;

  const BillsPage({super.key, this.filterRoomId});

  @override
  State<BillsPage> createState() => _BillsPageState();
}

class _BillsPageState extends State<BillsPage> {
  late Future<List<dynamic>> _futureInvoices;

  String filterStatus = 'all';
  String filterMonth = 'all';

  @override
  void initState() {
    super.initState();
    _reloadInvoices();
  }

  void _reloadInvoices() {
    _futureInvoices = ApiService.instance.getMyInvoices();
  }

  Color _statusColor(String t, bool overdue) {
    if (overdue && t == 'chua_thanh_toan') return Colors.redAccent;

    switch (t) {
      case 'da_thanh_toan':
        return Colors.green;
      case 'cho_xac_nhan':
        return Colors.blueAccent;
      case 'mot_phan':
        return Colors.orange;
      default:
        return Colors.redAccent;
    }
  }

  String _mapTrangThaiLabel(String t) {
    switch (t) {
      case 'da_thanh_toan':
        return 'Đã thanh toán';
      case 'cho_xac_nhan':
        return 'Chờ xác nhận';
      case 'mot_phan':
        return 'Thanh toán một phần';
      default:
        return 'Chưa thanh toán';
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF0F0F0F),
      appBar: AppBar(
        backgroundColor: Colors.black,
        elevation: 0,
        title: Text(
          widget.filterRoomId == null
              ? "Hóa đơn"
              : "Hóa đơn phòng ${widget.filterRoomId}",
          style: const TextStyle(fontWeight: FontWeight.w600),
        ),
        centerTitle: true,
      ),

      // ========================== BODY ===========================
      body: Column(
        children: [
          // ===================== FILTER UI ======================
          Padding(
            padding: const EdgeInsets.all(12),
            child: Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: const Color(0xFF1A1A1A),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Column(
                children: [
                  Row(
                    children: [
                      // Trạng thái
                      Expanded(
                        child: _dropdown(
                          label: "Trạng thái",
                          value: filterStatus,
                          items: const [
                            DropdownMenuItem(
                                value: "all", child: Text("Tất cả")),
                            DropdownMenuItem(
                                value: "chua_thanh_toan",
                                child: Text("Chưa thanh toán")),
                            DropdownMenuItem(
                                value: "mot_phan", child: Text("Một phần")),
                            DropdownMenuItem(
                                value: "cho_xac_nhan",
                                child: Text("Chờ xác nhận")),
                            DropdownMenuItem(
                                value: "da_thanh_toan",
                                child: Text("Đã thanh toán")),
                          ],
                          onChanged: (v) {
                            setState(() => filterStatus = v!);
                          },
                        ),
                      ),
                      const SizedBox(width: 12),

                      // Tháng
                      Expanded(
                        child: _dropdown(
                          label: "Tháng",
                          value: filterMonth,
                          items: const [
                            DropdownMenuItem(
                                value: "all", child: Text("Tất cả")),
                            DropdownMenuItem(
                                value: "2025-01", child: Text("2025-01")),
                            DropdownMenuItem(
                                value: "2025-02", child: Text("2025-02")),
                            DropdownMenuItem(
                                value: "2025-11", child: Text("2025-11")),
                            DropdownMenuItem(
                                value: "2025-12", child: Text("2025-12")),
                          ],
                          onChanged: (v) {
                            setState(() => filterMonth = v!);
                          },
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),

          // ===================== LIST ======================
          Expanded(
            child: FutureBuilder<List<dynamic>>(
              future: _futureInvoices,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return const Center(child: CircularProgressIndicator());
                }

                if (snapshot.hasError) {
                  return Center(child: Text("Lỗi: ${snapshot.error}"));
                }

                List<dynamic> bills = snapshot.data ?? [];

                // Lọc phòng
                if (widget.filterRoomId != null) {
                  bills = bills.where((b) {
                    final hopDong = b['hop_dong'];
                    final phong = hopDong?['phong'];
                    return phong?['id'] == widget.filterRoomId;
                  }).toList();
                }

                // Lọc trạng thái
                if (filterStatus != "all") {
                  bills =
                      bills.where((b) => b['trang_thai'] == filterStatus).toList();
                }

                // Lọc tháng
                if (filterMonth != "all") {
                  bills =
                      bills.where((b) => b['thang'] == filterMonth).toList();
                }

                if (bills.isEmpty) {
                  return const Center(
                    child: Text(
                      "Không có hóa đơn nào",
                      style: TextStyle(color: Colors.white70),
                    ),
                  );
                }

                return ListView.separated(
                  padding: const EdgeInsets.all(12),
                  itemCount: bills.length,
                  separatorBuilder: (_, __) => const SizedBox(height: 10),
                  itemBuilder: (context, i) {
                    final b = bills[i] as Map<String, dynamic>;

                    final id = b['id'];
                    final thang = b['thang'];
                    final trangThai = b['trang_thai'];
                    final tongTien = b['tong_tien'];
                    final quaHan = b['qua_han'] == true;

                    final roomName =
                        b['hop_dong']?['phong']?['so_phong']?.toString() ??
                            "Không rõ";

                    return Container(
                      decoration: BoxDecoration(
                        color: const Color(0xFF1C1C1C),
                        borderRadius: BorderRadius.circular(14),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.25),
                            blurRadius: 6,
                            offset: const Offset(0, 3),
                          )
                        ],
                      ),
                      child: ListTile(
                        contentPadding: const EdgeInsets.all(16),
                        title: Text(
                          "Tháng $thang",
                          style: const TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.w600,
                            fontSize: 16,
                          ),
                        ),
                        subtitle: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            const SizedBox(height: 6),
                            Text(
                              "Phòng: $roomName",
                              style: const TextStyle(color: Colors.white70),
                            ),
                            Text(
                              "Tổng: $tongTien đ",
                              style: const TextStyle(color: Colors.white70),
                            ),
                            if (quaHan)
                              const Text(
                                "Quá hạn thanh toán",
                                style: TextStyle(
                                    color: Colors.redAccent, fontSize: 12),
                              ),
                          ],
                        ),
                        trailing: Chip(
                          backgroundColor:
                              _statusColor(trangThai, quaHan).withOpacity(.9),
                          label: Text(
                            _mapTrangThaiLabel(trangThai),
                            style: const TextStyle(
                                color: Colors.white, fontWeight: FontWeight.bold),
                          ),
                        ),
                        onTap: () async {
                          final changed = await Navigator.push<bool>(
                            context,
                            MaterialPageRoute(
                              builder: (_) => BillDetailPage(billId: id),
                            ),
                          );

                          if (changed == true) {
                            setState(_reloadInvoices);
                          }
                        },
                      ),
                    );
                  },
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  // =================== DROPDOWN CUSTOM ===================
  Widget _dropdown({
    required String label,
    required String value,
    required List<DropdownMenuItem<String>> items,
    required Function(String?) onChanged,
  }) {
    return DropdownButtonFormField<String>(
      value: value,
      dropdownColor: const Color(0xFF1A1A1A),
      decoration: InputDecoration(
        labelText: label,
        labelStyle: const TextStyle(color: Colors.white70),
        filled: true,
        fillColor: const Color(0xFF121212),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: BorderSide(color: Colors.grey.shade800),
        ),
      ),
      style: const TextStyle(color: Colors.white),
      onChanged: onChanged,
      items: items,
    );
  }
}
