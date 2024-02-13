<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id'=>$this->id,
            'nombre'=>$this->nombre,
            'apellidos'=>$this->apellidos,
            'email'=>$this->email,
            'imagen'=>$this->imagen,
            'estado'=>$this->estado,
            'rol'=>$this->rol,
        ];
    }
}
