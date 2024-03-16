<?php

namespace Plugin\TlcommerceCore\Repositories;

use Core\Models\User;
use Illuminate\Support\Facades\Mail;
use Plugin\TlcommerceCore\Models\Customers;
use Illuminate\Support\Facades\Notification;
use Plugin\TlcommerceCore\Mail\OrderConfirmMail;
use Plugin\TlcommerceCore\Mail\OrderStatusUpdateMail;
use Plugin\TlcommerceCore\Repositories\SettingsRepository;
use Plugin\TlcommerceCore\Notifications\OrderStatusUpdateNotification;
use Plugin\TlcommerceCore\Notifications\CustomerOrderCancelNotification;
use Plugin\TlcommerceCore\Notifications\CustomerOrderCreateNotification;
use Plugin\TlcommerceCore\Notifications\CustomerOrderReturnNotification;
use Plugin\TlcommerceCore\Notifications\CustomerProductReviewNotification;
use Plugin\TlcommerceCore\Notifications\CustomerOrderPaymentCompletedNotification;

class EcommerceNotification
{
    /**
     * Will send order status notification to customer
     * 
     * @param Int $order_id
     * @param Int $customer_id
     * @param String $message
     */
    public static function sendOrderStatusNotification($order_id, $customer_id, $message, $btn_title, $mail_title)
    {

        $link = '/dashboard/order-details/' . $order_id;
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $customer = Customers::where('id', $customer_id)->first();
        if ($customer != null) {
            $customer->notify(new OrderStatusUpdateNotification($data));
            //Send mail to customer
            $mail_data = [
                'template_id' => 11,
                'keywords' => getEmailTemplateVariables(11, true),
                'subject' => $mail_title,
                '_tracking_url_' => url('/') . '/dashboard/order-details/' . $order_id,
                '_customer_name_' => $customer->name,
                '_message_' => $message,
                '_btn_title_' => $btn_title,
                '_mail_title_' => $mail_title,
            ];
            Mail::to($customer->email)->send(new OrderStatusUpdateMail($mail_data));
        }
    }
    /**
     * Will send new order notification 
     * 
     * @param Object $order_id
     */
    public static function sendNewOrderNotification($order)
    {
        $link = '/orders/order-details/' . $order->id;
        $message = "New order";
        $data = [
            'message' => $message,
            'link' => $link
        ];
        //Send notification to admin
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerOrderCreateNotification($data));
        }
        //Send invoice to customer
        if (SettingsRepository::getEcommerceSetting('send_invoice_to_customer_mail') == config('settings.general_status.active')) {
            $customer_email = $order->customer_info != null ? $order->customer_info->email : $order->guest_customer->email;
            $customer_name = $order->customer_info != null ? $order->customer_info->name : 'kousar';
            $mail_data = [
                'template_id' => 10,
                'keywords' => getEmailTemplateVariables(10, true),
                'subject' => 'Your order has been placed!',
                '_order_code_' =>  $order->order_code,
                '_tracking_url_' => url('/') . '/dashboard/order-details/' . $order->id,
                '_customer_name_' => $customer_name,
                '_order_details_' => view('plugin/tlecommercecore::mail.order_details_mail', ['order_id' => $order->id])->render(),
            ];
            Mail::to($customer_email)->send(new OrderConfirmMail($mail_data));
        }
    }
    /**
     * Will send new order notification 
     * 
     * @param Int $order_id
     */
    public static function sendCustomerOrderCancelNotification($order_id, $message)
    {
        $link = '/orders/order-details/' . $order_id;
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerOrderCancelNotification($data));
        }
    }

    /**
     * Will send customer product review notification to admin
     * 
     * @param String $message
     */
    public static function sendCustomerProductReviewNotification($message)
    {
        $link = '/product-reviews';
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerProductReviewNotification($data));
        }
    }

    /**
     * Will send customer order return notification to admin
     * 
     * @param Int $id
     * @param String $message
     */
    public static function sendCustomerOrderReturnNotification($id, $message)
    {
        $link = '/refunds/refund-request-details/' . $id;
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerOrderReturnNotification($data));
        }
    }

    /**
     * Will send customer order payment completed to admin
     * 
     * @param Int $order_id
     * @param String $message
     */
    public static function sendCustomerOrderPaymentCompletedNotification($order_id, $message)
    {
        $link = '/orders/order-details/' . $order_id;
        $data = [
            'message' => $message,
            'link' => $link
        ];
        $users = User::all();
        if ($users != null) {
            Notification::send($users, new CustomerOrderPaymentCompletedNotification($data));
        }
    }
}
