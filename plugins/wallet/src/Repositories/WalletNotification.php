<?php

namespace Plugin\Wallet\Repositories;

use Core\Models\User;
use Plugin\TlcommerceCore\Models\Customers;
use Illuminate\Support\Facades\Notification;
use Plugin\Wallet\Notifications\CustomerWalletRechargeNotification;
use Plugin\Wallet\Notifications\WalletTransactionStatusUpdateNotification;

class WalletNotification
{

    /**
     * Wii send customer wallet recharge notification to admin
     * 
     * @param String $message
     * @return void
     */
    public static function sendCustomerWalletRechargeNotification($message)
    {
        $link = '/wallet/wallet-transactions';
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerWalletRechargeNotification($data));
        }
    }

    /**
     * Wii send customer wallet recharge notification to admin
     * 
     * @param String $message
     * @return void
     */
    public static function sendWalletStatusUpdateNotification($customer_id, $message)
    {
        $link = '/dashboard/wallet';
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $customer = Customers::where('id', $customer_id)->first();
        if ($customer != null) {
            $customer->notify(new WalletTransactionStatusUpdateNotification($data));
        }
    }
}
