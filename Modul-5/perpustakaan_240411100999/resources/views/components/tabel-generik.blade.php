@props(['rows'])
@php $kolom = $rows->isNotEmpty() ? array_keys((array) $rows->first()) : []; @endphp

<div class="overflow-x-auto rounded-lg bg-white shadow-sm">
    <table class="min-w-full text-left text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                @foreach ($kolom as $k)
                    <th class="p-3">{{ $k }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr class="border-t">
                    @foreach ((array) $row as $nilai)
                        <td class="p-3">{{ $nilai }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td class="p-3 text-gray-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>