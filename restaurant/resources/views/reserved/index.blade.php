<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Reserved') }}
            </h2>

            <form method="GET" action="{{ route('reserved.index') }}" class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="day" class="text-sm text-gray-600">Day</label>
                    <input id="day" name="day" type="date"
                           value="{{ $selectedDay }}"
                           class="rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="ahead" value="1" {{ $ahead ? 'checked' : '' }}
                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    Show 3 days ahead
                </label>

                <button type="submit"
                        class="rounded-lg bg-indigo-600 text-white px-4 py-2 text-sm font-semibold hover:bg-indigo-700">
                    Search
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-700 mb-4">
                    Showing reservations for
                    <span class="font-semibold">{{ $selectedDay }}</span>
                    @if($ahead)
                        <span class="text-gray-500">(and the next 3 days)</span>
                    @endif
                </div>

                @if($reservations->isEmpty())
                    <div class="text-gray-600">No reservations found.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600 border-b">
                                <tr>
                                    <th class="py-2 pr-4">Day</th>
                                    <th class="py-2 pr-4">Time</th>
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">People</th>
                                    <th class="py-2 pr-4">Phone</th>
                                    <th class="py-2 pr-4">Gmail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($reservations as $r)
                                    <tr>
                                        <td class="py-2 pr-4">{{ $r->day }}</td>
                                        <td class="py-2 pr-4">{{ \Illuminate\Support\Str::of($r->hour)->substr(0,5) }}</td>
                                        <td class="py-2 pr-4 font-medium text-gray-900">{{ $r->name }}</td>
                                        <td class="py-2 pr-4">{{ $r->people }}</td>
                                        <td class="py-2 pr-4">{{ $r->phone }}</td>
                                        <td class="py-2 pr-4">{{ $r->gmail }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
