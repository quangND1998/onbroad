<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiShopifyTrait;
use App\Traits\CheckHmacTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Shopify\Utils;
use Shopify\Context;
class InstalllAppController extends Controller
{
    use CheckHmacTrait, ApiShopifyTrait;
    private $api_scopes, $api_key, $api_secret;
    public function __construct()
    {
        $this->api_secret = config('shopify.shopify_api_secret');
        $this->api_key = config('shopify.shopify_api_key');

        $this->api_scopes = implode(',', config('shopify.api_scopes'));
    }
    /**
     * @param Request $request
     * @return  Redirect to uri
     */

    public function startInstallApp(Request $request)
    {

        try {
            $validRequest = $this->validateRequestShopify($request->all());

            if ($validRequest) {
                $shop = $request->has('shop');
             
                if ($shop) {
                    $user = $this->getUserStore($request->shop);
                    //  Check have user
                    
                    if ($user) {
                        // Check  access token 
                        $validAccessToken = $this->checkIfAccessTokenIsValid($user);
                        $is_embedded = determineIfAppIsEmbedded();
                        
                        if ($validAccessToken) {
                            return redirect()->route('home', $request->all());

                        } else {
                            $endpoint = 'https://' . $request->shop .
                                '/admin/oauth/authorize?client_id=' . $this->api_key .
                                '&scope=' . $this->api_scopes .
                                '&redirect_uri=' . route('app_install_redirect');
                            return Redirect::to($endpoint);
                        }
                    } else {
                        //  redirect to authenticate endpoint
                        // https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}

                        $endpoint = 'https://' . $request->shop .
                            '/admin/oauth/authorize?client_id=' . $this->api_key .
                            '&scope=' . $this->api_scopes .
                            '&redirect_uri=' . route('app_install_redirect');


                        return Redirect::to($endpoint);
                    }
                } else throw new Exception('Shop parameter not present in the request');
            } else throw new Exception('Request is not valid!');
        } catch (Exception $e) {
            Log::info($e->getMessage() . ' ' . $e->getLine());
        }
    }


    public function handleRedirect(Request $request)
    {

        try {
            $validRequest = $this->validateRequestShopify($request->all());
          
            if ($validRequest) {
                if ($request->has('shop') && $request->has('code')) {
                    $shop = $request->shop;
                    $code = $request->code;
                    $accessToken = $this->getAccessTokenShopify($shop, $code);
                  
                    if ($accessToken !== false && $accessToken !== null) {
                        $shopDetails = $this->getShopDetailsFromShopify($shop, $accessToken);
                   
                        $user = $this->saveStoreDetailsToDatabase($shopDetails, $accessToken);
                     
                        if ($user) {
                            
                            return redirect()->route('home', $request->all());
                        }
                    } else throw new Exception('Invalid Access Token ' . $accessToken);
                } else throw new Exception('Code / Shop param not present in the URL');
            } else throw new Exception('Request is not valid!');
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getAccessTokenShopify($shop, $code)
    {
        try {
            $endpoint = 'https://' . $shop . '/admin/oauth/access_token';

            // $headers = ['Content-Type: application/json'];

            // $requestBody = json_encode([
            //     'code' => $code,
            //     'client_id' => $this->api_key,
            //     'client_secret' => $this->api_secret
            // ]);

            $response = Http::accept('application/json')->post($endpoint, [
                'code' => $code,
                'client_id' => $this->api_key,
                'client_secret' => $this->api_secret
            ]);
            // $response = $this->callApiShopify('POST',$endpoint, $headers, $requestBody);

            if ($response->ok()) {
                $data = $response->json();
                return $data['access_token'];
            }

            return false;
        } catch (Exception $e) {
            throw $e;
        }
    }




    private function checkIfAccessTokenIsValid($storeDetails)
    {
        try {
            if ($storeDetails !== null && isset($storeDetails->access_token) && strlen($storeDetails->access_token) > 0) {
                $token = $storeDetails->access_token;
                $endpoint = getShopifyURLForStore('shop.json', $storeDetails);

                $headers = getShopifyHeadersForStore($storeDetails);
                $response = $this->callApiShopify('GET', $endpoint, $headers, null);
                return $response['statusCode'] === 200;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }


    public function saveStoreDetailsToDatabase($shopDetails, $accessToken)
    {
        try {


            $payload = [
                'name' => 'firstshopyfi',
                'access_token' => $accessToken,
                'store_name' => $shopDetails['myshopify_domain'],
                'email' => $shopDetails['email'],
                'phone' => $shopDetails['phone'],

            ];
            $store_db = User::updateOrCreate(['store_name' => $shopDetails['myshopify_domain']], $payload);

            return $store_db;
        } catch (Exception $e) {
            Log::info($e->getMessage() . ' ' . $e->getLine());
            return false;
        }
    }

    private function getShopDetailsFromShopify($shop, $accessToken)
    {
        try {
            $endpoint = getShopifyURLForStore('shop.json', ['store_name' => $shop]);
        
            $headers = getShopifyHeadersForStore(['access_token' => $accessToken]);
            $response = $this->callApiShopify('GET', $endpoint,  $headers);
           
            if ($response['statusCode'] == 200) {
                $body = $response['body'];
                Log::info($body);
                if (!is_array($body)) $body = json_decode($body, true);
                return $body['shop'] ?? null;
            } else {
                Log::info('Response recieved for shop details');
                Log::info($response);
                return null;
            }
        } catch (Exception $e) {
            Log::info('Problem getting the shop details from shopify');
            Log::info($e->getMessage() . ' ' . $e->getLine());
            return null;
        }
    }
}
