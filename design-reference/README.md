# KOSPOINT — Design Reference

Folder ini berisi referensi visual hasil ekstraksi dari dokumen DOCX mockup KOSPOINT.

## Isi folder
- `desktop-web/`: mockup gambar 01–13.
- `mobile-app/`: mockup gambar 14–31.
- `../docs/mockup-kospoint-original.docx`: dokumen sumber asli.

Pengelompokan berdasarkan urutan gambar di dokumen dan tampilan pada contact sheet. Periksa setiap gambar sebelum menentukan halaman/fitur yang diwakili; jangan mengasumsikan nama file sebagai nama route Laravel.

## Aturan penggunaan untuk AI Agent
1. Gunakan mockup sebagai referensi visual, bukan aset produksi website.
2. Pertahankan satu identitas visual KOSPOINT: dominan hijau dan putih, tampilan bersih, komponen konsisten.
3. Kembangkan desain seperlunya agar responsif untuk desktop dan mobile, tetapi jangan menghilangkan konsep atau informasi penting dari mockup.
4. Cocokkan setiap mockup dengan halaman dan fitur yang benar-benar ada di project Laravel.
5. Jangan mengarang halaman, data, tombol, atau fitur yang tidak didukung project.
6. Jangan mengubah route, controller, model, migration, database, autentikasi, middleware, atau logika bisnis tanpa persetujuan.
7. Sebelum mengedit, buat inventaris halaman dan tabel pemetaan: mockup → halaman/route/template yang ada.
8. Kerjakan bertahap, jelaskan file yang diubah, dan uji desktop serta mobile.
9. Jangan menaruh gambar referensi ini di `public/` atau menggunakannya sebagai gambar konten website. Folder ini hanya untuk panduan desain.
