
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Layanan - Data Operations Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
    <main class="max-w-3xl mx-auto p-6 md:p-10">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
            <h1 class="text-2xl font-bold text-slate-900">Edit Data Layanan</h1>
            <p class="text-slate-500 mt-2 mb-6">Perbarui informasi data operasional.</p>

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 rounded-lg p-4 mb-5">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('service-records.update', $serviceRecord) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold mb-2">Kode Data</label>
                    <input type="text" name="record_code" required
                           value="{{ old('record_code', $serviceRecord->record_code) }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Jenis Layanan</label>
                    <input type="text" name="service_type" required
                           value="{{ old('service_type', $serviceRecord->service_type) }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Wilayah</label>
                    <input type="text" name="region" required
                           value="{{ old('region', $serviceRecord->region) }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Referensi Pelanggan</label>
                    <input type="text" name="customer_ref"
                           value="{{ old('customer_ref', $serviceRecord->customer_ref) }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Status</label>
                    <select name="status" required class="w-full border border-slate-300 rounded-lg px-4 py-3">
                        @foreach (['pending' => 'Pending', 'processing' => 'Diproses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $serviceRecord->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2">Tanggal Diterima</label>
                    <input type="date" name="received_at"
                           value="{{ old('received_at', $serviceRecord->received_at ? \Carbon\Carbon::parse($serviceRecord->received_at)->format('Y-m-d') : '') }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Catatan</label>
                    <textarea name="notes" rows="4"
                              class="w-full border border-slate-300 rounded-lg px-4 py-3">{{ old('notes', $serviceRecord->notes) }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('service-records.index') }}"
                       class="bg-slate-200 hover:bg-slate-300 px-5 py-3 rounded-lg">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
