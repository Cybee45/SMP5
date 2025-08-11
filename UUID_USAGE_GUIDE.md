# UUID USAGE GUIDE - PRACTICAL EXAMPLES

## ❌ BAD PRACTICE (Insecure)
```
PUBLIC WEBSITE YANG SALAH:
- /artikel/1     ← Hacker bisa coba /artikel/2, /artikel/3, dst
- /galeri/5      ← Bisa ketahuan total ada berapa galeri
- /hero/3        ← Data sensitif bisa di-enumerate
```

## ✅ GOOD PRACTICE (Secure)
```
ADMIN PANEL (Internal Use):
- /admin/heroes/1/edit              ← Fast, simple, Filament compatible
- /admin/artikel/25/edit            ← Developer friendly
- /admin/galeri/8/edit              ← Easy debugging

PUBLIC WEBSITE (External Access):
- /artikel/34f9478e-6876-4170-bd66-f2326e639492    ← Secure
- /galeri/91b9dbb3-d628-475a-9d5e-5ea7c795e527     ← No enumeration
- /hero/265f7152-2bb2-4605-8331-2cfa11a2c8b6       ← Professional
```

## 🎪 REAL WORLD EXAMPLES

### SMP WEBSITE STRUCTURE:
```
ADMIN ROUTES (Protected, Login Required):
✅ /admin/login
✅ /admin/dashboard  
✅ /admin/heroes/3/edit        ← Guru edit hero
✅ /admin/artikel/15/edit      ← Guru tulis artikel
✅ /admin/galeri/7/edit        ← Guru upload foto
✅ /admin/users/2/edit         ← Admin manage user

PUBLIC ROUTES (Open Access):
🔒 /                                                    ← Homepage
🔒 /tentang                                             ← About page
🔒 /artikel/34f9478e-6876-4170-bd66-f2326e639492       ← Siswa baca artikel
🔒 /galeri/91b9dbb3-d628-475a-9d5e-5ea7c795e527        ← Orang tua lihat galeri
🔒 /pengumuman/15d482c6-b54f-4eb5-bfde-c6548da35902    ← Public announcement

API ENDPOINTS (External Integration):
🔒 /api/heroes/265f7152-2bb2-4605-8331-2cfa11a2c8b6
🔒 /api/statistik/09466ec6-df8d-4b0a-a92d-e97421f25e0c
🔒 /api/keunggulan/2a8ef57d-6c1c-4000-966b-bc28fe0df157
```

## 🚨 SECURITY COMPARISON

### Without UUID (VULNERABLE):
```
Hacker Test:
- /artikel/1     ✅ "SMP 5 Raih Juara 1"
- /artikel/2     ✅ "Penerimaan Siswa Baru" 
- /artikel/3     ✅ "Rapat Guru Internal"    ← LEAKED!
- /artikel/4     ✅ "Data Keuangan Sekolah" ← PROBLEM!
```

### With UUID (SECURE):
```
Hacker Test:
- /artikel/34f9478e-6876-4170-bd66-f2326e639492  ✅ Valid article
- /artikel/34f9478e-6876-4170-bd66-f2326e639493  ❌ 404 Not Found
- /artikel/34f9478e-6876-4170-bd66-f2326e639494  ❌ 404 Not Found
← Hacker cannot enumerate/guess other articles
```

## 📊 PERFORMANCE IMPACT

### Admin Panel (1000 queries):
- ID Query: ~200ms     ← Lightning fast
- UUID Query: ~400ms   ← 2x slower but still acceptable

### Recommendation: 
- Admin = ID (speed priority)
- Public = UUID (security priority)

## 🎯 FINAL DECISION MATRIX

| Context | Use | Reason |
|---------|-----|--------|
| Admin Panel | ID | Performance, compatibility, UX |
| Public Website | UUID | Security, privacy, professional |
| API Endpoints | UUID | Industry standard, anti-enumeration |
| Database Relations | ID | Foreign key performance |
| Share Links | UUID | Security when sharing publicly |
| Debug/Logs | ID | Developer experience |
