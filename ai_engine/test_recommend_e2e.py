import requests
import re
import sys

sys.stdout.reconfigure(encoding='utf-8')

session = requests.Session()
r_get = session.get('http://127.0.0.1:8001/bai-dang')
csrf_token = None
m = re.search(r'name="_token" value="([^"]+)"', r_get.text)
if m:
    csrf_token = m.group(1)
else:
    m2 = re.search(r'content="([^"]+)" name="csrf-token"', r_get.text)
    if m2:
        csrf_token = m2.group(1)

print('CSRF token found:', bool(csrf_token))

headers = {
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrf_token or ''
}

payload_normal = {
    '_token': csrf_token,
    'budget': 3500000,
    'strict_budget': '1',
    'area': 25,
    'people': 1,
    'dia_chi': 'Bình Thạnh',
    'dich_vu_id': '1,2,3'
}

res = session.post('http://127.0.0.1:8001/de-xuat-phong', data=payload_normal, headers=headers)
print('Normal request status:', res.status_code)
if res.status_code == 200:
    data = res.json()
    print('success:', data.get('success'))
    print('no_match:', data.get('no_match'))
    recs = data.get('recommendations', [])
    print('recs count:', len(recs))
    if recs:
        print('Rec #1:', recs[0].get('tieu_de'))
        print('Price:', recs[0].get('gia_hien_thi'))
        print('Score:', recs[0].get('satisfaction_score'))
        print('Explanations:', recs[0].get('explanations'))
        print('Constraint status:', recs[0].get('constraint_status'))
else:
    print('Response text:', res.text[:300])

payload_impossible = {
    '_token': csrf_token,
    'budget': 200000,
    'strict_budget': '1',
    'area': 25,
    'people': 10,
    'dia_chi': 'Quận 1',
    'strict_location': '1',
    'dich_vu_id': '1,2,3'
}

res2 = session.post('http://127.0.0.1:8001/de-xuat-phong', data=payload_impossible, headers=headers)
print('\nImpossible request status:', res2.status_code)
if res2.status_code == 200:
    data2 = res2.json()
    print('no_match:', data2.get('no_match'))
    print('no_match_data:', data2.get('no_match_data'))
else:
    print('Response2 text:', res2.text[:300])

# Test 3: Form submission with redirect (standard browser behavior)
print('\n--- TEST 3: Browser Form POST with Redirect ---')
session3 = requests.Session()
r3_get = session3.get('http://127.0.0.1:8001/bai-dang')
m3 = re.search(r'name="_token" value="([^"]+)"', r3_get.text)
t3 = m3.group(1) if m3 else csrf_token

r3_post = session3.post('http://127.0.0.1:8001/de-xuat-phong', data={
    '_token': t3,
    'budget': 3500000,
    'strict_budget': '1',
    'area': 25,
    'people': 1,
    'dia_chi': 'Bình Thạnh',
    'dich_vu_id': '1,2,3'
}, allow_redirects=True)

print('Final URL:', r3_post.url)
print('Final status:', r3_post.status_code)
print('Contains Top 3 heading:', 'Top 3 Phương Án Phòng Trọ Phù Hợp Nhất' in r3_post.text)
print('Contains Dueling DQN badge:', 'Dueling DQN' in r3_post.text)
print('Contains #1 Khuyên dùng badge:', '#1 Khuyên dùng' in r3_post.text)
print('Contains openCompareModal:', 'openCompareModal' in r3_post.text)
print('Contains Compare Table:', 'Bảng So Sánh Các Phương Án Đề Xuất' in r3_post.text)
print('Contains Factual Requirements:', 'Ràng buộc bắt buộc:' in r3_post.text)

# Test 4: Browser Form POST with impossible constraints and Redirect
print('\n--- TEST 4: Browser Form POST with Impossible Constraints (No-Match) ---')
session4 = requests.Session()
r4_get = session4.get('http://127.0.0.1:8001/bai-dang')
m4 = re.search(r'name="_token" value="([^"]+)"', r4_get.text)
t4 = m4.group(1) if m4 else csrf_token

r4_post = session4.post('http://127.0.0.1:8001/de-xuat-phong', data={
    '_token': t4,
    'budget': 200000,
    'strict_budget': '1',
    'area': 25,
    'people': 10,
    'dia_chi': 'Quận 1',
    'strict_location': '1',
    'dich_vu_id': '1,2,3'
}, allow_redirects=True)

print('Final URL:', r4_post.url)
print('Final status:', r4_post.status_code)
print('Contains No-Match heading:', 'Không Có Phòng Nào Thỏa Mãn 100% Tiêu Chí Bắt Buộc' in r4_post.text)
print('Contains Zero-Violation chip:', 'Kiểm định Zero-Violation' in r4_post.text)
print('Contains lock budget chip:', 'Khóa trần ngân sách' in r4_post.text)
print('Contains failure analysis:', 'Phân tích nguyên nhân & Hướng điều chỉnh đề xuất:' in r4_post.text)
