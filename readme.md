# Tugas 2 IF3110 Pengembangan Aplikasi Berbasis Web 

7. [DELIVERABLE] Berikan penjelasan mengenai hal di bawah ini pada bagian **Penjelasan** dari *readme* repository git Anda: ((masih spek taun lalu))
    - Basis data dari sistem yang Anda buat, yaitu basis data aplkasi pro-book, webservice bank, dan webservice buku.
    - Konsep *shared session* dengan menggunakan REST.
    - Mekanisme pembangkitan token dan expiry time pada aplikasi Anda.
    - Kelebihan dan kelemahan dari arsitektur aplikasi tugas ini, dibandingkan dengan aplikasi monolitik (login, CRUD DB, dll jadi dalam satu aplikasi)
8. Pada *readme* terdapat penjelasan mengenai pembagian tugas masing-masing anggota (lihat formatnya pada bagian **pembagian tugas**).
9. Merge request dari repository anda ke repository ini dengan format **Nama kelompok** - **NIM terkecil** - **Nama Lengkap dengan NIM terkecil** sebelum **Jumat, 30 November 2018 pukul 23.59**.

## Sistem Basis data
### Basis data Pro-Book
- access_info(token, user_id, user_browser, user_ip, expiry_time)
- order(id, book_id, buyer_id, quantity, order_date, comments, rating)
- user(id, username, password, name, email, address, phone_number, card)
### Basis data BankService
- nasabah(Nama, no_kartu, saldo)
- transaksi(no_kartu_pengirim, no_kartu_penerima, jumlah, waktu_transaksi)
### Basis data BookService
- prices(book_id, price)
- total_bought(book_id, category, n_bought)

## Konsep Shared Session

## Mekanisme Pembangkitan Token dan Expiry Time

## Kelebihan dan Kekurangan
### Kelebihan
- Tidak perlu menyimpan banyak data
- Data tidak mudah dicuri atau hilang
- Setiap service bisa dikembangkan lebih lanjut lebih mudah

### Kekurangan
- Latency time bertambah karena harus melakukan access data setiap mengambil data yang tidak dimiliki
- Pengolahan data menjadi semakin kompleks karena harus maintain data di setiap service
- Pengembangan yang lebih sulit

### Skenario

1. User melakukan registrasi dengan memasukkan informasi nomor kartu.
2. Jika nomor kartu tidak valid, registrasi ditolak dan user akan diminta memasukkan kembali nomor kartu yang valid.
3. User yang sudah teregistrasi dapat mengganti informasi nomor kartu.
4. Ketika user mengganti nomor kartu, nomor kartu yang baru akan diperiksa validasinya melalui webservice bank.
5. Setelah login, user dapat melakukan pencarian buku.
6. Pencarian buku akan mengirim request ke webservice buku. Halaman ini menggunakan AngularJS.
7. Pada halaman detail buku, ada rekomendasi buku yang didapat dari webservice buku. Rekomendasi buku berdasarkan kategori buku yang sedang dilihat.
8. Ketika user melakukan pemesanan buku, aplikasi akan melakukan request transfer kepada webservice bank.
9. Jika transfer berhasil, aplikasi mengirimkan request kepada webservice buku untuk mencatat penjualan buku.
10. Notifikasi muncul menandakan status pembelian, berhasil atau gagal.

## Pembagian Tugas
REST :
1. Koneksi nodejs ke mysql : 13516026
2. Membuat service validasi kartu : 13516134
3. Membuat service transfer : 13516050

SOAP :
1. Pembelian : 13516026
2. Rekomendasi : 13516134
3. Pencarian buku dan pengambilan detail : 13516050

Perubahan Web app :
1. Halaman Search : 

## About

Dicky A. | Shevalda G. | William J.

