<?php

namespace App\Http\Controllers;

use App\Exceptions\RoomCreationException;
use App\Providers\ValidateServiceProvider;
use denis660\Centrifugo\Centrifugo;

use App\Models\Room;
use App\Models\Message;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;
class RoomController extends Controller
{
    private Centrifugo $centrifugo;

    public function __construct(Centrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }

    public function index()
    {
        $rooms = Room::with(['users', 'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->orderBy('created_at', 'desc')->get();


        return response()->json([
            'rooms' => $rooms,
        ]);
    }

    public function show(int $id)
    {
        $rooms = Room::with('users')->orderBy('created_at', 'desc')->get();
        $room = Room::with(['users', 'messages.user' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->find($id);

        return response()->json([
            'rooms' => $rooms,
            'currRoom' => $room,
            'isJoin' => $room->users->contains('id', Auth::user()->id),
        ]);
    }

    public function join(Room $id)
    {
        $room = Room::find($id);
        $room->users()->attach(Auth::user()->id);

        return redirect()->route('rooms.show', $id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:10', 'unique:rooms'],
        ]);

        DB::beginTransaction();
        try {
            $room = Room::create(['name' => $request->get('name')]);
            $room->users()->attach($request->user()->id);
            DB::commit();
            return redirect()->route('rooms.show', $room->id);
        } catch (Throwable $e) {
            DB::rollBack();
        }

        throw new RoomCreationException($e->getMessage());
    }

    public function publish(int $id, Request $request)
    {
        $requestData = $request->json()->all();
        $status = Response::HTTP_OK;

        try {
            $message = Message::create([
                'sender_id' => $request->user()->id,
                "sender_name" => $request->user()->name,
                'message' => $requestData["message"],
                'room_id' => $id,

            ]);

            $room = Room::with('users')->find($id);

            $channels = [];
            foreach ($room->users as $user) {
                $channels[] = "personal#".$user->id;
            }

            $this->centrifugo->broadcast($channels, [
                "message" => $message->message,
                "id" => $message->id,
                "created_at" => $message->created_at->toDateTimeString(),
                "createdAtFormatted" => $message->created_at->toFormattedDateString() . ", " . $message->created_at->toTimeString(),
                "roomId" => $id,
                "senderId" => Auth::user()->id,
                "sender_name" => Auth::user()->name,
            ]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response('Status:', $status);
    }
}
