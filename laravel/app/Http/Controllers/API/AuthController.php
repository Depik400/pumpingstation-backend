<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidentsController;
use App\Models\PriceOfStation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use  Illuminate\Contracts\Auth\Factory;

class AuthController extends Controller
{

    /**
     * @throws \Exception
     */

    private function testData(string $name, string $email)
    {
        $user = DB::table('users')->where('email', $email)->get('id');
        $name = DB::table('users')->where('name', $name)->get('id');
        if (count($user) > 0) {
            return 'email';
        }
        if (count($name) > 0) {
            return 'name';
        }
        return true;
    }

    public function register()
    {
        $name = request('name');
        $email = request('email');
        $nameOfOrg = \request('name_of_org');
        $password = bcrypt(request('password'));
        if (is_string($result = $this->testData($name, $email))) {
            return response()->json(['status' => 202, 'error' => $result]);
        };
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'name_of_org' => $nameOfOrg,
            'password' => $password
        ]);

        PriceOfStation::create([
            'pumping_id' => $user->id,
            'price_pairs' => json_encode([
                ['month'=>0, 'price' => 0],
                ['month'=>1, 'price' => 0],
                ['month'=>2, 'price' => 0],
                ['month'=>3, 'price' => 0],
                ['month'=>4, 'price' => 0],
                ['month'=>5, 'price' => 0],
                ['month'=>6, 'price' => 0],
                ['month'=>7, 'price' => 0],
                ['month'=>8, 'price' => 0],
                ['month'=>9, 'price' => 0],
                ['month'=>10 , 'price'=> 0],
                ['month'=>11, 'price' => 0]
            ])
        ]);

        $accessToken = $user->createToken(request('name'))->accessToken;
        return response()->json(['status' => 201, 'token' => 'Bearer ' . $accessToken, 'name' => $name, 'org_name' => $nameOfOrg]);
    }

    public function checkToken(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        $status = 0;
        $name = '';
        $orgName = '';
        if ($user->id != -1) {
            $status = 201;
            $name = $user->name;
            $orgName = $user->name_of_org;
        }
        return response()->json(['status' => $status, 'name' => $name, 'orgName' => $orgName]);
    }

    public function login(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if ($request->get('name') == null || $request->get('password') == null) {
            return response()->json(['status' => 500]);
        }
        $data = [
            'name' => $request->get('name'),
            'password' => $request->get('password')
        ];
        if (!auth()->attempt($data)) {
            return response()->json(['message' => 'incorrect login or password']);
        }
        return response()->json(['token' => 'Bearer ' . auth()->user()->createToken($request->get('name'))->accessToken,
            'name' => $request->get('name'),
            'org_name' => auth()->user()->name_of_org]);
    }

    public function logout(Request $req): JsonResponse
    {

        $user = auth('api')->user();
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->update(['revoked' => true]);
        return response()->json(['status' => 'revoked']);
    }
}
