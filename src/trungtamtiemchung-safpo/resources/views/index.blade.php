@include("menu/header")
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
.carousel-inner img {
    width: 100%;
    height: 100%;
}
.position-relative {
    position: relative;
}

.overlay-text {
    width: 100%;
    color: #b30e0e; /* Dark red color */
    font-size: 20px; /* Adjust the font size as needed */
    font-weight: bold;
    background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent background */
    padding: 10px 20px;
    border-radius: 5px;
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.div_sp{
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.div_sp h5, a{
    font-weight: bold;

}
.product-item {
    transition: transform 0.3s, box-shadow 0.3s;
}
.product-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}
.product-item img {
    transition: transform 0.3s;
}
.product-item:hover img {
    transform: scale(1.05);
}
#trangchu{
    background-color: blue !important;
}
#trangchu a{
    color: white !important;
}
#motabv{
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit to 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-align: left;
}
</style>

<div id="banner" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        // Lấy thông tin kết nối từ biến môi trường
        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        try {
            // Tạo kết nối PDO sử dụng thông tin từ biến môi trường
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Truy vấn dữ liệu từ bảng images
            $stmt = $pdo->query('SELECT hinhanh FROM banner ORDER BY mabanner DESC');
            $banner = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo '';
        }
        ?>
        @if (!empty($banner))
        @foreach ($banner as $key => $image)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ asset($image->hinhanh) }}" width="1100" height="500">
        </div>
        @endforeach
        @endif
    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#banner" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#banner" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<div class="p" style="padding:30px 0">
    <div class="div_sp">
        <div><h5>DANH MỤC SẢN PHẨM</h5></div>
        <div><i><a href="{{ url('/Danh-sach-san-pham') }}">Xem tất cả</a></i></div>
    </div>
    <hr style="font-size: 3px;">
    <div>
        <div class="row mt-3" >
            @foreach ($dstcvaccine as $vaccine)
            @php
                $index = 1;
            @endphp
            @if($index % 4 == 0 && $index != 0)
                </div><div class="row">
            @endif
                <div class="col-md-3 product-item" style="text-align: center;">
                    <a href="{{ url('/ct-vaccine', $vaccine->mavc) }}">
                        <img style="width: 280px" src="{{ asset($vaccine->hinhanhvc) }}" alt="">
                        {{ $vaccine->tenvc }} ({{ $vaccine->nuocsx}})
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="p" style="padding:30px 0">
    <div class="div_sp">
        <div><h5>TIN TỨC</h5></div>
        <div><i><a href="{{ url('/Tin-tuc') }}">Xem tất cả</a></i></div>
    </div>
    <hr style="font-size: 3px;">
    <div>
        <div class="row mt-3" >
            @foreach ($tintucs as $tintuc)
            @php
                $index = 1;
            @endphp
            @if($index % 4 == 0 && $index != 0)
                </div><div class="row">
            @endif
                <div class="col-md-3 product-item" style="text-align: center; max-height: 350px; overflow: hidden;" >
                    <a href="{{ url('/post', $tintuc->mabaiviet) }}">
                        <img style="width: 280px" src="{{ asset($tintuc->hinhanhminhhoa) }}" alt="">
                        {{ $tintuc->tenbaiviet }}
                    </a>
                    <hr>
                    <p id="motabv">{{ $tintuc->motabaiviet }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="p" style="padding:30px 0">
    <div class="div_sp">
        <div><h5>BỆNH HỌC</h5></div>
        <div><i><a href="{{ url('/Tin-tuc') }}">Xem tất cả</a></i></div>
    </div>
    <hr style="font-size: 3px;">
    <div>
        <div class="row" >
            @foreach ($benhhocs as $benhhoc)
            @php
                $index = 1;
            @endphp
            @if($index % 4 == 0 && $index != 0)
                </div><div class="row">
            @endif
                <div class="col-md-3 product-item" style="text-align: center; max-height: 350px; overflow: hidden;" >
                    <a href="{{ url('/post', $benhhoc->mabaiviet) }}">
                        <img style="width: 280px" src="{{ asset($benhhoc->hinhanhminhhoa) }}" alt="">
                        {{ $benhhoc->tenbaiviet }}
                    </a>
                    <hr>
                    <p id="motabv">{{ $benhhoc->motabaiviet }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@include("menu/footer");
</body>

</html>