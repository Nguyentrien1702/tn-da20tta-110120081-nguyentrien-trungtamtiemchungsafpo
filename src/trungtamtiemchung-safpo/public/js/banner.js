document.addEventListener('DOMContentLoaded', function() {
    const slideWrapper = document.querySelector('.slide-wrapper');
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    // Hiển thị slide đầu tiên khi tải trang
    showSlide(currentSlide);

    // Hàm hiển thị slide theo chỉ số
    function showSlide(index) {
        // Chỉnh vị trí của slideWrapper để hiển thị slide tại chỉ số index
        slideWrapper.style.transform = `translateX(-${index * 100}%)`;
        currentSlide = index;
    }

    // Hàm chuyển đến slide tiếp theo
    function next() {
        currentSlide++;
        if (currentSlide >= slides.length) {
            currentSlide = 0; // Quay lại slide đầu nếu đang ở slide cuối cùng
        }
        showSlide(currentSlide);
    }

    // Hàm chuyển đến slide trước đó
    function prev() {
        currentSlide--;
        if (currentSlide < 0) {
            currentSlide = slides.length - 1; // Quay lại slide cuối nếu đang ở slide đầu
        }
        showSlide(currentSlide);
    }

    // Gọi hàm next khi click vào nút Next
    document.querySelector('.next').addEventListener('click', next);

    // Gọi hàm prev khi click vào nút Previous
    document.querySelector('.prev').addEventListener('click', prev);

    // Tự động chuyển slide sau mỗi 5 giây (5000 milliseconds)
    setInterval(next, 5000);
});
