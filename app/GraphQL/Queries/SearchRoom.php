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

        $rooms = Room::query()
            ->with('facilities')
            ->where('seats', '>=', $seats)
            ->when($types, function (Builder $q) use ($types) {
                return $q->whereIn('type_id', $types);
            });

        foreach ($facilities as $facility) {
            $rooms = $rooms->whereHas('facilities', function (Builder $q) use ($facility) {
                $q->where('room_facilities.id', $facility);
            });
        }

        if (!$start && $end) {
            $rooms = $rooms->whereHas('bookings', function (Builder $q) use ($end) {
                $q->where('start_date', '>=', $end)->orwhere('end_date', '<', $end);
            })->orWhereDoesntHave('bookings');
        }

        if (!$end && $start) {
            $rooms = $rooms->whereHas('bookings', function (Builder $q) use ($start) {
                $q->where('start_date', '>', $start)->orwhere('end_date', '>=', $start);
            })->orWhereDoesntHave('bookings');
        }

        if ($start && $end) {
            $rooms = $rooms->whereHas('bookings', function (Builder $q) use ($start, $end) {
                $q->where(
                    function (Builder $query) use ($start, $end) {
                        $query->where('start_date', '>', $start)->where('start_date', '>=', $end);
                    }
                )->orWhere(
                    function (Builder $query) use ($start, $end) {
                        $query->where('end_date', '<=', $start)->where('end_date', '<', $end);
                    }
                );
            })->orWhereDoesntHave('bookings');
        }

        $rooms = $rooms->orderBy('created_at', 'desc')->get();

        return $rooms;
    }
}
