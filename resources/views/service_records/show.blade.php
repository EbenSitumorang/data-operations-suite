```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium text-blue-600">
                    DATA OPERATIONS SUITE
                </p>
                <h1 class="mt-1 text-2xl font-bold">
                    Detail Data Layanan
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi lengkap data operasional.
                </p>
            </div>

            <a href="{{ route('service-records.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold hover:bg-slate-50">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-6 py-5">
                <div>
                    <p class="text-sm text-slate-500">Kode Data</p>
                    <h2 class="mt-1 text-xl font-bold text-slate-900">
                        {{ $serviceRecord->record_code }}
                    </h2>
                </div>

                @php
                    $statusStyles = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'processing' => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-emerald-100 text-emerald-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];

                    $statusLabels = [
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ];
                @endphp

                <span class="rounded-full px-3 py-1.5 text-sm font-semibold {{ $statusStyles[$serviceRecord->status] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ $statusLabels[$serviceRecord->status] ?? ucfirst($serviceRecord->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">

                <div>
                    <p class="text-sm text-slate-500">Jenis Layanan</p>
                    <p class="mt-1 font-semibold">
                        {{ $serviceRecord->service_type }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Wilayah</p>
                    <p class="mt-1 font-semibold">
                        {{ $serviceRecord->region }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Referensi Pelanggan</p>
                    <p class="mt-1 font-semibold">
                        {{ $serviceRecord->customer_ref ?: 'Tidak tersedia' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Tanggal Diterima</p>
                    <p class="mt-1 font-semibold">
                        {{ $serviceRecord->received_at?->format('d-m-Y') ?? 'Belum ditentukan' }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-sm text-slate-500">Catatan</p>
                    <div class="mt-2 min-h-20 whitespace-pre-line rounded-lg bg-slate-50 p-4 text-sm leading-6">{{ $serviceRecord->notes ?: 'Tidak ada catatan.' }}</div>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Dibuat pada</p>
                    <p class="mt-1 text-sm font-medium">
                        {{ $serviceRecord->created_at?->format('d-m-Y H:i') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Terakhir diperbarui</p>
                    <p class="mt-1 text-sm font-medium">
                        {{ $serviceRecord->updated_at?->format('d-m-Y H:i') ?? '—' }}
                    </p>
                </div>

            </div>

            <div class="flex flex-wrap justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                <a href="{{ route('service-records.index') }}"
                   class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold hover:bg-slate-100">
                    Kembali
                </a>

                <a href="{{ route('service-records.edit', $serviceRecord) }}"
                   class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    Edit Data
                </a>
            </div>

        </div>

        <p class="mt-5 text-center text-xs text-slate-500">
            Data Operations Suite &bull; Detail Data Operasional
        </p>

    </div>

</body>
</html>
```