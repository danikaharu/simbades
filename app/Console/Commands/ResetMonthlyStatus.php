<?php

namespace App\Console\Commands;

use App\Models\Recipient;
use App\Models\RecipientLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetMonthlyStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:monthly-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset status for specific detail_assistance_id every month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $assistanceIds = [2, 4, 5]; // Ganti dengan ID yang sesuai

        // Ambil semua data yang akan di-reset
        $recipients = Recipient::whereIn('assistance_id', $assistanceIds)->get();

        // Simpan data lama ke tabel log
        foreach ($recipients as $recipient) {
            RecipientLog::create([
                'recipient_id' => $recipient->id,
                'status'       => $recipient->status,
                'log_date'     => Carbon::now()->subDays(1)->toDateString(),
            ]);
        }

        // Reset status
        Recipient::whereIn('assistance_id', $assistanceIds)
            ->update(['status' => 0]);

        $this->info('Monthly status reset completed successfully. Data has been logged.');

        \Log::info("Cron Job berhasil berjalan");
    }
}
