<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Layanan - Data Operations Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="max-w-5xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-bold text-slate-800">
            Data Operations Suite
        </h1>
        <p class="text-slate-500 mt-2 mb-8">
            Manajemen data layanan operasional
        </p>

        <div class="bg-white rounded-xl shadow p-8">
            <h2 class="text-2xl font-semibold mb-6">
                Tambah Data Layanan
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('service-records.store') }}"
                  method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block font-medium mb-2">Kode Layanan</label>
                    <input type="text" name="record_code"
                           value="{{ old('record_code') }}"
                           placeholder="Contoh: SRV-001"
                           class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block font-medium mb-2">Jenis Layanan</label>
                    <input type="text" name="service_type"
                           value="{{ old('service_type') }}"
                           placeholder="Contoh: Perbaikan Jaringan"
                           class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block font-medium mb-2">Wilayah</label>
                    <input type="text" name="region"
                           value="{{ old('region') }}"
                           placeholder="Contoh: Medan Kota"
                           class="w-full border rounded-lg p-3" required>
                </div>

                <div>
                    <label class="block font-medium mb-2">Referensi Pelanggan</label>
                    <input type="text" name="customer_ref"
                           value="{{ old('customer_ref') }}"
                           placeholder="Contoh: CUST-001"
                           class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block font-medium mb-2">Status</label>
                    <select name="status" class="w-full border rounded-lg p-3" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-2">Tanggal Diterima</label>
                    <input type="date" name="received_at"
                           value="{{ old('received_at') }}"
                           class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block font-medium mb-2">Catatan</label>
                    <textarea name="notes" rows="4"
                              class="w-full border rounded-lg p-3"
                              placeholder="Tambahkan catatan jika diperlukan">{{ old('notes') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        Simpan Data
                    </button>

                    <a href="{{ route('service-records.index') }}"
                       class="bg-slate-200 px-6 py-3 rounded-lg hover:bg-slate-300">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
```