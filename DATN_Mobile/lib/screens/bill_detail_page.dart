import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import '../services/api_service.dart';

class BillDetailPage extends StatelessWidget {
  final int billId;

  const BillDetailPage({super.key, required this.billId});

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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: const Text('Chi tiết hóa đơn'),
        centerTitle: true,
        backgroundColor: Colors.transparent,
        foregroundColor: Colors.white,
        elevation: 0,
      ),
      body: FutureBuilder<Map<String, dynamic>>(
        future: ApiService.instance.getInvoiceDetail(billId),
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
                'Không có dữ liệu hóa đơn',
                style: TextStyle(color: Colors.white70),
              ),
            );
          }

          final data = snapshot.data!;
          final phong = (data['phong'] ?? {}) as Map<String, dynamic>;
          final dayTro = (data['day_tro'] ?? {}) as Map<String, dynamic>;
          final chuTro = (data['chu_tro'] ?? {}) as Map<String, dynamic>;

          final chiTietDichVu =
              (data['chi_tiet_dich_vu'] as List? ?? []).cast<Map<String, dynamic>>();
          final chiTietDienNuoc =
              (data['chi_tiet_dien_nuoc'] as List? ?? []).cast<Map<String, dynamic>>();

          final thang = (data['thang'] ?? '').toString();
          final tongTien = _toNum(data['tong_tien']);
          final tienPhong = _toNum(data['tien_phong']);
          final tienDichVu = _toNum(data['tien_dich_vu']);
          final tienDongHo = _toNum(data['tien_dong_ho']);
          final daTra = _toNum(data['so_tien_da_tra']);
          final conLai = _toNum(data['so_tien_con_lai']);
          final trangThai = (data['trang_thai'] ?? '').toString();
          final hanThanhToan = (data['han_thanh_toan'] ?? '').toString();

          final soPhong = (phong['so_phong'] ?? 'N/A').toString();
          final noiDungCK =
              'Thanh toan tien tro phong $soPhong thang $thang (HD #${data['id']})';

          // ------------ TẠO LINK QR VIETQR -------------
          final bankCode = (chuTro['bank_code'] ?? '').toString();
          final accountNo = (chuTro['account_no'] ?? '').toString();
          final accountName = (chuTro['account_name'] ?? '').toString();

          String? qrUrl;
          if (bankCode.isNotEmpty && accountNo.isNotEmpty) {
            final base =
                'https://img.vietqr.io/image/$bankCode-$accountNo-compact.png';

            final query = <String, String>{
              'addInfo': noiDungCK,
              if (accountName.isNotEmpty) 'accountName': accountName,
            };

            if (conLai > 0) {
              query['amount'] = conLai.toInt().toString();
            }

            final q = Uri(queryParameters: query).query;
            qrUrl = '$base?$q';
          }

          // ------------------------------------------------

          return Padding(
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                // ====== Thông tin phòng + tháng ======
                Container(
                  padding: const EdgeInsets.all(16),
                  decoration: BoxDecoration(
                    color: Colors.grey.shade900,
                    borderRadius: BorderRadius.circular(16),
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        'Phòng $soPhong',
                        style: const TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          color: Colors.white,
                        ),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'Dãy trọ: ${dayTro['ten_day_tro'] ?? 'N/A'}',
                        style: const TextStyle(color: Colors.white70),
                      ),
                      Text(
                        'Địa chỉ: ${dayTro['dia_chi'] ?? 'N/A'}',
                        style: const TextStyle(color: Colors.white70),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'Tháng: $thang',
                        style: const TextStyle(color: Colors.white70),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'Hạn thanh toán: $hanThanhToan',
                        style: const TextStyle(color: Colors.orangeAccent),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'Trạng thái: ${_mapTrangThai(trangThai)}',
                        style: TextStyle(
                          color: _statusColor(trangThai),
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 16),

                // ====== Tổng kết tiền ======
                const Text(
                  'Thanh toán',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 8),
                _card(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      _rowText('Tổng tiền', _money(tongTien),
                          valueColor: Colors.white),
                      const SizedBox(height: 4),
                      _rowText('Đã thanh toán', _money(daTra),
                          valueColor: daTra > 0
                              ? Colors.greenAccent
                              : Colors.white70),
                      const SizedBox(height: 4),
                      _rowText('Còn phải trả', _money(conLai),
                          valueColor:
                              conLai > 0 ? Colors.redAccent : Colors.greenAccent),
                    ],
                  ),
                ),

                const SizedBox(height: 16),

                // ====== Tiền phòng ======
                const Text(
                  'Tiền phòng',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 8),
                _card(
                  child: _rowText('Tiền phòng hàng tháng', _money(tienPhong)),
                ),

                const SizedBox(height: 16),

                // ====== Điện / Nước ======
                const Text(
                  'Điện / Nước',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 8),
                _card(
                  child: chiTietDienNuoc.isEmpty
                      ? const Text(
                          'Không có dữ liệu đồng hồ',
                          style: TextStyle(color: Colors.white70),
                        )
                      : Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            for (final c in chiTietDienNuoc) ...[
                              Text(
                                '${c['ten_dich_vu'] ?? 'Dịch vụ'} '
                                '(${c['ma_dong_ho'] ?? 'Mã đồng hồ'})',
                                style: const TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                              const SizedBox(height: 4),
                              _rowText('Chỉ số cũ', '${c['chi_so_cu']}'),
                              _rowText('Chỉ số mới', '${c['chi_so_moi']}'),
                              _rowText('Sản lượng', '${c['san_luong']}'),
                              _rowText(
                                  'Đơn giá', _money(_toNum(c['don_gia']))),
                              _rowText(
                                'Thành tiền',
                                _money(_toNum(c['thanh_tien'])),
                                isBold: true,
                              ),
                              const SizedBox(height: 12),
                            ],
                            _rowText(
                              'Tổng tiền điện/nước',
                              _money(tienDongHo),
                              isBold: true,
                            ),
                          ],
                        ),
                ),

                const SizedBox(height: 16),

                // ====== Dịch vụ ======
                const Text(
                  'Dịch vụ',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 8),
                _card(
                  child: chiTietDichVu.isEmpty
                      ? const Text(
                          'Không có dịch vụ thêm',
                          style: TextStyle(color: Colors.white70),
                        )
                      : Column(
                          children: [
                            for (final dv in chiTietDichVu) ...[
                              _rowText(
                                dv['ten_dich_vu']?.toString() ?? 'Dịch vụ',
                                _money(_toNum(dv['thanh_tien'])),
                              ),
                              const SizedBox(height: 8),
                            ],
                            const Divider(color: Colors.white12),
                            _rowText(
                              'Tổng tiền dịch vụ',
                              _money(tienDichVu),
                              isBold: true,
                            ),
                          ],
                        ),
                ),

                const SizedBox(height: 16),

                // ====== Thông tin chuyển khoản + QR ======
                const Text(
                  'Thông tin chuyển khoản',
                  style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 8),
                _card(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      _rowText(
                        'Chủ trọ',
                        chuTro['ho_ten']?.toString() ?? 'Chưa cập nhật',
                      ),
                      _rowText(
                        'SĐT',
                        chuTro['so_dien_thoai']?.toString() ?? 'Chưa cập nhật',
                      ),
                      _rowText(
                        'Ngân hàng',
                        bankCode.isNotEmpty ? bankCode : '---',
                      ),
                      _rowText(
                        'Số tài khoản',
                        accountNo.isNotEmpty ? accountNo : '---',
                      ),
                      _rowText(
                        'Tên tài khoản',
                        accountName.isNotEmpty ? accountName : '---',
                      ),
                      const SizedBox(height: 12),
                      const Text(
                        'Nội dung chuyển khoản gợi ý:',
                        style: TextStyle(
                          color: Colors.white70,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                      const SizedBox(height: 4),
                      Container(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 8, vertical: 6),
                        decoration: BoxDecoration(
                          color: Colors.black26,
                          borderRadius: BorderRadius.circular(8),
                        ),
                        child: Row(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Expanded(
                              child: Text(
                                noiDungCK,
                                style: const TextStyle(
                                  color: Colors.white,
                                  fontSize: 13,
                                ),
                              ),
                            ),
                            IconButton(
                              tooltip: 'Sao chép',
                              onPressed: () async {
                                await Clipboard.setData(
                                  ClipboardData(text: noiDungCK),
                                );
                                if (context.mounted) {
                                  ScaffoldMessenger.of(context).showSnackBar(
                                    const SnackBar(
                                      content: Text('Đã sao chép nội dung.'),
                                    ),
                                  );
                                }
                              },
                              icon: const Icon(
                                Icons.copy,
                                size: 18,
                                color: Colors.white70,
                              ),
                            ),
                          ],
                        ),
                      ),

                      const SizedBox(height: 16),

                      // ====== QR thanh toán ======
                      if (qrUrl != null) ...[
                        const Text(
                          'QR thanh toán (VietQR):',
                          style: TextStyle(
                            color: Colors.white70,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                        const SizedBox(height: 8),
                        ClipRRect(
                          borderRadius: BorderRadius.circular(12),
                          child: AspectRatio(
                            aspectRatio: 1,
                            child: Image.network(
                              qrUrl!,
                              fit: BoxFit.contain,
                              errorBuilder: (_, __, ___) => const Center(
                                child: Text(
                                  'Không tải được mã QR',
                                  style: TextStyle(color: Colors.white54),
                                ),
                              ),
                            ),
                          ),
                        ),
                      ] else ...[
                        const Text(
                          'Chưa có đủ thông tin để tạo mã QR.',
                          style: TextStyle(color: Colors.white54),
                        ),
                      ],
                    ],
                  ),
                ),

                const SizedBox(height: 24),

                // ====== Nút hành động ======
                Row(
                  children: [
                    Expanded(
                      child: ElevatedButton.icon(
                        onPressed: conLai <= 0
                            ? null
                            : () => _showPayDialog(
                                  context,
                                  hoaDonId: billId,
                                  conLai: conLai,
                                  suggestContent: noiDungCK,
                                ),
                        icon: const Icon(Icons.payments_outlined),
                        label: const Text('Thanh toán'),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: OutlinedButton.icon(
                        onPressed: () async {
                          try {
                            await ApiService.instance.confirmInvoicePayment(billId);
                            if (context.mounted) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                const SnackBar(
                                  content: Text('Đã gửi xác nhận thanh toán cho chủ trọ.'),
                                ),
                              );
                              Navigator.pop(context, true);
                            }
                          } catch (e) {
                            if (context.mounted) {
                              ScaffoldMessenger.of(context).showSnackBar(
                                SnackBar(content: Text('Lỗi: $e')),
                              );
                            }
                          }
                        },
                        icon: const Icon(Icons.verified_outlined),
                        label: const Text('Tôi đã chuyển khoản'),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          );
        },
      ),
    );
  }

  // ========== widget phụ giống trước ==========

  Widget _card({required Widget child}) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.grey.shade900,
        borderRadius: BorderRadius.circular(16),
      ),
      child: child,
    );
  }

  Widget _rowText(String label, String value,
      {bool isBold = false, Color? valueColor}) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          label,
          style: const TextStyle(color: Colors.white70, fontSize: 14),
        ),
        const SizedBox(width: 8),
        Flexible(
          child: Text(
            value,
            textAlign: TextAlign.right,
            overflow: TextOverflow.ellipsis,
            style: TextStyle(
              color: valueColor ?? Colors.white,
              fontSize: 14,
              fontWeight: isBold ? FontWeight.bold : FontWeight.normal,
            ),
          ),
        ),
      ],
    );
  }

  String _mapTrangThai(String t) {
    switch (t) {
      case 'da_thanh_toan':
        return 'Đã thanh toán';
      case 'cho_xac_nhan':
        return 'Chờ xác nhận';
      case 'chua_thanh_toan':
        return 'Chưa thanh toán';
      case 'mot_phan':
        return 'Thanh toán một phần';
      default:
        return t;
    }
  }

  Color _statusColor(String t) {
    switch (t) {
      case 'da_thanh_toan':
        return Colors.greenAccent;
      case 'cho_xac_nhan':
        return Colors.orangeAccent;
      case 'chua_thanh_toan':
        return Colors.redAccent;
      case 'mot_phan':
        return Colors.yellowAccent;
      default:
        return Colors.white;
    }
  }

  // ===== Dialog thanh toán =====
  void _showPayDialog(
    BuildContext context, {
    required int hoaDonId,
    required num conLai,
    required String suggestContent,
  }) {
    final amountController =
        TextEditingController(text: conLai.toStringAsFixed(0));

    showDialog(
      context: context,
      builder: (_) {
        return AlertDialog(
          backgroundColor: Colors.grey.shade900,
          title: const Text(
            'Ghi nhận thanh toán',
            style: TextStyle(color: Colors.white),
          ),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              TextField(
                controller: amountController,
                keyboardType: TextInputType.number,
                style: const TextStyle(color: Colors.white),
                decoration: const InputDecoration(
                  labelText: 'Số tiền thanh toán',
                  labelStyle: TextStyle(color: Colors.white70),
                ),
              ),
              const SizedBox(height: 12),
              Align(
                alignment: Alignment.centerLeft,
                child: Text(
                  'Nội dung chuyển khoản (gợi ý):',
                  style: const TextStyle(color: Colors.white70, fontSize: 13),
                ),
              ),
              const SizedBox(height: 4),
              Container(
                padding:
                    const EdgeInsets.symmetric(horizontal: 8, vertical: 6),
                decoration: BoxDecoration(
                  color: Colors.black26,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Row(
                  children: [
                    Expanded(
                      child: Text(
                        suggestContent,
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 12,
                        ),
                      ),
                    ),
                    IconButton(
                      tooltip: 'Sao chép',
                      onPressed: () async {
                        await Clipboard.setData(
                            ClipboardData(text: suggestContent));
                        if (context.mounted) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(
                              content: Text('Đã sao chép nội dung.'),
                            ),
                          );
                        }
                      },
                      icon: const Icon(Icons.copy, color: Colors.white70),
                    )
                  ],
                ),
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Hủy'),
            ),
            ElevatedButton(
              onPressed: () async {
                final raw = amountController.text.trim();
                final cleaned = raw.replaceAll('.', '').replaceAll(',', '');
                final amount = (num.tryParse(cleaned) ?? 0).toInt();
                if (amount <= 0) {
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(
                      content: Text('Số tiền phải lớn hơn 0'),
                    ),
                  );
                  return;
                }
                try {
                  await ApiService.instance.createPayment(
                    hoaDonId: hoaDonId,
                    amount: amount,
                    method: 'chuyen_khoan',
                  );
                  if (context.mounted) {
                    Navigator.pop(context);
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(
                        content: Text(
                          'Đã ghi nhận thanh toán ${_money(amount)}.',
                        ),
                      ),
                    );
                  }
                } catch (e) {
                  if (context.mounted) {
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text('Lỗi: $e')),
                    );
                  }
                }
              },
              child: const Text('Ghi nhận'),
            ),
          ],
        );
      },
    );
  }
}
