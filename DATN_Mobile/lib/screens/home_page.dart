import 'package:flutter/material.dart';

import 'dashboard_page.dart';
import 'bills_page.dart';
import 'requests_page.dart';
import 'notifications_page.dart';
import 'profile_page.dart';
import '../services/api_service.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _idx = 0;
  int _unreadNoti = 0;

  @override
  void initState() {
    super.initState();
    _loadUnread();
  }

  Future<void> _loadUnread() async {
    try {
      final count = await ApiService.instance.getUnreadNotiCount();
      if (!mounted) return;
      setState(() => _unreadNoti = count);
    } catch (e) {
      debugPrint('Lỗi lấy số thông báo chưa đọc: $e');
    }
  }

  Widget _buildBody() {
    switch (_idx) {
      case 0:
        return const DashboardPage();
      case 1:
        return const BillsPage();
      case 2:
        return const RequestsPage();
      case 3:
        return NotificationsPage(
          onUnreadChanged: (count) {
            setState(() {
              _unreadNoti = count;
            });
          },
        );
      case 4:
      default:
        return const ProfilePage();
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: _buildBody(),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _idx,
        onTap: (i) {
          setState(() {
            _idx = i;
          });
          _loadUnread();
        },
        type: BottomNavigationBarType.fixed,
        items: [
          const BottomNavigationBarItem(
            icon: Icon(Icons.home_outlined),
            label: 'Trang chủ',
          ),
          const BottomNavigationBarItem(
            icon: Icon(Icons.receipt_long),
            label: 'Hóa đơn',
          ),
          const BottomNavigationBarItem(
            icon: Icon(Icons.build),
            label: 'Yêu cầu',
          ),
          BottomNavigationBarItem(
            icon: Stack(
              clipBehavior: Clip.none,
              children: [
                const Icon(Icons.notifications_none),
                if (_unreadNoti > 0)
                  Positioned(
                    right: -4,
                    top: -2,
                    child: Container(
                      padding: const EdgeInsets.all(2),
                      decoration: const BoxDecoration(
                        color: Colors.red,
                        shape: BoxShape.circle,
                      ),
                      constraints: const BoxConstraints(
                        minWidth: 16,
                        minHeight: 16,
                      ),
                      child: Center(
                        child: Text(
                          _unreadNoti > 99 ? '99+' : _unreadNoti.toString(),
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 10,
                          ),
                        ),
                      ),
                    ),
                  ),
              ],
            ),
            label: 'Thông báo',
          ),
          const BottomNavigationBarItem(
            icon: Icon(Icons.person_outline),
            label: 'Cá nhân',
          ),
        ],
      ),
    );
  }
}
