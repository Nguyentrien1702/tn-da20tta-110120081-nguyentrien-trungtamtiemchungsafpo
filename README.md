## Cách cài đặt 
  - Cài đặt PHP phiên bản 7.3 trở lên và Composer
  - Tải dự án từ github

          git clone https://github.com/Nguyentrien1702/tn-da20tta-110120081-nguyentrien-trungtamtiemchungsafpo.git
  - Cài đặt phần còn thiếu của dự án

          composer install
          composer update

  - Chạy dự án
    - Chạy lệnh sau để xóa symbolic link cũ trong thư mục public của Laravel 
   
           Remove-Item -Recurse -Force public\storage
    - Chạy lệnh sau để tạo ra một symbolic link mới trong thư mục public của Laravel
   
           php artisan storage:link
    - Chạy lệnh sau để tạo các bảng cơ sở dữ liệu
   
          php artisan migrate:fresh --seed
    - Chạy dự án laravel

          php artisan serve
    - Truy cập vào địa chỉ localhost vừa xuất hiện
   
          http://127.0.0.1:8000/

## Thông tin liên hệ tác giả
  - Họ tên: Nguyễn Triến
