<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'slug' => $this->slug,
            'description' => $this->description,
            'questions' => SurveyQuestionResource::collection($this->questions),
            'expire_date' => $this->expire_date
        ];
    }
}
