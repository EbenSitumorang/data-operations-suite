<?php

namespace App\Http\Controllers;

use App\Models\ServiceRecord;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceRecordController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        if (!in_array($status, ['pending', 'processing', 'completed', 'cancelled'], true)) {
            $status = '';
        }

        $records = ServiceRecord::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('record_code', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%")
                        ->orWhere('service_type', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('service_records.index', compact('records', 'search', 'status'));
    }
    public function show(ServiceRecord $serviceRecord)
{
    return view('service_records.show', compact('serviceRecord'));
}   

    
    public function create()
    {
        return view('service_records.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'record_code' => [
                'required',
                'string',
                'max:50',
                'unique:service_records,record_code',
            ],
            'service_type' => ['required', 'string', 'max:100'],
            'region' => ['required', 'string', 'max:100'],
            'customer_ref' => ['nullable', 'string', 'max:100'],
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'processing', 'completed', 'cancelled']),
            ],
            'received_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        ServiceRecord::create($validated);

        return redirect()->route('service-records.index')
            ->with('success', 'Data operasional berhasil ditambahkan.');
    }


    public function edit(ServiceRecord $serviceRecord)
    {
        return view('service_records.edit', compact('serviceRecord'));
    }

    public function update(Request $request, ServiceRecord $serviceRecord)
    {
        $validated = $request->validate([
           'record_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('service_records', 'record_code')
                    ->ignore($serviceRecord->id),
            ],
            'service_type' => ['required', 'string', 'max:100'],
            'region' => ['required', 'string', 'max:100'],
            'customer_ref' => ['nullable', 'string', 'max:100'],
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'processing', 'completed', 'cancelled']),
            ],
            'received_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $serviceRecord->update($validated);

        return redirect()->route('service-records.index')
            ->with('success', 'Data operasional berhasil diperbarui.');
    }

    public function destroy(ServiceRecord $serviceRecord)
    {
        $serviceRecord->delete();

        return redirect()->route('service-records.index')
            ->with('success', 'Data operasional berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');

        if (!in_array($status, ['pending', 'processing', 'completed', 'cancelled'], true)) {
            $status = '';
        }

        $records = ServiceRecord::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('record_code', 'like', "%{$search}%")
                        ->orWhere('region', 'like', "%{$search}%")
                        ->orWhere('service_type', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('id')
            ->get();

        return response()->streamDownload(function () use ($records) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, [
                'Kode Data',
                'Jenis Layanan',
                'Wilayah',
                'Referensi Pelanggan',
                'Status',
                'Tanggal Diterima',
                'Catatan',
            ]);

            foreach ($records as $record) {
                fputcsv($output, [
                    $record->record_code,
                    $record->service_type,
                    $record->region,
                    $record->customer_ref,
                    $record->status,
                    $record->received_at ? $record->received_at->format('Y-m-d') : '',
                    $record->notes,
                ]);
            }

            fclose($output);
        }, 'data-operasional-' . date('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function monthlyReport(Request $request)
    {
        $currentMonth = (int) date('m');
        $currentYear = (int) date('Y');

        $month = (int) $request->query('month', $currentMonth);
        $year = (int) $request->query('year', $currentYear);

        if ($month < 1 || $month > 12) {
            $month = $currentMonth;
        }

        if ($year < 2020 || $year > 2100) {
            $year = $currentYear;
        }

        $records = ServiceRecord::query()
            ->whereNotNull('received_at')
            ->whereYear('received_at', $year)
            ->whereMonth('received_at', $month)
            ->orderByDesc('received_at')
            ->get();

        $total = $records->count();
        $pending = $records->where('status', 'pending')->count();
        $processing = $records->where('status', 'processing')->count();
        $completed = $records->where('status', 'completed')->count();
        $cancelled = $records->where('status', 'cancelled')->count();

        return view('service_records.monthly-report', compact(
            'month',
            'year',
            'records',
            'total',
            'pending',
            'processing',
            'completed',
            'cancelled'
        ));
    }
}
