<?php

namespace App\GraphQL\Queries;

use App\Models\Room;
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
        $start = $args['start'] ?? null;
        $end = $args['end'] ?? null;
        $name = $args['name'] ?? null;

        $rooms = Room::query()
            ->with('facilities')
            ->where('seats', '>=', $seats)
            ->when($types, function (Builder $q) use ($types) {
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

        if (!$start && $end) {
            $rooms = $rooms->where(function ($wq) use ($end) {
                return $wq->whereHas('bookings', function (Builder $q) use ($end) {
                    $q->where('start_date', '>=', $end)->orWhere('end_date', '<', $end);
                })->orWhereDoesntHave('bookings');
            });
        }

        if ($start && !$end) {
            $rooms = $rooms->where(function ($wq) use ($start) {
                return $wq->whereHas('bookings', function (Builder $q) use ($start) {
                    $q->where('start_date', '>', $start)->orWhere('end_date', '>=', $start);
                })->orWhereDoesntHave('bookings');
            });
        }

        if ($start && $end) {
            $rooms = $rooms
                ->where(function ($wq) use ($start, $end) {
                    return $wq
                        ->whereDoesntHave('bookings', function (Builder $q) use ($start, $end) {
                            return $q
                                ->whereBetween('start_date', [$start, $end])
                                ->orWhereBetween('end_date', [$start, $end]);
                        });
                });
        }

        $rooms = $rooms->orderBy('created_at', 'desc')->get();

        if ($start) {
            $rooms->map(function ($room) use ($start) {
                return $room->available_at = get_room_available_from($room, $start);
            });
        }

        return $rooms;
    }
}
