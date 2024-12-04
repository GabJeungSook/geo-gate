<div>
    <div class="p-4 text-4xl roboto-bold text-gray-700 space-y-2">
        <h1>{{$record->event_description}}</h1>
        <p class="text-2xl roboto-medium text-gray-600">{{$record->campus->name}}</p>
        <p class="text-2xl roboto-medium text-gray-600">{{Carbon\Carbon::parse($record->start_date)->format('F d, Y')}} 
            - 
        {{Carbon\Carbon::parse($record->end_date)->format('F d, Y')}}</p>
    </div>
    <div class="border-t border-gray-400 border-dashed mx-4 py-4 text-4xl roboto-medium text-gray-700 space-y-2 mt-4">
        <h1 class="mb-4">Schedules</h1>
        <div>
            {{$this->table}}
        </div>
    </div>
</div>
