class ContractModel {
  final int id;
  final String roomName;
  final String startDate;
  final String endDate;
  final String status;
  final String? fileUrl;

  ContractModel({
    required this.id,
    required this.roomName,
    required this.startDate,
    required this.endDate,
    required this.status,
    required this.fileUrl,
  });

  // ---- FORMAT NGÀY DD/MM/YYYY ----
  static String _fmt(String raw) {
    try {
      final dt = DateTime.parse(raw);
      return "${dt.day.toString().padLeft(2, '0')}/"
             "${dt.month.toString().padLeft(2, '0')}/"
             "${dt.year}";
    } catch (_) {
      return raw;
    }
  }

  factory ContractModel.fromJson(Map<String, dynamic> json) {
    return ContractModel(
      id: json['id'],
      roomName: json['phong']?['so_phong'] ?? 'N/A',
      startDate: _fmt(json['ngay_bat_dau']),
      endDate: _fmt(json['ngay_ket_thuc']),
      status: json['trang_thai'] ?? '',
      fileUrl: json['url_file_hop_dong'],
    );
  }

  bool get isActive => status == "hieu_luc";
}
