<?php
namespace App\Http\Controllers\api\v1;


use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use ResponseHelp;
use CodeHelp;
use App\Model\ModelMovie;

class MovieController extends Controller
{

    /**
         * @OA\Post(
         *     path="/api/v1/create-movie/",
         *     tags={"Movie"},
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *             mediaType="application/json",
         *             @OA\Schema(
         *                 type="object",
         *                 @OA\Property(
         *                     property="title",
         *                     description="Title",
         *                     example="hello world",
         *                     type="string"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     description="Description",
         *                     example="hello world",
         *                     type="string"
         *                 ),
         *                 @OA\Property(
         *                     property="rating",
         *                     description="Rating",
         *                     example=1.0,
         *                     type="double"
         *                 ),
         *                 @OA\Property(
         *                     property="image",
         *                     description="Image",
         *                     example="",
         *                     type="string"
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response="200", description="Success"),
         *     @OA\Response(response=401, description="Unauthenticated")
         * )
    */

    public function create(Request $request){
        $title = $request->input('title');
        $description = $request->input('description');
        $image = $request->input('image');
        $rating = $request->input('rating');

        $rules = [
            'title' => 'required',
            'description' => 'required',
            'rating' => 'required'
        ];
        $messages = [
            'title.required' => 'Please enter a Title.',
            'description.required' => 'Please enter a Description.',
            'rating.required' => 'Please enter a Rating.'
        ];

        // Run the validator
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return ResponseHelp::customJsonResponseValidation(CodeHelp::getCodeValidation(), $validator->messages(), 404);
        }

        $insert = \App\Model\ModelMovie::create([
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'rating' => $rating
        ]);

        if ($insert) {
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeOK(), "Movie successfully created", 200);
        } else {
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(), "Failed to create the movie", 500);
        }
    }


    /**
         * @OA\Patch(
         *     path="/api/v1/update-movie/",
         *     tags={"Movie"},
         *     @OA\RequestBody(
         *         @OA\MediaType(
         *             mediaType="application/json",
         *             @OA\Schema(
         *                 type="object",
         *                 @OA\Property(
         *                     property="id",
         *                     description="Id",
         *                     example=1,
         *                     type="int"
         *                 ),
         *                 @OA\Property(
         *                     property="title",
         *                     description="Title",
         *                     example="hello world",
         *                     type="string"
         *                 ),
         *                 @OA\Property(
         *                     property="description",
         *                     description="Description",
         *                     example="hello world",
         *                     type="string"
         *                 ),
         *                 @OA\Property(
         *                     property="rating",
         *                     description="Rating",
         *                     example=1.0,
         *                     type="double"
         *                 ),
         *                 @OA\Property(
         *                     property="image",
         *                     description="Image",
         *                     example="",
         *                     type="string"
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(response="200", description="Success"),
         *     @OA\Response(response=401, description="Unauthenticated")
         * )
    */
    public function update(Request $request){
        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $image = $request->input('image');
        $rating = $request->input('rating');

        $rules = [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'rating' => 'required'
        ];
        $messages = [
            'id.required' => 'Please enter a ID.',
            'title.required' => 'Please enter a Title.',
            'description.required' => 'Please enter a Description.',
            'rating.required' => 'Please enter a Rating.'
        ];


        $validator = Validator::make($request->all(), $rules,$messages);
        $data = \App\Model\ModelMovie::where('id',$id)->get();
        $mv = $data->first();

        if ($validator->passes()) {

            if(count($data) == 0) {
                return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeNotExists(), "movie not exists" ,404);
            }

            $update = \App\Model\ModelMovie::where('id',$id)->update(array(
                'title' => $title,
                'description' => $description,
                'image' => $image,
                'rating' => $rating
            ));
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeOK(), "Movie successfully updated" ,200);


        }
        else {
            return ResponseHelp::customJsonResponseValidation(CodeHelp::getCodeValidation(),$validator->messages(), 200);
        }

    }

    /**
     * * @OA\Delete(
     *     path="/api/v1/delete-movie/",
     *     tags={"Movie"},
     *     @OA\RequestBody(
        *         @OA\MediaType(
        *             mediaType="application/json",
        *             @OA\Schema(
        *                 type="object",
        *                 @OA\Property(
        *                     property="id",
        *                     description="ID",
        *                     example=1,
        *                     type="int"
        *                 )
        *             )
        *          )
        *     ),
        *     @OA\Response(response="200",description="Success"),
        *     @OA\Response(response=401,description="Unauthenticated")
        *   )

    */
    public function delete(Request $request){
        $id = $request->input('id');

        $data = \App\Model\ModelMovie::find($id);

        if ($data === null) {
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeNotExists(), "Movie not exists", 404);
        }

        // Delete the movie
        $delete = DB::table('tb_movie')->where('id', $id)->delete();

        // Check if the delete operation was successful
        if ($delete) {
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeOK(), "Delete successfully", 200);
        } else {
            // Handle the case where the deletion failed
            return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(), "Failed to delete the movie", 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/get-movie-id",
     *     tags={"Movie"},
     *     @OA\Parameter(
     *         description="ID",
     *         in="query",
     *         name="id",
     *         required=false,
     *         example=1,
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */

     public function show(Request $request)
     {
        $id = $request->input('id');

         try {
            $data = \App\Model\ModelMovie::find($id);
            if($data != null){
             return ResponseHelp::customJsonResponse(CodeHelp::getCodeOK(),"success get data!", $data);
            }else{
                return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(),"No result.", 404);
            }
         } catch (\Exception $e) {
             return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(),$e->get_message(), 500);
         }
     }


      /**
     * @OA\Get(
     *     path="/api/v1/get-all",
     *     tags={"Movie"},
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */

     public function getAll()
     {

         try {
            $data = \App\Model\ModelMovie::get();

            foreach($data as $row)
            {
                $res[] = [
                    'id' => $row->id,
                    'title' => $row->title,
                    'description' => $row->description,
                    'image' => $row->image,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,


                 ];
            }

            if(count($data) > 0){
             return ResponseHelp::customJsonResponse(CodeHelp::getCodeOK(),"success get data!", $res);
            }else{
                return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(),"No result.", 404);
            }
         } catch (\Exception $e) {
             return ResponseHelp::GlobalJsonResponse(CodeHelp::getCodeError(),$e->get_message(), 500);
         }
     }
}
?>
