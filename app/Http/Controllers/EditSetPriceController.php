<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class EditSetPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bachelor,master,bachelor_margin,master_margin',
            'price' => 'required|integer',
        ]);

        return Config::editSetPrice($request->type, $request->price);
    }
}
