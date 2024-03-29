<?php

namespace App\Http\Controllers\api\v3\seller\auth;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use App\Model\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|unique:sellers',
            'shop_address'  => 'required',
            'f_name'        => 'required',
            'l_name'        => 'required',
            'shop_name'     => 'required',
            'phone'         => 'required',
            'password'      => 'required|min:8',
            'image'         => 'required|mimes: jpg,jpeg,png,gif',
            'logo'          => 'required|mimes: jpg,jpeg,png,gif',
            'banner'        => 'required|mimes: jpg,jpeg,png,gif',
            'bottom_banner' => 'mimes: jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => Helpers::error_processor($validator)], 403);
        }

        DB::beginTransaction();
        try {
            $seller = new Seller();
            $seller->f_name = $request->f_name;
            $seller->l_name = $request->l_name;
            $seller->phone = $request->phone;
            $seller->email = $request->email;
            $seller->image = ImageManager::upload('seller/', 'webp', $request->file('image'));
            $seller->password = bcrypt($request->password);
            $seller->status =  $request->status == 'approved'?'approved': "pending";
            $seller->save();

            $shop = new Shop();
            $shop->seller_id = $seller->id;
            $shop->name = $request->shop_name;
            $shop->address = $request->shop_address;
            $shop->contact = $request->phone;
            $shop->image = ImageManager::upload('shop/', 'webp', $request->file('logo'));
            $shop->banner = ImageManager::upload('shop/banner/', 'webp', $request->file('banner'));
            $shop->bottom_banner = ImageManager::upload('shop/banner/', 'webp', $request->file('bottom_banner'));
            $shop->save();

            DB::table('seller_wallets')->insert([
                'seller_id' => $seller['id'],
                'withdrawn' => 0,
                'commission_given' => 0,
                'total_earning' => 0,
                'pending_withdraw' => 0,
                'delivery_charge_earned' => 0,
                'collected_cash' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $seller_id=$seller->id;

            DB::commit();

            if ($seller_id !== null) {
                $seller = Seller::where('id', $seller_id)->first();
                $emailServices_smtp = Helpers::get_business_settings('mail_config');
                
                $mailMessage = new SellerRegister($seller);
            
                $mailMessage->from($seller->email, $seller->f_name);
            
                $primaryRecipient = $emailServices_smtp['email_id'];
                Mail::to($primaryRecipient)->send($mailMessage);  
                return response()->json(['message' => translate('Shop apply successfully!')], 200);
            }

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => translate('Shop apply fail!')], 403);
        }
    }
}
