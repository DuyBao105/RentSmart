import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';
import '../models/ContractModel.dart';
import '../services/api_service.dart';

class ContractsPage extends StatefulWidget {
  const ContractsPage({super.key});

  @override
  State<ContractsPage> createState() => _ContractsPageState();
}

class _ContractsPageState extends State<ContractsPage> {
  bool loading = true;
  List<ContractModel> contracts = [];

  @override
  void initState() {
    super.initState();
    loadContracts();
  }

  Future<void> loadContracts() async {
    try {
      final result = await ApiService.instance.getMyContracts();
      setState(() {
        contracts = result;
        loading = false;
      });
    } catch (e) {
      setState(() => loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      appBar: AppBar(
        title: const Text('Hợp đồng thuê'),
        centerTitle: true,
        backgroundColor: Colors.black,
      ),
      body: loading
          ? const Center(
              child: CircularProgressIndicator(color: Colors.white),
            )
          : contracts.isEmpty
              ? const Center(
                  child: Text(
                    'Bạn chưa có hợp đồng thuê.',
                    style: TextStyle(color: Colors.white70),
                  ),
                )
              : ListView.separated(
                  padding: const EdgeInsets.all(16),
                  itemCount: contracts.length,
                  separatorBuilder: (_, __) => const SizedBox(height: 16),
                  itemBuilder: (context, i) {
                    final c = contracts[i];
                    final active = c.isActive;

                    return Container(
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: const Color(0xFF1E1E1E),
                        borderRadius: BorderRadius.circular(18),
                        border: Border.all(
                          color: Colors.grey.shade800,
                          width: 1.2,
                        ),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.35),
                            blurRadius: 10,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          // Tên phòng
                          Text(
                            "Phòng ${c.roomName}",
                            style: const TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),

                          const SizedBox(height: 6),

                          // Ngày bắt đầu - kết thúc
                          Text(
                            "Ngày bắt đầu: ${c.startDate}",
                            style: TextStyle(
                              fontSize: 14,
                              color: Colors.grey.shade300,
                            ),
                          ),
                          Text(
                            "Ngày kết thúc: ${c.endDate}",
                            style: TextStyle(
                              fontSize: 14,
                              color: Colors.grey.shade300,
                            ),
                          ),

                          const SizedBox(height: 14),

                          // Badge trạng thái
                          Container(
                            padding: const EdgeInsets.symmetric(
                                vertical: 8, horizontal: 16),
                            decoration: BoxDecoration(
                              color: active
                                  ? const Color(0xFF00C853)
                                  : const Color(0xFFE53935),
                              borderRadius: BorderRadius.circular(14),
                              boxShadow: [
                                BoxShadow(
                                  color: active
                                      ? const Color(0xFF00C853)
                                          .withOpacity(0.4)
                                      : const Color(0xFFE53935)
                                          .withOpacity(0.4),
                                  blurRadius: 10,
                                  offset: const Offset(0, 3),
                                ),
                              ],
                            ),
                            child: Text(
                              active ? "Còn hiệu lực" : "Hết hiệu lực",
                              style: const TextStyle(
                                color: Colors.white,
                                fontWeight: FontWeight.w600,
                              ),
                            ),
                          ),

                          // Nút xem file hợp đồng PDF
                          if (c.fileUrl != null) ...[
                            const SizedBox(height: 12),
                            TextButton.icon(
                              onPressed: () {
                                launchUrl(Uri.parse(c.fileUrl!),
                                    mode: LaunchMode.externalApplication);
                              },
                              icon: const Icon(
                                Icons.picture_as_pdf,
                                color: Colors.redAccent,
                              ),
                              label: const Text(
                                "Xem hợp đồng",
                                style: TextStyle(
                                  color: Colors.redAccent,
                                  fontSize: 14,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                            ),
                          ],
                        ],
                      ),
                    );
                  },
                ),
    );
  }
}
