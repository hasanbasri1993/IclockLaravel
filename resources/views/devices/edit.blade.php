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
                        Updatesdfs d
                    </button>
                </form>


dfsdfsdf
                <form class="max-w-sm mx-auto">
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                        <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                    <div class="flex items-start mb-5">
                        <div class="flex items-center h-5">
                            <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                        </div>
                        <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
