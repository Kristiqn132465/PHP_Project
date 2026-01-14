<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservation') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-lg p-6">

                <p class="text-gray-600 mb-6">
                    Please select a date and time between <strong>10:00 and 22:00</strong>.
                </p>

                {{-- Success message --}}
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error summary --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('reservation.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">

                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="name">Name</label>
                        <input id="name" type="text" name="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gmail --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="gmail">Gmail</label>
                        <input id="gmail" type="email" name="gmail"
                               value="{{ old('gmail') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('gmail')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="phone">Phone</label>
                        <input id="phone" type="tel" name="phone"
                               value="{{ old('phone') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Picture (optional) --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="picture">
                            Picture of the person <span class="text-gray-500">(optional)</span>
                        </label>

                        <input id="picture" type="file" name="picture" accept="image/*"
                               class="block w-full text-sm text-gray-700
                                      file:mr-4 file:rounded-lg file:border-0
                                      file:bg-gray-100 file:px-4 file:py-2
                                      file:text-sm file:font-semibold
                                      hover:file:bg-gray-200">

                        @error('picture')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-1">JPG/PNG/WEBP up to 4MB.</p>
                    </div>

                    {{-- Number of people --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="people">Number of people</label>
                        <input id="people" type="number" name="people"
                               min="1" max="50"
                               value="{{ old('people', 2) }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('people')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Day --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="day">Day</label>
                        <input id="day" type="date" name="day"
                               min="{{ now()->toDateString() }}"
                               value="{{ old('day') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('day')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hour --}}
                    <div>
                        <label class="block text-sm font-medium mb-1" for="hour">Hour</label>
                        <input id="hour" type="time" name="hour"
                               min="10:00" max="22:00" step="900"
                               value="{{ old('hour') }}"
                               required
                               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                        @error('hour')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-500 mt-1">Open hours: 10:00–22:00 (15 min steps).</p>
                    </div>

                    <button type="submit"
                            class="w-full mt-4 rounded-lg bg-indigo-600 text-white py-2.5 font-semibold hover:bg-indigo-700">
                        Submit Reservation
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
