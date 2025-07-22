<?php

namespace App\Http\Controllers;

use App\Events\CsvProcessingCompleted;
use App\Jobs\ProcessCsvUpload;
use App\Models\ProductUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function index()
    {
        $products = ProductUpload::orderByDesc('id')->paginate(10);
        return view('upload', compact('products'));
    }
    public function store(Request $request)
    {

        Log::info('Masuk controller');

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename);

        $upload = ProductUpload::create([
            'filename' => $filename,
            'status' => 'pending',
            'uploaded_at' => now(),
        ]);
        dispatch(new ProcessCsvUpload($upload));

        return redirect()->route('index')->with('uploadId', $upload->id);
    }
}
