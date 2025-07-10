#!/bin/bash

# Cổng Laravel chạy
PORT=8000

# Chạy Laravel ngầm
php artisan serve --port=$PORT > /dev/null 2>&1 &
LARAVEL_PID=$!
echo "🚀 Laravel đang chạy trên cổng $PORT (PID: $LARAVEL_PID)"

# Đợi Laravel khởi động
sleep 2

# Chạy ngrok ngầm
ngrok http $PORT > /dev/null 2>&1 &
NGROK_PID=$!
echo "🌐 Đang khởi động ngrok..."

# Đợi ngrok khởi động
sleep 3

# Lấy URL public của ngrok
NGROK_URL=$(curl -s http://localhost:4040/api/tunnels | grep -o 'https://[^"]*' | head -n 1)

# Kiểm tra URL lấy được
if [ -z "$NGROK_URL" ]; then
  echo "❌ Không lấy được URL từ ngrok. Kiểm tra lại cổng hoặc cài đặt ngrok!"
  kill $NGROK_PID
  kill $LARAVEL_PID
  exit 1
fi

echo "✅ Ngrok URL: $NGROK_URL"

# Cập nhật APP_URL trong file .env
cp .env .env.bak
sed -i "s|^APP_URL=.*|APP_URL=${NGROK_URL}|" .env
echo "✅ Đã cập nhật APP_URL trong file .env thành: $NGROK_URL"

# Clear config Laravel
php artisan config:clear
echo "🔁 Đã chạy: php artisan config:clear"

echo ""
echo "🌐 Truy cập website tại: $NGROK_URL"
echo "📦 Laravel PID: $LARAVEL_PID | 🌐 Ngrok PID: $NGROK_PID"
echo "⏳ Nhấn Ctrl+C để dừng cả Laravel và Ngrok..."

# Giữ tiến trình cho đến khi Ctrl+C
trap "kill $NGROK_PID $LARAVEL_PID; echo '🛑 Đã dừng ngrok và Laravel'; exit" INT
wait
