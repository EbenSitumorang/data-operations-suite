
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Bulanan - Data Operations Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
    <main class="max-w-7xl mx-auto p-6 md:p-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Laporan Bulanan</h1>
                <p class="text-slate-500 mt-2">Ringkasan layanan berdasarkan tanggal diterima.</p>
            </div>
            <a href="{{ route('service-records.index') }}"
               class="inline-flex justify-center bg-slate-800 hover:bg-slate-900 text-white font-semibold px-5 py-3 rounded-lg">
                Kembali ke Dashboard
            </a>
        </div>

        <section class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 mb-8">
            <h2 class="text-lg font-bold mb-4">Pilih Periode Laporan</h2>

            <form method="GET" action="{{ route('service-records.monthly-report') }}"
                  class="flex flex-col sm:flex-row gap-3">
                <select name="month" class="border border-slate-300 rounded-lg px-4 py-3">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ $m }}" @selected($month === $m)>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="year" class="border border-slate-300 rounded-lg px-4 py-3">
                    @foreach (range(max(2020, (int) date('Y') - 5), (int) date('Y') + 1) as $y)
                        <option value="{{ $y }}" @selected($year === $y)>{{ $y }}</option>
                    @endforeach
                </select>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg">
                    Tampilkan Laporan
                </button>
            </form>
        </section>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <p class="text-slate-500 text-sm">Total Layanan Diterima</p>
                <p class="text-3xl font-bold mt-2">{{ $total }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <p class="text-slate-500 text-sm">Layanan Pending</p>
                <p class="text-3xl font-bold text-amber-600 mt-2">{{ $pending }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <p class="text-slate-500 text-sm">Layanan Diproses</p>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $processing }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <p class="text-slate-500 text-sm">Layanan Selesai</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $completed }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                <p class="text-slate-500 text-sm">Layanan Dibatalkan</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $cancelled }}</p>
            </div>
        </div>

        <section class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200">
                <h2 class="text-xl font-bold">Rincian Layanan</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Periode {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-600 text-sm">
                        <tr>
                            <th class="p-4 border-b">No.</th>
                            <th class="p-4 border-b">Kode Data</th>
                            <th class="p-4 border-b">Jenis Layanan</th>
                            <th class="p-4 border-b">Wilayah</th>
                            <th class="p-4 border-b">Status</th>
                            <th class="p-4 border-b">Tanggal Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 border-b">{{ $loop->iteration }}</td>
                                <td class="p-4 border-b font-semibold">{{ $record->record_code }}</td>
                                <td class="p-4 border-b">{{ $record->service_type }}</td>
                                <td class="p-4 border-b">{{ $record->region }}</td>
                                <td class="p-4 border-b">{{ ucfirst($record->status) }}</td>
                                <td class="p-4 border-b whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($record->received_at)->format('d-m-Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-500">
                                    Tidak ada layanan pada periode ini yang memiliki tanggal diterima.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
