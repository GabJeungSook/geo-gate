<div>
    <div class="mt-5 flex justify-between items-end">
        <div></div>
        <div class="flex space-x-2">
            <div class="mt-5 space-x-2 flex">
                <button label="PRINT" icon="printer" class="font-bold p-4 rounded-lg w-24 bg-green-600 text-white"
                    @click="printOut($refs.printContainer.outerHTML);">Print</button>
            </div>
        </div>
    </div>
    <div class="mt-5 border rounded-lg p-4" x-ref="printContainer">
        <!-- Table starts here -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-green-600 text-white">
                    <th class="px-4 py-2 border-b text-left">Student Name</th>
                    <th class="px-4 py-2 border-b text-left">Campus</th>
                    <th class="px-4 py-2 border-b text-left">Course</th>
                    <th class="px-4 py-2 border-b text-left">Event</th>
                    <th class="px-4 py-2 border-b text-left">Event Schedule</th>
                    <th class="px-4 py-2 border-b text-left">Time In</th>
                    <th class="px-4 py-2 border-b text-left">Time Out</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendance as $item)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border-b">{{$item->user->userDetails?->last_name}} {{$item->user->userDetails?->first_name}}</td>
                    <td class="px-4 py-2 border-b">{{$item->eventSchedule->event->campus->name}}</td>
                    <td class="px-4 py-2 border-b">{{$item->user->userDetails?->course->course_description}}</td>
                    <td class="px-4 py-2 border-b">{{$item->eventSchedule->event->event_description}}</td>
                    <td class="px-4 py-2 border-b">{{Carbon\Carbon::parse($item->eventSchedule->start_time)->format('h:i A')}} - {{Carbon\Carbon::parse($item->eventSchedule->end_time)->format('h:i A')}}</td>
                    <td class="px-4 py-2 border-b">{{Carbon\Carbon::parse($item->in)->format('h:i A')}}</td>
                    <td class="px-4 py-2 border-b">{{Carbon\Carbon::parse($item->out)->format('h:i A')}}</td>
                </tr>
                @empty
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border-b italic text-center" colspan="7">No Record</td>
                @endforelse
            </tbody>
        </table>
        <!-- Table ends here -->
    </div>
</div>
