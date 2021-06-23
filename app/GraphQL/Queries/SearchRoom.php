<?php

namespace App\GraphQL\Queries;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class SearchRoom
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Builder[]|Collection
     */
    public function __invoke($_, array $args)
    {
        $types = $args['types'] ?? null;
        $seats = $args['seats'] ?? 0;
        $facilities = $args['facilities'] ?? [];
        $start = $args['start'] ?? Carbon::now();
        $end = $args['end'] ?? Carbon::now()->endOfDay();
        $name = $args['name'] ?? null;

        if ($start <= Carbon::now()) $start = Carbon::now();
        if ($end->gt($start)) {
            $startClone = clone $start;
            $end = $startClone->endOfDay();
        }

        $rooms = Room::query()
            ->with('facilities')
            ->where('seats', '>=', $seats);
           if($name==null){
            $rooms->where(function ($wq) use ($start, $end) {
                return $wq->whereDoesntHave('bookings', function (Builder $q) use ($start, $end) {
                    return $q
                        // ->whereBetween('start_date', [$start, $end])
                        // ->orWhereBetween('end_date', [$start, $end]);
                        ->where(function($q) use ($start,$end){
                            $q->where('start_date','>=',$start)->where('start_date','<=',$start);
                        })->orWhere(function($q) use ($start,$end){
                            $q->where('end_date','>=',$end)->where('end_date','<=',$end);
                        });
                });
            });
           }
           $rooms->when($types, function (Builder $q) use ($types) {
                return $q->whereIn('type_id', $types);
            })
            ->when($name, function (Builder $q) use ($name) {
                return $q->where('name', 'LIKE', '%' . $name . '%');
            });

        foreach ($facilities as $facility) {
            $rooms = $rooms->whereHas('facilities', function (Builder $q) use ($facility) {
                $q->where('room_facilities.id', $facility);
            });
        }

        $rooms = $rooms->orderBy('created_at', 'desc')->get();

        if ($start) {
            $rooms->map(function ($room) use ($start) {
                $end = $args['end'] ?? Carbon::now()->endOfDay();
                return $room->available_at = get_room_available_from($room, $start,$end);
            });
        }

        return $rooms;
    }
}
