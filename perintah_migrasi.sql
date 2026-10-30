-- =============================================================
-- PENERAPAN TABEL 4.3 (KRITERIA & SUB KRITERIA) - SPK ROC EDAS
-- -------------------------------------------------------------
-- Cara pakai:
--   1. Buka phpMyAdmin, pilih database aplikasi.
--   2. Masuk tab "SQL".
--   3. Tempel SELURUH isi file ini, lalu klik "Go".
--
-- Disarankan backup tabel kriteria, sub_kriteria, dan alternatif
-- terlebih dahulu.
--
-- Script ini aman dijalankan pada database yang:
--   - belum punya sub kriteria, atau
--   - sudah memakai skala sub kriteria baru (konversi otomatis dilewati).
-- =============================================================

SET SQL_SAFE_UPDATES = 0;

START TRANSACTION;

-- -------------------------------------------------------------
-- 1. Pastikan 6 kriteria sesuai Tabel 4.3
--    Semua bertipe benefit: nilai sub lebih tinggi = prioritas
--    lebih tinggi untuk menerima PIP.
-- -------------------------------------------------------------
INSERT INTO kriteria (kode, nama, tipe, urutan, created_at, updated_at)
VALUES
    ('pekerjaan_ayah',   'Pekerjaan Ayah',   'benefit', 1, NOW(), NOW()),
    ('penghasilan_ayah', 'Penghasilan Ayah', 'benefit', 2, NOW(), NOW()),
    ('pekerjaan_ibu',    'Pekerjaan Ibu',    'benefit', 3, NOW(), NOW()),
    ('penghasilan_ibu',  'Penghasilan Ibu',  'benefit', 4, NOW(), NOW()),
    ('yatim_piatu',      'Yatim/Piatu',      'benefit', 5, NOW(), NOW()),
    ('peringkat_kelas',  'Peringkat Kelas',  'benefit', 6, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    nama       = VALUES(nama),
    tipe       = VALUES(tipe),
    urutan     = VALUES(urutan),
    updated_at = NOW();

-- -------------------------------------------------------------
-- 2. Ganti sub kriteria sesuai Tabel 4.3
-- -------------------------------------------------------------
SET @id_pa  = (SELECT id_kriteria FROM kriteria WHERE kode = 'pekerjaan_ayah');
SET @id_pay = (SELECT id_kriteria FROM kriteria WHERE kode = 'penghasilan_ayah');
SET @id_pi  = (SELECT id_kriteria FROM kriteria WHERE kode = 'pekerjaan_ibu');
SET @id_piy = (SELECT id_kriteria FROM kriteria WHERE kode = 'penghasilan_ibu');
SET @id_yp  = (SELECT id_kriteria FROM kriteria WHERE kode = 'yatim_piatu');
SET @id_pk  = (SELECT id_kriteria FROM kriteria WHERE kode = 'peringkat_kelas');

DELETE FROM sub_kriteria
WHERE id_kriteria IN (@id_pa, @id_pay, @id_pi, @id_piy, @id_yp, @id_pk);

INSERT INTO sub_kriteria (id_kriteria, nama, nilai, created_at, updated_at) VALUES
    -- Pekerjaan Ayah
    (@id_pa,  'Wiraswasta', 1, NOW(), NOW()),
    (@id_pa,  'Nelayan',    2, NOW(), NOW()),
    (@id_pa,  'Buruh',      3, NOW(), NOW()),
    (@id_pa,  'Petani',     4, NOW(), NOW()),

    -- Penghasilan Ayah
    (@id_pay, 'Rp 3.000.000 – Rp 2.000.000', 1, NOW(), NOW()),
    (@id_pay, 'Rp 2.000.000 – Rp 1.000.000', 2, NOW(), NOW()),
    (@id_pay, 'Rp < 500.000',                3, NOW(), NOW()),

    -- Pekerjaan Ibu
    (@id_pi,  'Wiraswasta',    1, NOW(), NOW()),
    (@id_pi,  'Petani',        2, NOW(), NOW()),
    (@id_pi,  'Tidak bekerja', 3, NOW(), NOW()),

    -- Penghasilan Ibu
    (@id_piy, 'Rp 3.000.000 – Rp 2.000.000', 1, NOW(), NOW()),
    (@id_piy, 'Rp 2.000.000 – Rp 1.000.000', 2, NOW(), NOW()),
    (@id_piy, 'Rp < 500.000',                3, NOW(), NOW()),

    -- Yatim/Piatu
    (@id_yp,  'Yatim',       1, NOW(), NOW()),
    (@id_yp,  'Piatu',       1, NOW(), NOW()),
    (@id_yp,  'Yatim/Piatu', 2, NOW(), NOW()),

    -- Peringkat Kelas
    (@id_pk,  'Peringkat 1-3',  3, NOW(), NOW()),
    (@id_pk,  'Peringkat 4-10', 2, NOW(), NOW()),
    (@id_pk,  'Peringkat >10',  1, NOW(), NOW());

-- -------------------------------------------------------------
-- 3. Konversi nilai alternatif lama ke skala sub kriteria baru
--    Bagian ini otomatis dilewati jika data sudah skala baru.
-- -------------------------------------------------------------

-- 3a. Pekerjaan Ayah: nilai 5 digabung ke Petani (4)
SET @max_pa = (
    SELECT MAX(a.nilai)
    FROM alternatif a
    JOIN kriteria k ON k.id_kriteria = a.id_kriteria
    WHERE k.kode = 'pekerjaan_ayah'
);

UPDATE alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
SET a.nilai = CASE
        WHEN a.nilai <= 1 THEN 1
        WHEN a.nilai = 2  THEN 2
        WHEN a.nilai = 3  THEN 3
        ELSE 4
    END
WHERE k.kode = 'pekerjaan_ayah'
  AND @max_pa > 4;

-- 3b. Penghasilan Ayah: rupiah -> 3 / 2 / 1
SET @max_pay = (
    SELECT MAX(a.nilai)
    FROM alternatif a
    JOIN kriteria k ON k.id_kriteria = a.id_kriteria
    WHERE k.kode = 'penghasilan_ayah'
);

UPDATE alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
SET a.nilai = CASE
        WHEN a.nilai <= 500000  THEN 3
        WHEN a.nilai <= 2000000 THEN 2
        ELSE 1
    END
WHERE k.kode = 'penghasilan_ayah'
  AND @max_pay > 3;

-- 3c. Pekerjaan Ibu: nilai 1 dan 2 sudah sesuai, tidak perlu konversi.

-- 3d. Penghasilan Ibu: rupiah -> 3 / 2 / 1
SET @max_piy = (
    SELECT MAX(a.nilai)
    FROM alternatif a
    JOIN kriteria k ON k.id_kriteria = a.id_kriteria
    WHERE k.kode = 'penghasilan_ibu'
);

UPDATE alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
SET a.nilai = CASE
        WHEN a.nilai <= 500000  THEN 3
        WHEN a.nilai <= 2000000 THEN 2
        ELSE 1
    END
WHERE k.kode = 'penghasilan_ibu'
  AND @max_piy > 3;

-- 3e. Yatim/Piatu: Yatim/Piatu (3 atau 100) -> 2, selain itu -> 1
SET @ada_yp = (
    SELECT MAX(CASE WHEN a.nilai IN (3, 50, 100) THEN 1 ELSE 0 END)
    FROM alternatif a
    JOIN kriteria k ON k.id_kriteria = a.id_kriteria
    WHERE k.kode = 'yatim_piatu'
);

UPDATE alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
SET a.nilai = CASE
        WHEN a.nilai IN (3, 100) THEN 2
        ELSE 1
    END
WHERE k.kode = 'yatim_piatu'
  AND @ada_yp = 1;

-- 3f. Peringkat Kelas: 1-3 -> 3, 4-10 -> 2, lainnya (>10 / 0) -> 1
SET @ada_pk = (
    SELECT MAX(CASE WHEN a.nilai = 0 OR a.nilai > 3 THEN 1 ELSE 0 END)
    FROM alternatif a
    JOIN kriteria k ON k.id_kriteria = a.id_kriteria
    WHERE k.kode = 'peringkat_kelas'
);

UPDATE alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
SET a.nilai = CASE
        WHEN a.nilai BETWEEN 1 AND 3 THEN 3
        WHEN a.nilai BETWEEN 4 AND 10 THEN 2
        ELSE 1
    END
WHERE k.kode = 'peringkat_kelas'
  AND @ada_pk = 1;

COMMIT;

-- -------------------------------------------------------------
-- 4. Verifikasi hasil
-- -------------------------------------------------------------
SELECT k.urutan, k.kode, k.nama, k.tipe, s.nilai, s.nama AS sub_kriteria
FROM kriteria k
LEFT JOIN sub_kriteria s ON s.id_kriteria = k.id_kriteria
ORDER BY k.urutan, s.nilai DESC, s.id_sub_kriteria;

SELECT k.kode, a.nilai, COUNT(*) AS jumlah
FROM alternatif a
JOIN kriteria k ON k.id_kriteria = a.id_kriteria
GROUP BY k.kode, a.nilai
ORDER BY k.kode, a.nilai;
