<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageUploadHelper;
use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use App\Models\RoomFacility;
use App\Models\RoomType;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RoomController extends Controller
{
    use ImageUploadHelper;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoomsDataTable $dataTable)
    {
        return $dataTable->render('admin.rooms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $types = RoomType::query()->get()->pluck('name', 'id');
        $facilities = RoomFacility::query()->get();

        return view('admin.rooms.form', compact('facilities', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoomRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoomRequest $request)
    {
        /** @var Room $room */
        $request->merge(['user_id' => Auth::id()]);
        $room = Room::query()->create($request->except('_token', 'facilities'));
        $room->facilities()->sync($request->get('facilities'));

        $images = $request->file('images');
        if ($images) {
            foreach ($images as $image) {
                $path = $this->uploadImage($image);
                if ($path) {
                    $room->images()->create([
                        'path' => $path,
                        'size' => $image->getSize(),
                        'main' => false,
                    ]);
                    // TODO implement main image choose functionality
                }
            }
        }

        return redirect()->route('admin.rooms.index')->with([
            'message' => __('Room successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Room $room
     * @return Factory|View
     */
    public function edit(Room $room)
    {
        $types = RoomType::query()->get()->pluck('name', 'id');
        $facilities = RoomFacility::query()->get();
        $roomFacilities = $room->facilities->pluck('id')->toArray();

        return view('admin.rooms.form', compact('facilities', 'room', 'roomFacilities', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoomRequest $request
     * @param Room $room
     * @return RedirectResponse
     */
    public function update(StoreRoomRequest $request, Room $room)
    {
        $request['status'] = (bool)$request->status;
        $room->update($request->except('_token', 'facilities', '_method'));
        $room->facilities()->sync($request->get('facilities'));

        $images = $request->file('images');
        if ($images) {
            foreach ($images as $image) {
                $path = $this->uploadImage($image);
                if ($path) {
                    $room->images()->create([
                        'path' => $path,
                        'size' => $image->getSize(),
                        'main' => false,
                    ]);
                    // TODO implement main image choose functionality
                    // TODO implement images delete functionality
                }
            }
        }

        return redirect()->route('admin.rooms.index')->with([
            'message' => __('Room successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return JsonResponse
     */
    public function destroy(Room $room)
    {
        try {
            $room->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
