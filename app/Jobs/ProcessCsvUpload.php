<?php

namespace App\Jobs;

use App\Events\CsvProcessingCompleted;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $upload;
    /**
     * Create a new job instance.
     */
    public function __construct($upload)
    {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {

            $this->upload->update(['status' => 'processing']);

            $path = storage_path("app/uploads/" . $this->upload->filename);

            if (!file_exists($path)) {
                Log::error("CSV file not found: {$path}");
                $this->upload->update(['status' => 'error']);
                return;
            }

            $rows = array_map('str_getcsv', file($path));
            $header = array_map('trim', $rows[0]);
            unset($rows[0]);

            foreach ($rows as $row) {
                $row = array_map([$this, 'cleanUtf8'], $row);

                if (count($header) !== count($row)) {
                    Log::warning('Header count mismatch in row', ['row' => $row]);
                    continue;
                }

                $data = array_combine($header, $row);

                // Contoh: assume SKU is unique key
                if (!isset($data['UNIQUE_KEY'])) {
                    Log::warning('Missing UNIQUE_KEY in row', ['row' => $data]);
                    continue;
                }

                Product::updateOrCreate(
                    ['unique_key' => $data['UNIQUE_KEY']],
                    [
                        'product_title' => $data['PRODUCT_TITLE'] ?? null,
                        'product_description' => $data['PRODUCT_DESCRIPTION'] ?? null,
                        'style' => $data['STYLE#'] ?? null,
                        'sanmar_mainframe_color' => $data['SANMAR_MAINFRAME_COLOR'] ?? null,
                        'size' => $data['SIZE'] ?? null,
                        'color_name' => $data['COLOR_NAME'] ?? null,
                        'piece_price' => $data['PIECE_PRICE'] ?? null,
                    ]
                );
            }

            $this->upload->update(['status' => 'completed']);

            broadcast(new CsvProcessingCompleted($this->upload->id));
            logger("Broadcast fired for upload: " . $this->upload->id);
        } catch (\Throwable $e) {
            Log::error("CSV row processing failed: " . $e->getMessage());
        }
    }

    private function cleanUtf8($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}
