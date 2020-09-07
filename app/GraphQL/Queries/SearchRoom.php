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
        $types = $args['type'];
        $seats = $args['seats'];
        $facilities = $args['facilities'];

        $rooms = Room::query()
            ->with('facilities')
            ->whereIn('type_id', $types)
            ->where('seats', '>=', $seats);

        foreach ($facilities as $facility) {
            $rooms = $rooms->whereHas('facilities', function (Builder $q) use ($facility) {
                $q->where('room_facilities.id', $facility);
            });
        }

        $rooms = $rooms->orderBy('created_at', 'desc')->get();

        return $rooms;
    }
}
