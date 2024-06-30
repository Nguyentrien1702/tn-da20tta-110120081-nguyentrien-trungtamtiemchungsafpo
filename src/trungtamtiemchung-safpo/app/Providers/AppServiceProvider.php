<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sử dụng View Composer để chia sẻ dữ liệu danh sách bài viết với mọi view
        View::composer('*', function ($view) {
            // Lấy danh sách bài viết từ cơ sở dữ liệu
            try {
                // Lấy danh sách bài viết từ cơ sở dữ liệu
                $posts = DB::table('baiviet')
                    ->where('loaibaiviet', 1)
                    ->orderBy('ngaydangtai', 'desc') // Sắp xếp theo ngày đăng tải giảm dần
                    ->take(5) // Giới hạn chỉ lấy 5 bài viết
                    ->get();
            } catch (\Exception $e) {
                // Xử lý lỗi khi không kết nối được cơ sở dữ liệu
                $posts = collect(); // Trả về một collection rỗng
            }
        
            // Chia sẻ danh sách bài viết với mọi view
            $view->with('posts', $posts);
        });

        View::composer('*', function ($view) {
            
            try {
                // Lấy danh sách bài viết từ cơ sở dữ liệu
                $dsbaiviets = DB::table('baiviet')
                ->join('benh_nhombenh', 'benh_nhombenh.mabenh_nhombenh', '=', 'baiviet.mabenh_nhombenh')
                ->select('baiviet.*', 'benh_nhombenh.*')
                ->orderBy('ngaydangtai', 'desc')
                ->paginate(7);
            }catch (\Exception $e) {
                // Xử lý lỗi khi không kết nối được cơ sở dữ liệu
                $dsbaiviets = collect(); // Trả về một collection rỗng
            }

            // Chia sẻ danh sách bài viết với mọi view
            $view->with('dsbaiviets', $dsbaiviets);
        });

        View::composer('*', function ($view) {
            
            try {
                // Lấy danh sách bài viết từ cơ sở dữ liệu
                $dstcvaccine = DB::table('vaccine')->take(8)->get();
            }catch (\Exception $e) {
                // Xử lý lỗi khi không kết nối được cơ sở dữ liệu
                $dstcvaccine = collect(); // Trả về một collection rỗng
            }

            // Chia sẻ danh sách bài viết với mọi view
            $view->with('dstcvaccine', $dstcvaccine);
        });


        // Tin tức
        View::composer('*', function ($view) {
            // Lấy danh sách bài viết từ cơ sở dữ liệu
            try {
                // Lấy danh sách bài viết từ cơ sở dữ liệu
                $tintucs = DB::table('baiviet')
                    ->where('loaibaiviet', 1)
                    ->orderBy('ngaydangtai', 'desc') // Sắp xếp theo ngày đăng tải giảm dần
                    ->take(4) // Giới hạn chỉ lấy 5 bài viết
                    ->get();
            } catch (\Exception $e) {
                // Xử lý lỗi khi không kết nối được cơ sở dữ liệu
                $tintucs = collect(); // Trả về một collection rỗng
            }
        
            // Chia sẻ danh sách bài viết với mọi view
            $view->with('tintucs', $tintucs);
        });
        // Bệnh học
        View::composer('*', function ($view) {
            // Lấy danh sách bài viết từ cơ sở dữ liệu
            try {
                // Lấy danh sách bài viết từ cơ sở dữ liệu
                $benhhocs = DB::table('baiviet')
                    ->where('loaibaiviet', 2)
                    ->orderBy('ngaydangtai', 'desc') // Sắp xếp theo ngày đăng tải giảm dần
                    ->take(5) // Giới hạn chỉ lấy 5 bài viết
                    ->get();
            } catch (\Exception $e) {
                // Xử lý lỗi khi không kết nối được cơ sở dữ liệu
                $benhhocs = collect(); // Trả về một collection rỗng
            }
        
            // Chia sẻ danh sách bài viết với mọi view
            $view->with('benhhocs', $benhhocs);
        });

        
    }
}
