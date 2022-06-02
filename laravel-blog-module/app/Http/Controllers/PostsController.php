<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\posts;
use Validator;

class PostsController extends Controller
{
    public function index(){
        $posts = posts::get();

        $response = null;
        $codigo_api = 404;

        if(isset($posts)){
            $response =[
                "result" => [
                    "error" => false,
                    "data" => [
                        'posts' => $posts
                    ]
                ]
            ];
            $codigo_api = 200;
        }else{
            $response =[
                "result" => [
                    "error" => true,
                    "message" => "No hay posts nuevos"
                ]
            ];
            $codigo_api = 401;
        }


        return response()->json($response, $codigo_api);
    }

    public function create_post(Request $request){
        $validation = Validator::make($request->all(), [
            'title' => 'required', 
            'author' => 'required',
            'content' => 'required',
        ]);

        if ($validation->fails()) {
            $codigo_api = 402;
            $response = [
                "result" => [
                    "error" => true,
                    "message" => "Faltan campos por llenar"
                ]
            ];
            
        }else{
            $post = new posts;
            $post->title = $request['title'];
            $post->author = $request['author'];
            $post->content = $request['content'];
            $post->save();
            $codigo_api = 200;
            $response = [
                "result" => [
                    "error" => false,
                    "message" => 'post creado exitosamente'
                ]
            ];
        }
        return response()->json($response, $codigo_api);
    }

    public function search_post(Request $request){
        $validation = Validator::make($request->all(), [ 
            "query" => "required"
            ]);

            if($validation->fails()){
                $api_code = 404;
                $response = [
                    "result" => [
                        "error" => true,
                        "message" => $validation->errors()
                    ]
                ];
            }else{
                    $posts = posts::where('title', 'LIKE', '%'.$request->get('query').'%')
                    ->orWhere('author', 'LIKE', '%'.$request->get('query').'%')
                    ->orWhere('content', 'LIKE', '%'.$request->get('query').'%')
                    ->get();
                    $response =[
                        "result" => [
                            "error" => false,
                            "data" => [
                                'posts' => $posts
                            ]
                        ]
                    ];
                    $api_code = 200;
            }
            return response()->json($response,$api_code);
    }
}
