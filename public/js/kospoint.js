// Menu mobile dan tombol untuk melihat kata sandi.
document.addEventListener('DOMContentLoaded', function () {
    var tombolMenu = document.getElementById('tombol-menu');
    var menuMobile = document.getElementById('menu-mobile');

    if (tombolMenu && menuMobile) {
        tombolMenu.addEventListener('click', function () {
            menuMobile.classList.toggle('hidden');
            var terbuka = !menuMobile.classList.contains('hidden');
            tombolMenu.setAttribute('aria-expanded', terbuka ? 'true' : 'false');
            tombolMenu.setAttribute('aria-label', terbuka ? 'Tutup menu' : 'Buka menu');
        });
    }

    document.querySelectorAll('[data-lihat-sandi]').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            var input = document.getElementById(tombol.getAttribute('data-lihat-sandi'));
            if (!input) {
                return;
            }

            var sedangTertutup = input.type === 'password';
            input.type = sedangTertutup ? 'text' : 'password';
            tombol.setAttribute('aria-label', sedangTertutup ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
        });
    });
});
