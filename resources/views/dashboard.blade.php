<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Booking List</h3>
                    <a href="{{ route('bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Add Booking
                    </a>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto text-left text-sm divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Customer Name</th>
                                <th class="px-6 py-3 font-semibold">Customer Email</th>
                                <th class="px-6 py-3 font-semibold">Booking Date</th>
                                <th class="px-6 py-3 font-semibold">Booking Type</th>
                                <th class="px-6 py-3 font-semibold">Booking Slot</th>
                                <th class="px-6 py-3 font-semibold">Booking Time</th>
                                <th class="px-6 py-3 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4">{{ $booking->customer_name }}</td>
                                    <td class="px-6 py-4">{{ $booking->customer_email }}</td>
                                    <td class="px-6 py-4">{{ $booking->booking_date }}</td>
                                    <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $booking->booking_type) }}</td>
                                    <td class="px-6 py-4">
                                        {{ $booking->booking_type === 'half_day' ? ucfirst(str_replace('_', ' ', $booking->booking_slot)) : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($booking->booking_type === 'custom')
                                            {{ $booking->booking_from }} - {{ $booking->booking_to }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('bookings.edit', $booking) }}" class="text-blue-600 hover:underline">Edit</a>&nbsp;&nbsp; / &nbsp;&nbsp;
                                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
