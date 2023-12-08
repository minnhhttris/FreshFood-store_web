(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(window).width() < 992) {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow');
            } else {
                $('.fixed-top').removeClass('bg-white shadow');
            }
        } 
        else {
            if ($(this).scrollTop() > 45) {
                $('.fixed-top').addClass('bg-white shadow').css('top', 0);
            } else {
                $('.fixed-top').removeClass('bg-white shadow').css('top', 0);
            }
        }
    });


    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage !== null && successMessage.value !== "Product created successfully!") {
            alert(successMessage.value);
        }
    });


  
})(jQuery);

    // Navbar
    const navLinks = document.querySelectorAll('.navbar-nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Loại bỏ lớp "active" từ tất cả các liên kết
            navLinks.forEach(item => item.classList.remove('active'));
            // Thêm lớp "active" cho liên kết được chọn
            link.classList.add('active');
            // Lưu trạng thái "active" vào Local Storage
            localStorage.setItem('activeLink', link.getAttribute('href'));
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const activeLink = localStorage.getItem('activeLink');
        if (activeLink) {
            const activeNavlink = document.querySelector(`.navbar-nav a[href="${activeLink}"]`);
            if (activeNavlink) {
                activeNavlink.classList.add('active');
            }
        }
    });

    // List product
    $(document).ready(function() {
        var activeButton = localStorage.getItem('activeButton');
    
        // Mặc định nếu không có nút "active" được lưu trong Local Storage
        if (!activeButton) {
            // Đặt nút "Vegetable" làm mặc định "active"
            activeButton = '/public/product.php';
            localStorage.setItem('activeButton', activeButton);
        }
    
        // Tìm nút "active" dựa trên giá trị trong Local Storage và đặt lại class "btn-active"
        $("a[href='" + activeButton + "']").addClass("btn-active");
    
        // Xử lý sự kiện click cho tất cả nút
        $("a[href='/public/product.php'], a[href='/public/product.php?type=Vegetable'], a[href='/public/product.php?type=Fruit']").click(function() {
            // Lấy giá trị "active" trước đó từ Local Storage
            var previousActiveButton = localStorage.getItem('activeButton');
    
            // Loại bỏ class btn-active khỏi nút "active" trước đó (nếu có)
            $("a[href='" + previousActiveButton + "']").removeClass("btn-active");
    
            $(this).addClass("btn-active");
    
            // Lưu trạng thái "active" của nút vào Local Storage
            localStorage.setItem('activeButton', $(this).attr('href'));
        });

});



