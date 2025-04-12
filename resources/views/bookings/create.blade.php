<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($booking) ? 'Edit' : 'Add' }} Booking
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

             

                <form method="POST" action="{{ isset($booking) ? route('bookings.update', $booking) : route('bookings.store') }}">
                    @csrf
                    @if(isset($booking)) @method('PUT') @endif

                    
                    <div class="mb-4">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer Name</label>
                        <input id="customer_name" name="customer_name" type="text" 
                               value="{{ old('customer_name', $booking->customer_name ?? '') }}"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                        @error('customer_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer Email</label>
                        <input id="customer_email" name="customer_email" type="email" 
                               value="{{ old('customer_email', $booking->customer_email ?? '') }}"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                        @error('customer_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="booking_date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Booking Date</label>
                        <input id="booking_date" name="booking_date" type="date" 
                               value="{{ old('booking_date', $booking->booking_date ?? '') }}"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                        @error('booking_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="booking_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Booking Type</label>
                        <select name="booking_type" id="booking_type" onchange="handleTypeChange(this.value)"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Type</option>
                            <option value="full_day" {{ old('booking_type', $booking->booking_type ?? '') == 'full_day' ? 'selected' : '' }}>Full Day</option>
                            <option value="half_day" {{ old('booking_type', $booking->booking_type ?? '') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="custom" {{ old('booking_type', $booking->booking_type ?? '') == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                        @error('booking_type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4" id="booking_slot_container" style="display: none;">
                        <label for="booking_slot" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Booking Slot</label>
                        <select name="booking_slot" id="booking_slot"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Slot</option>
                            <option value="first_half" {{ old('booking_slot', $booking->booking_slot ?? '') == 'first_half' ? 'selected' : '' }}>First Half</option>
                            <option value="second_half" {{ old('booking_slot', $booking->booking_slot ?? '') == 'second_half' ? 'selected' : '' }}>Second Half</option>
                        </select>
                        @error('booking_slot')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="custom_times" style="display: none;">
                        <div class="mb-4">
                            <label for="booking_from" class="block text-sm font-medium text-gray-700 dark:text-gray-200">From</label>
                            <input id="booking_from" name="booking_from" type="time"
                                   value="{{ old('booking_from', $booking->booking_from ?? '') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                            @error('booking_from')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="booking_to" class="block text-sm font-medium text-gray-700 dark:text-gray-200">To</label>
                            <input id="booking_to" name="booking_to" type="time"
                                   value="{{ old('booking_to', $booking->booking_to ?? '') }}"
                                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                            @error('booking_to')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-sm">
                            {{ isset($booking) ? 'Update Booking' : 'Book Now' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleTypeChange(type) {
            document.getElementById('booking_slot_container').style.display = (type === 'half_day') ? 'block' : 'none';
            document.getElementById('custom_times').style.display = (type === 'custom') ? 'block' : 'none';
        }

        window.onload = function () {
            handleTypeChange(document.getElementById('booking_type').value);
        };
    </script>
</x-app-layout>
