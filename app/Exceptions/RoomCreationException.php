<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class RoomCreationException extends Exception
{
    public function report()
    {
        Log::error($this->getMessage());
    }

    public function render(){

        return response()->json([
            'message' => $this->getMessage(),
        ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
    }
}
