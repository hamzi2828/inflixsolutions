<?php

namespace Core\Http\Controllers;

use Core\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SystemUpdateController extends Controller
{

    public function __construct()
    {
        $user = User::find(Auth::user()->id);
        if (!$user->hasRole('Super Admin')) {
            abort(403);
        }
    }

    /**
     * Will redirect to system update page
     */
    public function updateSystem()
    {
        return view('core::base.update_system.update');
    }

    /**
     * Will update database
     */
    public function updateDatabase()
    {
        try {
            $data = [
                ['id' => 4, 'name' => 'Paddle', 'status' => 1],
                ['id' => 5, 'name' => 'Sslcommerz', 'status' => 1],
                ['id' => 6, 'name' => 'Paystack', 'status' => 1],
                ['id' => 7, 'name' => 'Razorpay', 'status' => 1],
            ];
            foreach ($data as $row) {
                DB::table('tl_com_payment_methods')->updateOrInsert(
                    ['id' => $row['id']],
                    $row
                );
            }
            toastNotification('success', 'Successfully Updated Database');
            return redirect()->back();
        } catch (\Exception $th) {
            toastNotification('error', 'Database update unsuccessful');
            return redirect()->back();
        }
    }
}
