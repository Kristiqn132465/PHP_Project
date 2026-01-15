<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Reservation</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('reserved.update', $reservation) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm text-gray-600">Name</label>
                        <input name="name" value="{{ old('name', $reservation->name) }}" class="w-full rounded border-gray-300">
                        @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Gmail</label>
                        <input name="gmail" value="{{ old('gmail', $reservation->gmail) }}" class="w-full rounded border-gray-300">
                        @error('gmail') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Phone</label>
                        <input name="phone" value="{{ old('phone', $reservation->phone) }}" class="w-full rounded border-gray-300">
                        @error('phone') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600">People</label>
                            <input type="number" name="people" value="{{ old('people', $reservation->people) }}" class="w-full rounded border-gray-300">
                            @error('people') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-gray-600">Day</label>
                            <input type="date" name="day" value="{{ old('day', $reservation->day) }}" class="w-full rounded border-gray-300">
                            @error('day') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Hour</label>
                        <input type="time" name="hour" value="{{ old('hour', \Illuminate\Support\Str::of($reservation->hour)->substr(0,5)) }}" class="w-full rounded border-gray-300">
                        @error('hour') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Picture (optional)</label>
                        <input type="file" name="picture" class="w-full">
                        @error('picture') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror

                        @if($reservation->picture_path)
                            <div class="mt-2 text-sm text-gray-600">
                                Current: <a class="underline" href="{{ asset('storage/'.$reservation->picture_path) }}" target="_blank">view</a>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                            Save
                        </button>
                        <a href="{{ route('reserved.index') }}" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
