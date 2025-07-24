<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Command สำหรับ Clear Cache ทั้งหมด
 * ไฟล์: D:\xampp\htdocs\smm-srk\app\Console\Commands\ClearAllCache.php
 */
class ClearAllCache extends Command
{
    protected $signature = 'cache:clear-all';
    protected $description = 'Clear all Laravel cache และ compiled files';

    public function handle()
    {
        Log::info('เริ่มต้นการ clear cache ทั้งหมด');
        
        // Clear application cache
        $this->call('cache:clear');
        $this->info('✓ Application cache cleared');
        
        // Clear route cache
        $this->call('route:clear');
        $this->info('✓ Route cache cleared');
        
        // Clear config cache
        $this->call('config:clear');
        $this->info('✓ Config cache cleared');
        
        // Clear view cache
        $this->call('view:clear');
        $this->info('✓ View cache cleared');
        
        Log::info('การ clear cache ทั้งหมดเสร็จสิ้น');
        $this->info('All caches cleared successfully!');
    }
}
