# Sistem Persetujuan Pengeluaran

Proyek ini adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola dan menyetujui pengeluaran melalui proses persetujuan bertahap. Sistem ini memastikan bahwa pengeluaran disetujui secara berurutan oleh beberapa approver, dengan setiap pengeluaran mengikuti alur persetujuan yang ditentukan.

## Instalasi

Ikuti langkah-langkah berikut untuk mengatur proyek secara lokal:

1. **Install Dependensi**:

    ```bash
    composer install
    ```

2. **Generate app key**:

    ```bash
    php artisan key:generate
    ```

3. **Jalankan Migrasi**:

    ```bash
    php artisan migrate
    ```

4. **Isi Data Awal** 

    ```bash
    php artisan db:seed --class=StatusesTableSeeder
    ```

7. **Run Server**:

    ```bash
    php artisan serve
    ```

## Variabel Lingkungan

Perbarui file `.env` dengan kredensial database dan pengaturan lingkungan lainnya:

- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## Documentation
http://localhost:8000/api/documentation

## Test
    ```bash
    php artisan test
    ```
