<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\SurveyQuestion;
use App\Models\Surveys;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $surveys = Surveys::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return SurveyResource::collection($surveys);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurveyRequest $request)
    {
        $data = $request->validated();

        // image storage
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);
        //     $data['image'] = $imageName;
        // }


        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $survey = Surveys::create($data);

        // Create a new questions
        foreach ($data['questions'] as $question) {
            $question['survey_id'] = $survey->id;
            $this->createQuestion($question);
        }

        return new SurveyResource($survey);
    }

    /**
     * Display the specified resource.
     */
    public function show(Surveys $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surveys $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurveyRequest $request, Surveys $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surveys $survey)
    {
        //
    }
}


/**
 * Create a question and return
 *
 * @param $data
 * @return mixed
 * @throws \Illuminate\Validation\ValidationException
 * @author Firstname Lastname <bM7o4@example.com>
 */
function saveImage($image)
{
    // Chick if image is valid base64 string
    if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
        // Take out the base64 encoded text without mime information type
        $image = substr($image, strpos($image, ',') + 1);
        // Get file extension
        $type = strtolower($type[1]); // jpg, png, gif
        // Check if file is an image
        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            throw new \Exception('invalid image type');
        }
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);
        if ($image === false) {
            throw new \Exception('base64_decode failed');
        }
    } else {
        throw new \Exception('did not match data URI with image data');
    }

    $dir = 'images/';
    $file = Str::random(20) . '.' . $type;
    $absolutePath = public_path($dir);
    $relativePath = $dir . $file;
    if (!File::exists($absolutePath)) {
        File::makeDirectory($absolutePath, 0755, true);
    }

    // Save the image
    file($relativePath, $image);

    return $relativePath;
}

/**
 * Create a question and return
 *
 * @param $data
 * @return mixed
 * @throws \Illuminate\Validation\ValidationException
 * @author Firstname Lastname <bM7o4@example.com>
 */
function createQuestion($data)
{
    if (is_array($data['data'])) {
        $data['data'] = json_encode($data['data']);
    }

    $validator = Validator::make($data, [
        'survey_id' => 'exists:App\Models\Surveys,id',
        'type' => [
            'required',
            new Enum(QuestionTypeEnum::class)
        ],
        'question' => 'required | string',
        'data' => 'required',
        'description' => 'nullable | string',
    ]);
}
