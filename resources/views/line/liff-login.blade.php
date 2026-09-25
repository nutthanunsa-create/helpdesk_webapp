<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ผูกบัญชี ITDeskService</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md" id="login-container" style="display: none;">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">ผูกบัญชีระบบ ITDeskService</h1>
            <p class="text-gray-500 mt-2">กรุณาเข้าสู่ระบบเพื่อเชื่อมต่อกับ LINE</p>
        </div>

        <div id="alert-message" class="hidden mb-4 p-4 rounded-md"></div>

        <form id="login-form">
            <input type="hidden" id="line_user_id" name="line_user_id">
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">อีเมล (Email)</label>
                <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน (Password)</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <button type="submit" id="submit-btn" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                เข้าสู่ระบบ และผูกบัญชี
            </button>
        </form>
    </div>
    
    <div id="loading" class="text-center">
        <p class="text-gray-600">กำลังโหลดข้อมูลจาก LINE...</p>
    </div>

    <script>
        const liffId = "{{ env('LINE_LIFF_ID') }}";

        async function main() {
            try {
                await liff.init({ liffId: liffId });
                
                if (liff.isLoggedIn()) {
                    const profile = await liff.getProfile();
                    document.getElementById('line_user_id').value = profile.userId;
                    
                    // Show login form
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('login-container').style.display = 'block';
                } else {
                    liff.login();
                }
            } catch (err) {
                console.error('LIFF Initialization failed', err);
                document.getElementById('loading').innerHTML = '<p class="text-red-500">เกิดข้อผิดพลาดในการโหลด LIFF</p>';
            }
        }

        if (liffId) {
            main();
        } else {
            document.getElementById('loading').innerHTML = '<p class="text-red-500">ยังไม่ได้ตั้งค่า LINE_LIFF_ID ในระบบ</p>';
        }

        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('submit-btn');
            const alertMsg = document.getElementById('alert-message');
            
            btn.disabled = true;
            btn.innerHTML = 'กำลังประมวลผล...';
            alertMsg.classList.add('hidden');

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const lineUserId = document.getElementById('line_user_id').value;

            try {
                const response = await fetch('/line/link-account', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password,
                        line_user_id: lineUserId
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alertMsg.textContent = data.message;
                    alertMsg.className = 'mb-4 p-4 rounded-md bg-green-100 text-green-700';
                    alertMsg.classList.remove('hidden');
                    
                    btn.innerHTML = 'ผูกบัญชีสำเร็จ! (กำลังปิดหน้าต่าง)';
                    
                    // Close LIFF window after 2 seconds
                    setTimeout(() => {
                        liff.closeWindow();
                    }, 2000);
                } else {
                    throw new Error(data.message || 'การผูกบัญชีล้มเหลว');
                }
            } catch (error) {
                alertMsg.textContent = error.message;
                alertMsg.className = 'mb-4 p-4 rounded-md bg-red-100 text-red-700';
                alertMsg.classList.remove('hidden');
                
                btn.disabled = false;
                btn.innerHTML = 'เข้าสู่ระบบ และผูกบัญชี';
            }
        });
    </script>
</body>
</html>
