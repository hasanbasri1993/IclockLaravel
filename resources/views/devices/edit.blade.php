<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <h2 class="text-2xl font-semibold mb-4">Edit Device</h2>
                <form method="post" action="{{ route('devices.update', $device->id) }}">
                    @csrf
                    @method('put')
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700">Nama</label>
                        <input type="text" name="nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="nama" value="{{ $device->nama }}">
                    </div>
                    <div class="mb-4">
                        <label for="no_sn" class="block text-gray-700">Nomor Serial</label>
                        <input type="text" name="no_sn" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="no_sn" value="{{ $device->no_sn }}">
                    </div>
                    <div class="mb-4">
                        <label for="lokasi" class="block text-gray-700">Lokasi</label>
                        <input type="text" name="lokasi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="lokasi" value="{{ $device->lokasi }}">
                    </div>
                    <div class="mb-4">
                        <label for="online" class="block text-gray-700">Online</label>
                        <input type="text" name="online" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                               id="online" value="{{ $device->online }}">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
