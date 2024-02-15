<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\CPU\Helpers;
use App\Model\Setting;
use App\Model\Notification;
use App\Model\Shop;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use function App\CPU\translate;
use Illuminate\Support\Facades\Mail;
use App\Model\PaymentGateway;


class ProfileController extends Controller
{
    public function view()
    {
         $payment_published_status = config('get_payment_publish_status') ?? 0;
        $payment_gateway_published_status = isset($payment_published_status[0]['is_published']) ? $payment_published_status[0]['is_published'] : 0;
         $payment_gatewayss = PaymentGateway::where('seller_id', auth('seller')->id())->get();
//dd($payment_gatewayss);
        $payment_gateways = Setting::whereIn('settings_type', ['payment_config'])->whereIn('key_name', Helpers::default_payment_gateways())->get();
        $razorPayGateway = $payment_gateways->where('key_name', 'razor_pay')->first();
        $payment_gateways = $payment_gateways->sortBy(function ($item) {
            return count($item['live_values']);
        })->values()->all();

        $routes = config('addon_admin_routes');
        $desiredName = 'payment_setup';
        $payment_url = '';

        foreach ($routes as $routeArray) {
            foreach ($routeArray as $route) {
                if ($route['name'] === $desiredName) {
                    $payment_url = $route['url'];
                    break 2;
                }
            }
          
        }

        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.view', compact('data','payment_gateways','payment_gatewayss', 'payment_gateway_published_status','payment_url','razorPayGateway'));
    }

    public function edit($id)
    {
        if (auth('seller')->id() != $id) {
            Toastr::warning(translate('you_can_not_change_others_profile'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();
        $shop_banner = Shop::select('banner')->where('seller_id', auth('seller')->id())->first()->banner;

        return view('seller-views.profile.edit', compact('data', 'shop_banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required'
        ], [
            'f_name.required' => 'First name is required!',
            'l_name.required' => 'Last name is required!',
            'phone.required' => 'Phone number is required!',
        ]);

        $seller = Seller::find(auth('seller')->id());
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        if ($request->image) {
            $seller->image = ImageManager::update('seller/', $seller->image, 'webp', $request->file('image'));
        }
        $seller->save();

        Toastr::info(translate('Profile_updated_successfully'));
        return back();
    }

    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);

        $seller = Seller::find(auth('seller')->id());
        $seller->password = bcrypt($request['password']);
        $seller->save();
        Toastr::success(translate('Seller_password_updated_successfully'));
        return back();
    }

    public function bank_update(Request $request, $id)
    {
        $bank = Seller::find(auth('seller')->id());
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->holder_name = $request->holder_name;
        $bank->account_no = $request->account_no;
        $bank->save();
        Toastr::success(translate('Bank_Info_updated'));
        return redirect()->route('seller.profile.view');
    }

    public function bank_edit($id)
    {
        if (auth('seller')->id() != $id) 
        {
            Toastr::warning(translate('you_can_not_change_others_info'));
            return back();
        }
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.bankEdit', compact('data'));
    }

    public function send_req_to_dlt_account(Request $request)
    {
        $request_dlt = Seller::find($request->seller_id);
        $request_dlt->reason_for_delete = $request->reason_for_delete;
        $request_dlt->save();

        $emailServices_smtp = Helpers::get_business_settings('mail_config');

        $mailMessage = new \App\Mail\RequestSellerDelete($request_dlt);

        $mailMessage->from($request_dlt->email, $request_dlt->f_name);

        Mail::to($emailServices_smtp['email_id'])->send($mailMessage);

        Toastr::info(translate('Your request has been submitted to the administrator for review. Once approved, your account will be automatically deactivated within the next 24 hours.'));
        return back();
    }
   
    public function refund_policy_edit(Request $request)
    {
        $id=auth('seller')->id();
        if (!$id) 
        {
            Toastr::warning(translate('you_can_not_change_others_info'));
            return back();
        }
        $seller = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.refundpolicyEdit', compact('seller'));
    }

    public function refund_policy_update(Request $request)
    {
        $Seller = Seller::find(auth('seller')->id());
        $Seller->refund_policy_text = $request->refund_policy_text;
        $Seller->save();
        Toastr::success(translate('Refund policy updated successfully'));
        return redirect()->route('seller.profile.refund_policy_edit');
    }



//   public function saveDetails(Request $request)
// {
//     $requestData = $request->all();

//     $keyName = 'raser_pay';

//     $sellerId = auth('seller')->id();

//     $paymentGateway = PaymentGateway::updateOrCreate(
//         ['key_name' => $keyName, 'seller_id' => $sellerId],
//         [
//            // 'is_active' => $requestData['status'],
//            // 'live_values' => $requestData['live_values'],
//            // 'additional_data' => $requestData['additional_data'],
//             'gateway_title' => $requestData['gateway_title'],
//             'gateway_image' => $requestData['gateway_image'],
//             'mode' => $requestData['mode'],
//             'seller_id' => $sellerId,
//             'api_secret' => $requestData['api_secret'],
//             'api_key' => $requestData['api_key'],
//         ]
        
//     );

//        $payment_published_status = config('get_payment_publish_status') ?? 0;
//         $payment_gateway_published_status = isset($payment_published_status[0]['is_published']) ? $payment_published_status[0]['is_published'] : 0;
//          $payment_gatewayss = PaymentGateway::where('seller_id', auth('seller')->id())->get();

//         $payment_gateways = Setting::whereIn('settings_type', ['payment_config'])->whereIn('key_name', Helpers::default_payment_gateways())->get();
//         $razorPayGateway = $payment_gateways->where('key_name', 'razor_pay')->first();
//         $payment_gateways = $payment_gateways->sortBy(function ($item) {
//             return count($item['live_values']);
//         })->values()->all();

//         $routes = config('addon_admin_routes');
//         $desiredName = 'payment_setup';
//         $payment_url = '';

//         foreach ($routes as $routeArray) {
//             foreach ($routeArray as $route) {
//                 if ($route['name'] === $desiredName) {
//                     $payment_url = $route['url'];
//                     break 2;
//                 }
//             }
          

//         }
       
//     $existingPaymentGateway = PaymentGateway::where(['key_name' => 'raser_pay', 'seller_id' => $sellerId])->first();
//      $data = Seller::where('id', auth('seller')->id())->first();
//    // return response()->json(['message' => 'Details saved successfully']);
//     return view('seller-views.profile.view', [
//         'existingPaymentGateway' => $existingPaymentGateway, 'data'=>$data,'razorPayGateway'=>$razorPayGateway,'payment_gatewayss'=>$payment_gatewayss,
//         'payment_gateway_published_status'=>$payment_gateway_published_status,
//     ]);
// }

}
