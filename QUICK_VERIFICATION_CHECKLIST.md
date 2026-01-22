# ✅ PDF Generation Fix - User Checklist

## Quick Verification (5 minutes)

### Step 1: Check GD Extension
Visit this URL in your browser:
```
http://localhost/test-gd-complete.php
```

**You should see:**
- ✅ PHP Version: 8.0.30 (atau versi Anda)
- ✅ GD Support: **ENABLED**
- ✅ GD Version: bundled (2.1.0 compatible)
- ✅ JPEG Support: ✓ Yes
- ✅ PNG Support: ✓ Yes
- ✅ PNG generation test: **SUCCESS**

---

### Step 2: Test PDF Generation (for Developers)
Open terminal/PowerShell dan jalankan:
```bash
cd C:\ukk_simdes
php artisan surat:test-pdf 3
```

**Expected output:**
```
✓ GD Extension is loaded
✓ PDF generated successfully
Path: storage/surat/surat_3_[timestamp].pdf
✓ PDF file exists
File size: ~40 KB
```

---

### Step 3: Test Download in Admin Panel
1. Login ke `http://localhost/admin`
2. Go to **Permintaan Surat** (Surat Admin)
3. Click any surat (contoh: Surat ID 3)
4. Click button **"🔄 Generate PDF Otomatis"**
5. In popup, click **"Generate PDF"**
6. Should show: **"Surat disimpan dan PDF sudah tersedia."**

---

### Step 4: Test User Download
1. Login sebagai warga/user
2. Go to **Riwayat Surat** 
3. Find surat dengan status **"✓ Selesai"**
4. Click **"📥 Unduh"** button
5. PDF should download successfully

---

## Issues & Solutions

### Problem: "Still seeing GD error"

**Solution 1 - Clear cache again:**
```bash
cd C:\ukk_simdes
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

Then restart Apache (via XAMPP Control Panel or `Stop-Process -Name httpd`)

**Solution 2 - Verify GD is actually enabled:**
```bash
# In PowerShell:
php -m | Select-String "gd"

# Should output: gd
```

**Solution 3 - Check php.ini directly:**
Search for line with `extension=gd` (not `;extension=gd`)
```bash
Select-String -Path "C:\xampp\php\php.ini" -Pattern "^extension=gd$"
```

---

### Problem: "PDF generates but can't download"

**Check file permissions:**
```bash
# Make sure storage directory is writable
icacls "C:\ukk_simdes\public\storage\surat" /grant:r "%username%:(OI)(CI)F"
```

---

### Problem: "File not found after generation"

**Verify PDF was saved:**
```bash
Get-ChildItem -Path "C:\ukk_simdes\public\storage\surat" -Filter "*.pdf"
```

Should list PDF files. If not, check:
- Is `public/storage/surat` directory writable?
- Is there disk space available?
- Check logs: `storage/logs/laravel.log`

---

## Command Reference

### For Testing
```bash
# Test PDF generation
php artisan surat:test-pdf {surat_id}

# Example:
php artisan surat:test-pdf 3
```

### For Maintenance
```bash
# Generate and save PDF for a surat
php artisan surat:update-file {surat_id}

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## Performance Check

After fix, system should:
- ✅ Generate PDF in < 3 seconds
- ✅ File size around 35-45 KB
- ✅ Support multiple concurrent downloads
- ✅ No memory leaks or errors in logs

---

## Files to Check

If issues persist, verify these files exist:

```
✓ C:\xampp\php\php.ini                          (has extension=gd)
✓ C:\ukk_simdes\app\Services\SuratPdfGenerator.php  (GD check first)
✓ C:\ukk_simdes\public\images\logo-desa.png        (logo file)
✓ C:\ukk_simdes\public\storage\surat\              (writable directory)
```

---

## Success Confirmation

After applying the fix, you'll know it's working when:

| Check | Before | After |
|-------|--------|-------|
| `http://localhost/test-gd-complete.php` | ❌ GD disabled | ✅ GD enabled |
| Admin → Generate PDF button | ❌ Error | ✅ Works |
| User → Download PDF | ❌ Error | ✅ Works |
| `storage/logs/laravel.log` | ❌ GD errors | ✅ No GD errors |
| `storage/surat/` folder | ❌ Empty | ✅ Contains PDFs |

---

## When to Contact Support

Contact support if:
- [ ] GD still shows disabled after fix
- [ ] PDF generation throws different error
- [ ] Files created but can't be accessed
- [ ] Apache won't restart

---

## Additional Notes

- ✅ All changes are backward compatible
- ✅ No database migration needed
- ✅ No configuration changes to `.env` needed
- ✅ Safe to undo (just comment out extension=gd again)

---

**Status: ✅ Ready to Use**

The PDF generation system is now fully functional and tested!
