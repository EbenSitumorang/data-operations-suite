<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Operations Suite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .sidebar-link { display:flex; align-items:center; gap:.8rem; border-radius:.8rem; padding:.75rem .9rem; color:#cbd5e1; font-size:.9rem; font-weight:600; transition:all .18s ease; }
        .sidebar-link:hover, .sidebar-link.active { background:#1e293b; color:#fff; }
        .sidebar-link.active { box-shadow:inset 3px 0 0 #60a5fa; }
        .card-lift { transition:transform .18s ease, box-shadow .18s ease; }
        .card-lift:hover { transform:translateY(-2px); box-shadow:0 16px 32px rgba(15,23,42,.08); }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="min-h-screen lg:flex">

        {{-- SIDEBAR --}}
        <aside class="bg-slate-950 text-white lg:fixed lg:inset-y-0 lg:left-0 lg:flex lg:w-64 lg:flex-col">
            <div class="flex items-center gap-3 border-b border-slate-800 px-5 py-6">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500 text-lg font-extrabold shadow-lg shadow-blue-950/30">DO</div>
                <div>
                    <p class="font-bold tracking-wide">Data Operations</p>
                    <p class="mt-0.5 text-xs text-slate-400">Management Suite</p>
                </div>
            </div>

            <div class="px-4 py-5">
                <p class="mb-3 px-3 text-[11px] font-bold uppercase tracking-[.18em] text-slate-500">Menu utama</p>
                <nav class="space-y-1">
                    <a href="{{ route('service-records.index') }}" class="sidebar-link active">
                        <span class="text-lg">▦</span><span>Dashboard & Data</span>
                    </a>
                    <a href="{{ route('service-records.create') }}" class="sidebar-link">
                        <span class="text-lg">＋</span><span>Tambah Data Layanan</span>
                    </a>
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('service-records.monthly-report') }}" class="sidebar-link">
                            <span class="text-lg">▤</span><span>Laporan Bulanan</span>
                        </a>
                    @endif
                </nav>

                <p class="mb-3 mt-8 px-3 text-[11px] font-bold uppercase tracking-[.18em] text-slate-500">Akun</p>
                <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-500/20 font-bold text-blue-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="mt-1 text-xs font-bold {{ auth()->user()->role === 'admin' ? 'text-indigo-300' : 'text-emerald-300' }}">
                                {{ strtoupper(auth()->user()->role) }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-slate-700 px-3 py-2 text-sm font-semibold text-slate-300 transition hover:border-slate-500 hover:bg-slate-800 hover:text-white">
                            Keluar dari sistem
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-auto hidden border-t border-slate-800 px-5 py-5 lg:block">
                <p class="text-xs leading-5 text-slate-500">Workspace internal<br>Simulasi operasional</p>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="min-w-0 flex-1 px-4 py-5 sm:px-6 lg:ml-64 lg:px-8 lg:py-8">
            {{-- TOP BAR --}}
            <header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.2em] text-blue-600">Operations overview</p>
                    <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-950 sm:text-3xl">Dashboard Operasional</h1>
                    <p class="mt-2 text-sm text-slate-500">Pantau dan kelola data layanan dari satu tempat.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Tanggal akses</p>
                        <p class="mt-1 text-sm font-bold text-slate-700">{{ date('d M Y') }}</p>
                    </div>
                    <a href="{{ route('service-records.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">
                        <span class="text-lg leading-none">＋</span> Tambah Data
                    </a>
                </div>
            </header>

            @if (session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800 shadow-sm" role="status">
                    <span class="font-bold">✓</span>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            {{-- KPI CARDS --}}
            <section class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
                <div class="card-lift relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-blue-50"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Total Data</p>
                            <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-slate-950">{{ $records->total() }}</h2>
                            <p class="mt-3 text-xs font-medium text-slate-500">Data sesuai hasil pencarian</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl font-extrabold text-blue-700">D</div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-blue-500"></div>
                </div>

                <div class="card-lift relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-amber-50"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Data Pending</p>
                            <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-amber-600">{{ \App\Models\ServiceRecord::where('status', 'pending')->count() }}</h2>
                            <p class="mt-3 text-xs font-medium text-slate-500">Menunggu tindak lanjut</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-xl font-extrabold text-amber-700">P</div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-amber-500"></div>
                </div>

                <div class="card-lift relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="absolute right-0 top-0 h-28 w-28 rounded-bl-full bg-emerald-50"></div>
                    <div class="relative flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-500">Data Selesai</p>
                            <h2 class="mt-3 text-4xl font-extrabold tracking-tight text-emerald-600">{{ \App\Models\ServiceRecord::where('status', 'completed')->count() }}</h2>
                            <p class="mt-3 text-xs font-medium text-slate-500">Layanan telah diselesaikan</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-xl font-extrabold text-emerald-700">S</div>
                    </div>
                    <div class="absolute bottom-0 left-0 h-1 w-full bg-emerald-500"></div>
                </div>
            </section>

            {{-- CHART DATA --}}
            @php
                $regionStats = \App\Models\ServiceRecord::query()
                    ->selectRaw('region, COUNT(*) as total')
                    ->groupBy('region')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get();

                $serviceStats = \App\Models\ServiceRecord::query()
                    ->selectRaw('service_type, COUNT(*) as total')
                    ->groupBy('service_type')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get();

                $maxRegion = max(1, (int) ($regionStats->max('total') ?? 0));
                $maxService = max(1, (int) ($serviceStats->max('total') ?? 0));
            @endphp

            {{-- CHARTS --}}
            <section class="mb-8 grid grid-cols-1 gap-5 xl:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                    <div class="mb-7 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-lg font-extrabold text-indigo-700">W</div>
                        <div>
                            <h2 class="font-bold text-slate-900 sm:text-lg">Layanan per Wilayah</h2>
                            <p class="mt-1 text-xs text-slate-500">Lima wilayah dengan jumlah layanan terbanyak</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @forelse ($regionStats as $item)
                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <span class="text-sm font-semibold capitalize text-slate-700">{{ $item->region ?: 'Tidak diketahui' }}</span>
                                    <span class="text-xs font-bold text-slate-500">{{ $item->total }} data</span>
                                </div>
                                <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-500" style="width: {{ ($item->total / $maxRegion) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="rounded-xl bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">Belum ada data wilayah.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                    <div class="mb-7 flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-100 text-lg font-extrabold text-cyan-700">L</div>
                        <div>
                            <h2 class="font-bold text-slate-900 sm:text-lg">Jenis Layanan Terbanyak</h2>
                            <p class="mt-1 text-xs text-slate-500">Lima jenis layanan yang paling sering tercatat</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @forelse ($serviceStats as $item)
                            <div>
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <span class="text-sm font-semibold capitalize text-slate-700">{{ $item->service_type ?: 'Tidak diketahui' }}</span>
                                    <span class="text-xs font-bold text-slate-500">{{ $item->total }} data</span>
                                </div>
                                <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-sky-400 transition-all duration-500" style="width: {{ ($item->total / $maxService) * 100 }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="rounded-xl bg-slate-50 px-4 py-8 text-center text-sm text-slate-500">Belum ada data jenis layanan.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- STATUS OVERVIEW --}}
            <section class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7">
                <div class="mb-6">
                    <h2 class="font-bold text-slate-900 sm:text-lg">Statistik Status Layanan</h2>
                    <p class="mt-1 text-sm text-slate-500">Ringkasan seluruh data layanan berdasarkan status.</p>
                </div>

                @php
                    $statusStats = [
                        ['label' => 'Pending', 'status' => 'pending', 'color' => 'bg-amber-500'],
                        ['label' => 'Diproses', 'status' => 'processing', 'color' => 'bg-blue-500'],
                        ['label' => 'Selesai', 'status' => 'completed', 'color' => 'bg-emerald-500'],
                        ['label' => 'Dibatalkan', 'status' => 'cancelled', 'color' => 'bg-red-500'],
                    ];
                    $statusTotal = \App\Models\ServiceRecord::count();
                @endphp

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    @foreach ($statusStats as $stat)
                        @php
                            $count = \App\Models\ServiceRecord::where('status', $stat['status'])->count();
                            $percentage = $statusTotal > 0 ? ($count / $statusTotal) * 100 : 0;
                        @endphp
                        <div class="rounded-xl border border-slate-100 bg-slate-50/70 p-4">
                            <div class="mb-3 flex items-center justify-between gap-4">
                                <span class="text-sm font-bold text-slate-700">{{ $stat['label'] }}</span>
                                <span class="text-xs font-semibold text-slate-500">{{ $count }} data · {{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-slate-200">
                                <div class="{{ $stat['color'] }} h-full rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- SERVICE RECORDS TABLE --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 p-6 sm:p-7">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="h-6 w-1 rounded-full bg-blue-600"></span>
                                <h2 class="text-xl font-extrabold text-slate-950 sm:text-2xl">Daftar Data Layanan</h2>
                            </div>
                            <p class="mt-2 text-sm text-slate-500">Cari, filter, dan pantau data layanan operasional.</p>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                            <span class="font-extrabold text-slate-900">{{ $records->total() }}</span> data ditemukan
                        </div>
                    </div>

                    <form action="{{ route('service-records.index') }}" method="GET" class="mt-6 grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari kode, layanan, atau wilayah..."
                               class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <select name="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="">Semua Status</option>
                            <option value="pending" @selected(($status ?? '') === 'pending')>Pending</option>
                            <option value="processing" @selected(($status ?? '') === 'processing')>Diproses</option>
                            <option value="completed" @selected(($status ?? '') === 'completed')>Selesai</option>
                            <option value="cancelled" @selected(($status ?? '') === 'cancelled')>Dibatalkan</option>
                        </select>

                        <button type="submit" class="w-full rounded-xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                            Cari Data
                        </button>

                        <a href="{{ route('service-records.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-100">
                            Reset Filter
                        </a>
                    </form>

                    @if (auth()->user()->role === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('service-records.export', request()->only(['search', 'status'])) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
                                <span>↓</span> Ekspor CSV
                            </a>
                        </div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-[.12em] text-slate-500">
                            <tr>
                                <th class="border-b border-slate-200 px-5 py-4">No.</th>
                                <th class="border-b border-slate-200 px-5 py-4">Kode</th>
                                <th class="border-b border-slate-200 px-5 py-4">Jenis Layanan</th>
                                <th class="border-b border-slate-200 px-5 py-4">Wilayah</th>
                                <th class="border-b border-slate-200 px-5 py-4">Status</th>
                                <th class="border-b border-slate-200 px-5 py-4">Tanggal</th>
                                <th class="border-b border-slate-200 px-5 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($records as $record)
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                        'processing' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                        'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                        'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'processing' => 'Diproses',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <tr class="transition hover:bg-blue-50/40">
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-400">{{ $records->firstItem() + $loop->index }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-extrabold text-slate-900">{{ $record->record_code }}</td>
                                    <td class="px-5 py-4 text-sm font-medium text-slate-700">{{ $record->service_type }}</td>
                                    <td class="px-5 py-4 text-sm capitalize text-slate-600">{{ $record->region }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset {{ $statusClasses[$record->status] ?? 'bg-slate-100 text-slate-700 ring-slate-500/20' }}">
                                            {{ $statusLabels[$record->status] ?? ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                        {{ $record->received_at ? \Carbon\Carbon::parse($record->received_at)->format('d-m-Y') : '-' }}
                                    </td>
                                   
<td class="whitespace-nowrap px-5 py-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('service-records.edit', $record) }}"
           class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700 transition hover:bg-blue-100">
            Edit
        </a>

        <a href="{{ route('service-records.show', $record) }}"
           class="rounded-lg bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-700 transition hover:bg-indigo-100">
            Detail
        </a>

        @if (auth()->user()->role === 'admin')
            <form action="{{ route('service-records.destroy', $record) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-700 transition hover:bg-red-100">
                    Hapus
                </button>
            </form>
        @endif
    </div>
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-14 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xl text-slate-400">⌕</div>
                                            <p class="font-bold text-slate-700">Data tidak ditemukan</p>
                                            <p class="mt-1 text-sm text-slate-500">
                                                @if (request('search') || request('status'))
                                                    Coba ubah kata kunci atau reset filter.
                                                @else
                                                    Belum ada data layanan yang tercatat.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 bg-slate-50/60 p-5">
                    {{ $records->links() }}
                </div>
            </section>

            <footer class="mt-8 flex flex-col gap-2 pb-4 text-center text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:text-left">
                <p>Data Operations Suite &copy; {{ date('Y') }} — Proyek simulasi operasional</p>
                <p>Workspace · {{ strtoupper(auth()->user()->role) }}</p>
            </footer>
        </main>
    </div>
</body>
</html>
 