<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
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
            'approver' => [
                'id' => $this->approver->id,
                'name' => $this->approver->name
            ],
            'status' => [
                'id' => $this->status->id,
                'name' => $this->status->name
            ]
        ];
    }
}
