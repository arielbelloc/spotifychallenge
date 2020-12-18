<?php 
namespace App\Entities;

class ArtistEntity
{
    /**
     * @var string
     */
    private $id;

    public function getId() : string
    {
        return $this->id;
    }
}