# Sepik2 

Sepik2 adalah aplikasi media sosial mini di mana user bisa:
- Membuat akun, login, logout
- Membuat postingan dengan foto
- Like & komentar pada postingan
- Mengikuti (follow) user lain
- Mencari user dan postingan berdasarkan lokasi
- Mengedit profil & avatar

---

## 🚀 Cara Menjalankan Project

### Prasyarat

Pastikan sudah ter-install:

- PHP **8.2+**
- Composer
- MySQL

1. Import database ( file sql bisa ditemukan di folder Database)
2. Login dengan akun:
3. `Username : Admin (role admin), Password : Admin123`
4. `Username : Kevin (role user), Password : kevin123`
5. bisa juga mendaftarkan akun baru
---

## 🛠 Tech Stack

- **Backend**: Laravel 12
- **Database**: MySQL
- **View**: Blade + Tailwind CSS (CDN)
- **Auth**: Auth manual (tanpa Breeze)
- **Storage**: Laravel Filesystem (`storage/app/public` → `public/storage`)

---

## ✨ Fitur Utama

### Autentikasi
- Register, login, logout.
- Middleware `auth` untuk melindungi halaman internal.

### Feed & Postingan
- Global feed: semua post dari semua user.
- Form buat postingan baru:
  - Caption (opsional)
  - Lokasi (opsional)
  - Upload multi media (foto/video).
- Post disimpan di tabel:
  - `posts`
  - `post_media` (multi file per post).

### Interaksi
- Like / Unlike postingan.
  - Update jumlah like di database.
  - Di halaman feed: tombol Like menggunakan **AJAX** (tanpa reload halaman).
- Komentar pada postingan.
- Halaman detail postingan (`/p/{id}`):
  - Media besar di kiri
  - Caption di box terpisah
  - Daftar komentar
  - Form tambah komentar
  - Tombol kembali dengan fallback ke home.

### Profil
- Halaman profil tiap user (`/profile/{username}`):
  - Avatar, username, nama, bio, website.
  - Jumlah postingan, pengikut, dan mengikuti.
  - Grid postingan ala Instagram (3 kolom) yang bisa diklik ke halaman detail post.
- Edit profil:
  - Ubah nama, bio, website, no HP, gender.
  - Upload avatar.
  - Hapus avatar lama (opsional).

### Follow
- Follow / unfollow user lain.
- Follow langsung diterima (tidak ada akun privat).
- Counter pengikut & mengikuti pada profil.

### Pencarian
- Search bar di navbar.
- Halaman `/search`:
  - Cari **user** berdasarkan username / nama.
  - Cari **post** berdasarkan **lokasi** (caption tidak ikut dicari).
  - Hasil berupa list user dan grid postingan yang bisa diklik.

---

### Clone Repository

```bash
git clone https://github.com/Aldragz/Sepik2.git
cd Sepik2
