<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Device
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-5">

                <div class="space-y-12">
                    <div class=" pb-12">
                        <h2 class="text-base/7 font-semibold text-gray-900">
                            Status: {{ \Carbon\Carbon::parse($device->online)->diffInMinutes(now()) < 2 ? 'ONLINE' : 'OFFLINE' }}</h2>
                        <h2 class="text-base/7 font-semibold text-gray-900">Last Online: {{ $device->online }}</h2>
                    </div>
                </div>


                <form action="{{ route('devices.update', $device->id) }}" method="post">
                    @csrf
                    @method('put')


                    <div class="mb-4">
                        <label for="exampleFormControlInput1" class="block text-gray-700">Nomor Serial</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" disabled
                               id="exampleFormControlInput1" placeholder=""
                               name="no_sn"
                               value="{{ $device->no_sn }}">
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2" class="block text-gray-700">Name</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="exampleFormControlInput2" placeholder="" name="nama"
                               value="{{ $device->nama }}">
                    </div>

                    <div class="mb-4">
                        <label for="exampleFormControlInput3" class="block text-gray-700">Lokasi</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="exampleFormControlInput3" placeholder="" name="lokasi"
                               value="{{ $device->lokasi }}">
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
