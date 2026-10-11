class Billing {
  final int id;
  final int roomId;
  final String roomName;
  final String month;
  final int total;
  final String status; // 'Đã thanh toán' / 'Chưa thanh toán'

  Billing({
    required this.id,
    required this.roomId,
    required this.roomName,
    required this.month,
    required this.total,
    required this.status,
  });
}

class RoomSummary {
  final int id;
  final String name;
  final String? note;    // ví dụ: 'Phòng mình', 'Phòng em gái'
  final int currentDue;  // tiền chưa thanh toán của phòng này

  RoomSummary({
    required this.id,
    required this.name,
    this.note,
    required this.currentDue,
  });
}

