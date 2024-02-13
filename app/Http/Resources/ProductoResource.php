<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'imagen' => $this->imagen,
            'categoria' => [
                'id' => $this->categoria->id,
                'nombre' => $this->categoria->nombre,
                'descripcion' => $this->categoria->descripcion,
                // Otros campos de la categoría que desees incluir
            ],
            // 'categoria'=> $this->categoria
        ];
    }
}
