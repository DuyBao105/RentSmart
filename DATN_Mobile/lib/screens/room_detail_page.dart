import 'package:flutter/material.dart';

class RoomDetailPage extends StatelessWidget {
  const RoomDetailPage({super.key});

  @override
  Widget build(BuildContext context) {
    // TODO: sau này truyền data phòng vào constructor
    const roomName = 'Phòng B2';
    const area = '20 m²';
    const price = '2.600.000 đ/tháng';
    const maxPeople = 2;
    const status = 'Đang thuê';

    return Scaffold(
      appBar: AppBar(
        title: const Text('Thông tin phòng'),
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: ListView(
          children: [
            Container(
              padding: const EdgeInsets.all(16),
              decoration: BoxDecoration(
                color: Colors.blueGrey.shade900,
                borderRadius: BorderRadius.circular(16),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: const [
                  Text(
                    roomName,
                    style: TextStyle(
                      fontSize: 20,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  SizedBox(height: 8),
                  Text('Diện tích: $area'),
                  SizedBox(height: 4),
                  Text('Giá: $price'),
                  SizedBox(height: 4),
                  Text('Số người tối đa: $maxPeople'),
                  SizedBox(height: 4),
                  Text('Trạng thái: $status'),
                ],
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              'Ghi chú / Nội quy',
              style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
            ),
            const SizedBox(height: 8),
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.blueGrey.shade900,
                borderRadius: BorderRadius.circular(12),
              ),
              child: const Text(
                '- Không nuôi thú cưng\n'
                '- Không làm ồn sau 22h\n'
                '- Giữ vệ sinh chung hành lang, nhà xe',
              ),
            ),
          ],
        ),
      ),
    );
  }
}
