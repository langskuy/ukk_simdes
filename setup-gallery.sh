#!/bin/bash
# Setup Guide - Gallery Integration

echo "=== Setup Galeri Pengaduan & Kegiatan ==="
echo ""

# 1. Create directories
echo "1️⃣  Membuat folder storage..."
mkdir -p public/storage/surat
mkdir -p public/storage/pengaduan
mkdir -p public/storage/kegiatan

# Set permissions
chmod -R 755 public/storage
chmod -R 777 public/storage/surat
chmod -R 777 public/storage/pengaduan
chmod -R 777 public/storage/kegiatan

# 2. Create symbolic link if not exists
if [ ! -L "public/storage" ]; then
    echo "2️⃣  Membuat symbolic link..."
    php artisan storage:link
else
    echo "2️⃣  Symbolic link sudah ada ✓"
fi

# 3. Run migrations if needed
echo "3️⃣  Memastikan database tables..."
php artisan migrate --force

echo ""
echo "✅ Setup selesai!"
echo ""
echo "📌 Langkah selanjutnya:"
echo "1. Upload logo ke: public/storage/logo.png"
echo "2. Test gallery di: http://localhost:8000/gallery"
echo "3. Upload kegiatan di Admin → Kegiatan"
echo "4. Upload pengaduan di Warga → Ajukan Pengaduan"
echo ""
