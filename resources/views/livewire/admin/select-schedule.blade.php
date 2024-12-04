<div>
    <div class="grid grid-cols-3 mt-8">
        <div class="grid col-start-2">
            <img src="{{ asset('images/geogate_logo.png') }}" class="mx-auto xl:h-48 xl:w-48 sm:h-16 sm:w-48" alt="">
        </div>
    </div>

    @if (is_null($record))
        <!-- No Active Schedule UI -->
        <div class="flex flex-col items-center justify-center h-screen">
            <h1 class="text-3xl font-bold text-gray-700 mb-4">No Active Schedule</h1>
            <p class="text-lg text-gray-600">Please contact the administrator or check back later.</p>
        </div>
    @else
        @if (!$scanning)
            <!-- Selection UI -->
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{$record->event->event_description}}</h1>
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{$record->event->campus->name}}</h1>
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{Carbon\Carbon::parse($record->schedule_date)->format('F d, Y')}}</h1>
                <h1 class="text-2xl font-bold text-gray-700 mb-4">
                    {{Carbon\Carbon::parse($record->start_time)->format('h:i A')}} - 
                    {{Carbon\Carbon::parse($record->end_time)->format('h:i A')}}</h1>
                <div class="space-x-4">
                    <button wire:click="startScanning('Time In')" class="px-6 py-3 bg-green-500 text-white font-medium rounded-md hover:bg-green-600">
                        Time In
                    </button>
                    <button wire:click="startScanning('Time Out')" class="px-6 py-3 bg-red-500 text-white font-medium rounded-md hover:bg-red-600">
                        Time Out
                    </button>
                </div>
            </div>
        @else
            <!-- Scanning UI -->
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{$record->event->event_description}}</h1>
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{$record->event->campus->name}}</h1>
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{Carbon\Carbon::parse($record->schedule_date)->format('F d, Y')}}</h1>
                <h1 class="text-2xl font-bold text-gray-700">
                    {{Carbon\Carbon::parse($record->start_time)->format('h:i A')}} - 
                    {{Carbon\Carbon::parse($record->end_time)->format('h:i A')}}</h1>            
                <h1 class="text-2xl font-bold text-gray-700 mb-2">{{$action}}</h1>
            </div>
            <div class="flex justify-center mt-5">
                <input wire:model="scannedCode" wire:change="verifyQR" type="text" id="qrInput" class="text-center p-4 text-2xl focus:outline-none w-full mx-14 rounded-md" autofocus>
            </div>
            <small class="flex justify-center mt-3 font-medium">*Scan QR Code Here*</small>
            <div class="flex justify-center mt-5">
                <button wire:click="stopScanning" class="px-6 py-3 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600">
                    Stop Scanning
                </button>
            </div>
        @endif
    @endif
</div>

<script>
    // Function to ensure the scanning input is always focused
    const qrInput = document.getElementById('qrInput');

    function ensureFocus() {
        if (qrInput && document.activeElement !== qrInput) {
            qrInput.focus();
        }
    }

    if (qrInput) {
        // Continuously check focus
        setInterval(ensureFocus, 100);

        // Prevent default behavior of clicking away
        document.addEventListener('click', (e) => {
            if (e.target.id !== 'qrInput' && e.target.tagName !== 'BUTTON') {
                e.preventDefault();
                qrInput.focus();
            }
        });
    }
</script>
