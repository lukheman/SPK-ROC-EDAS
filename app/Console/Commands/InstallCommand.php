<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'install';
    protected $description = 'Menjalankan instalasi awal aplikasi Laravel (tanpa composer install)';

    public function handle()
    {
        $this->info('🚀 Memulai proses instalasi aplikasi...');

        // 1. Cek dan buat file .env jika belum ada
        if (!file_exists(base_path('.env'))) {
            $this->info('📄 File .env belum ada, membuat dari .env.example...');
            if (!file_exists(base_path('.env.example'))) {
                $this->error('❌ File .env.example tidak ditemukan!');
                return;
            }
            copy(base_path('.env.example'), base_path('.env'));
            $this->info('✅ File .env berhasil dibuat.');
        }

        // 2. Migrasi database
        $this->info('📂 Menjalankan migrasi database...');
        $this->call('migrate', ['--force' => true]);

        // 3. Migrasi fresh + seed
        $this->info('🗑️ Menghapus dan mengisi ulang database...');
        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);

        // 4. Generate APP_KEY
        $this->info('🔑 Membuat APP_KEY baru...');
        $this->call('key:generate', ['--force' => true]);

        // 5. Storage link
        $this->info('🔗 Membuat symbolic link storage...');
        $this->call('storage:link');


        // 6. Selesai
        $this->info('✅ Instalasi selesai!');
        $this->info('💡 Jalankan aplikasi dengan perintah:');
        $this->line('php artisan serve');

        // Informasi aplikasi
        $appName = 'Nama Aplikasi: SPK-ROC-EDAC';
        $author = 'Dibuat oleh: Lukmanul Rahman (Akmal)';
        // $license = 'Lisensi: Tidak untuk dijual kembali';

        // Kontak
        $contactWA = '📱 WhatsApp: 0822-5022-3147';
        $contactYT = '▶️ YouTube: youtube.com/@lukheeman';
        $contactIG = '📸 Instagram: instagram.com/lukheeman';

        // Tampilkan informasi
        $this->newLine();
        $this->info("📌 {$appName}");
        $this->info("📌 {$author}");
        // $this->line($license);
        $this->newLine();
        $this->info($contactWA);
        $this->info($contactYT);
        $this->info($contactIG);
    }
}
