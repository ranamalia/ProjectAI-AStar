<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Edge extends Model
{
    protected $fillable = [
        'from_node_id',
        'to_node_id',
        'distance',
        'road_type',
        'weight'
    ];

    protected function casts(): array
    {
        return [
            'distance' => 'float',
            'weight' => 'float'
        ];
    }

    // Road type constants with their weights
    const ROAD_TYPES = [
        'highway' => ['name' => 'Jalan Tol', 'weight' => 0.5],
        'primary' => ['name' => 'Jalan Raya', 'weight' => 0.7],
        'secondary' => ['name' => 'Jalan Kecil', 'weight' => 1.0],
        'residential' => ['name' => 'Gang/Perumahan', 'weight' => 1.5],
    ];

    public function fromNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'from_node_id');
    }

    public function toNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'to_node_id');
    }

    public function getWeightedDistance(): float
    {
        return $this->distance * $this->weight;
    }

    public function getRoadTypeName(): string
    {
        return self::ROAD_TYPES[$this->road_type]['name'] ?? 'Unknown';
    }
}
