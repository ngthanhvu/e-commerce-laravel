<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.sidebar .nav-link');

        function removeActive() {
            navLinks.forEach(link => {
                link.classList.remove('active');
            });
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Chỉ thực hiện nếu đây là liên kết bình thường
                if (this.getAttribute('data-bs-toggle') === 'collapse') {
                    return;
                }

                removeActive();
                this.classList.add('active');

                // Thêm hash vào URL khi nhấp vào các liên kết trong sidebar
                const href = this.getAttribute('href');
                window.location.href = href; // Điều hướng đến URL mới bao gồm hash
            });
        });

        function setActiveFromHash() {
            const hash = window.location.hash;
            if (hash) {
                removeActive();
                const targetLink = document.querySelector(`.sidebar .nav-link[href*="${hash}"]`);
                if (targetLink) {
                    targetLink.classList.add('active');
                }
            } else {
                removeActive();
                document.querySelector('.sidebar .nav-link').classList.add('active');
            }
        }

        setActiveFromHash();
        window.addEventListener('hashchange', setActiveFromHash);
    });
    document.addEventListener("DOMContentLoaded", function() {
        const loadingSpinner = document.getElementById("loading-spinner");

        function showLoading() {
            loadingSpinner.classList.add("show");
        }

        function hideLoading() {
            loadingSpinner.classList.remove("show");
        }
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function(e) {
                const href = this.getAttribute("href");
                if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
                    showLoading();
                }
            });
        });
        window.addEventListener("pageshow", hideLoading);
    });
</script>
