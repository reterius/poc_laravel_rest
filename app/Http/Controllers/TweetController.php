<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tweet;
use Validator;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\Console\Output\ConsoleOutput ;
use Illuminate\Support\Facades\Input;
use App\User;


class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_user = Auth::user(); 
        $response_object = [
            "error_code" => null,
            "error_message" => null,
            "success_message" => null,
            "data" => new \stdClass()
        ] ;
        
        $per_page = 5; // Her sayfada kaç kayıt bulunacak
        $each_side = 3; // 3 buttons on each side

        if (Input::has('user_id')) {

            $user_id = Input::get('user_id') ;
            $validator = Validator::make(['user_id' => $user_id], [
                'user_id' => 'integer'
            ]);
    
            if($validator->fails()){
                $response_object["error_code"] = 'validation_error' ;
                $response_object["error_message"] = $validator->errors() ;
                return response()->json($response_object, 422);
            }

            # Böyle bir kullanıcı yok
            $tweet = User::find($user_id);
            if($tweet == null){
                $response_object["error_code"] = 'not_found_error' ;
                $response_object["error_message"] = 'Not Found Error' ;
                return response()->json($response_object, 404);
            }


            $pagination = Tweet::where('user_id', $user_id)
            ->orderBy("writed_at", 'DESC')
            ->jsonPaginate($per_page, $each_side) ;
        }else{
            $pagination = Tweet::orderBy("writed_at", 'DESC')
            ->jsonPaginate($per_page, $each_side);
        }

        $response_object['data']->items = $pagination['data'];
        $response_object['data']->paginator = $pagination['paginator'];

        return response()->json($response_object, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response_object = [
            "error_code" => null,
            "error_message" => null,
            "success_message" => null,
            "data" => new \stdClass()
        ] ;

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);
    
        if($validator->fails()){
            $response_object["error_code"] = 'validation_error' ;
            $response_object["error_message"] = $validator->errors() ;
            return response()->json($response_object, 422);
        }

        $tweet = Tweet::find($id);

        if($tweet == null){
            $response_object["error_code"] = 'not_found_error' ;
            $response_object["error_message"] = 'Not Found Error' ;
            return response()->json($response_object, 404);
        }
        
        $response_object['data'] = $tweet ;
        $response_object['success_message'] = "Tweet detail displayed successfully";
        return response()->json($response_object, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $out = new ConsoleOutput();
        $current_user = Auth::user(); 

        $response_object = [
            "error_code" => null,
            "error_message" => null,
            "success_message" => null,
            "data" => new \stdClass()
        ] ;

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);

        if($validator->fails()){
            $response_object["error_code"] = 'validation_error' ;
            $response_object["error_message"] = $validator->errors() ;
            return response()->json($response_object, 422);
        }

        $request_only = ['tweet_content', 'tweet_status'] ;

        $validator = Validator::make($request->only($request_only), [
            'tweet_content' => 'string',
            'tweet_status' => 'in:0,1'
        ]);

        if($validator->fails()){
            $response_object["error_code"] = 'validation_error' ;
            $response_object["error_message"] = $validator->errors() ;
            return response()->json($response_object, 422);
        }

        # kayıt bulunamadı
        $tweet = Tweet::find($id);
        if($tweet == null){
            $response_object["error_code"] = 'not_found_error' ;
            $response_object["error_message"] = 'Not Found Error' ;
            return response()->json($response_object, 404);
        }

        # Editlenen kayıt kişiye ait değilse hata dön
        if($current_user->id != $tweet->user_id){
            $response_object["error_code"] = 'permission_denied_error' ;
            $response_object["error_message"] = 'Permission Denied Error' ;
            return response()->json($response_object, 401);
        }

        $tweet ->fill($request->only($request_only));

        try{
            $tweet->save();
        }
        catch (ErrorException $e){
            $response_object["error_code"] = 'internal_server_error' ;
            $response_object["error_message"] = 'Internal Server Error' ;
            return response()->json($response_object, 500);
        }

        $response_object['data'] = $tweet ;
        $response_object['success_message'] = "Tweet edited successfully";
        return response()->json($response_object, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $current_user = Auth::user(); 

        $response_object = [
            "error_code" => null,
            "error_message" => null,
            "success_message" => null,
            "data" => new \stdClass()
        ] ;

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer'
        ]);

        if($validator->fails()){
            $response_object["error_code"] = 'validation_error' ;
            $response_object["error_message"] = $validator->errors() ;
            return response()->json($response_object, 422);
        }

        # kayıt bulunamadı
        $tweet = Tweet::find($id);
        if($tweet == null){
            $response_object["error_code"] = 'not_found_error' ;
            $response_object["error_message"] = 'Not Found Error' ;
            return response()->json($response_object, 404);
        }

        # Silinen kayıt kişiye ait değilse hata dön
        if($current_user->id != $tweet->user_id){
            $response_object["error_code"] = 'permission_denied_error' ;
            $response_object["error_message"] = 'Permission Denied Error' ;
            return response()->json($response_object, 401);
        }

        try{
            $tweet->delete();
        }
        catch (ErrorException $e){
            $response_object["error_code"] = 'internal_server_error' ;
            $response_object["error_message"] = 'Internal Server Error' ;
            return response()->json($response_object, 500);
        }

        $response_object['success_message'] = "Tweet deleted successfully";
        return response()->json($response_object, 200);

    }

    

}
