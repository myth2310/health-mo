<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\IpEsp;
use Illuminate\Http\Request;

class IpEspController extends Controller
{
    public function update(Request $request)
{
    $ip_esp = IpEsp::where('ipesp_id', 1)->first();

    $ip_esp->update([
        'ip_esp' => $request->ip_esp,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Sukses memperbarui data',
    ], 200);
}

}
