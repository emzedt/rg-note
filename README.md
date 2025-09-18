# Raja Gadai Note

Raja Gadai Note adalah aplikasi web pencatat pribadi yang dikembangkan untuk memenuhi **Tugas A: Web Developer Laravel**. Aplikasi ini memungkinkan pengguna untuk membuat, mengelola, dan berbagi catatan secara efisien, dengan fitur keamanan dan kolaborasi yang terintegrasi.

-----

## Fitur Utama

Aplikasi ini mencakup fitur-fitur penting yang diminta dalam tugas, serta beberapa tambahan untuk meningkatkan pengalaman pengguna:

  * **Login & Register**: Pengguna dapat membuat akun dan masuk ke aplikasi untuk mengakses catatan pribadi mereka.
  * **Dashboard**: Halaman utama yang menampilkan ringkasan catatan pengguna.
  * **Catatan Pribadi (Private)**: Pengguna dapat membuat catatan pribadi yang hanya bisa dilihat oleh mereka sendiri.
  * **Berbagi Catatan (Shared)**:
      * **Shared with me**: Halaman yang menampilkan catatan yang dibagikan oleh pengguna lain.
      * **Berbagi ke pengguna lain**: Pengguna dapat membagikan catatan pribadi mereka ke pengguna lain dengan menentukan peran (**Viewer** atau **Editor**) melalui undangan email.
  * **Berbagi ke publik (Public)**: Pengguna dapat mempublikasikan catatan mereka agar dapat diakses oleh siapa saja.
  * **Kolaborasi**: Pengguna yang diundang sebagai editor dapat mengedit catatan yang dibagikan.
  * **Komentar**: Pengguna dapat menambahkan komentar pada catatan, baik pada catatan pribadi maupun yang dibagikan.
  * **Notifikasi Email**:
      * Notifikasi akan dikirimkan melalui email saat pengguna diundang untuk melihat atau mengedit catatan.
      * Notifikasi juga dikirimkan saat catatan dipublikasikan.

-----

## Instalasi

### Dari Kode Sumber

1.  **Kloning repositori:**
    ```bash
    git clone https://github.com/emzedt/rg-note.git
    ```
2.  **Masuk ke direktori:**
    ```bash
    cd rg-note
    ```
3.  **Instal dependensi:**
    ```bash
    npm install
    ```
4.  **Jalankan aplikasi:**
    ```bash
    npm start
    ```
5.  **Jalankan queue:**
    ```bash
    php artisan queue:work
    ```
