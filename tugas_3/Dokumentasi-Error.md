1. Error variabel tidak ditulis dengan benar
File: proses-pendaftaran-2.php
Masalah: Penulisan variabel sekolah tidak memakai tanda $
Perbaikan: $sekolah = $_POST['sekolah_asal'];

2. Error penulisan SQL
File: proses-pendaftaran-2.php
Masalah: Menggunakan VALUE, seharusnya VALUES
Perbaikan: Mengganti menjadi VALUES atau langsung memakai prepared statement

3. Penggunaan query langsung (raw query)
Masalah: Query memakai input langsung sehingga tidak aman
Perbaikan: Mengganti menjadi prepared statement mysqli_prepare

4. Kesalahan komentar yang membuat baris kode terbaca sebagai teks
File: proses-pendaftaran-2.php
Masalah: Komentar tidak ditulis rapih dan membuat baris berikutnya dianggap kode
Perbaikan: Merapikan atau menghapus komentar yang salah

5. Kesalahan DOCTYPE pada file form-daftar.php
File: form-daftar.php
Masalah: <DOCTYPE > tidak valid
Perbaikan: Mengganti dengan <!DOCTYPE html>

6. Form belum menggunakan validasi dasar
File: form-daftar.php
Masalah: Input tidak menggunakan required
Perbaikan: Menambahkan required pada input yang diperlukan

7. Akses langsung ke proses-pendaftaran-2.php bisa menimbulkan error
Masalah: File bisa diakses tanpa submit form
Perbaikan: Menambahkan pemeriksaan if (!isset($_POST['daftar']))
