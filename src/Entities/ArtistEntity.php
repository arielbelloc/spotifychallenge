<?php 
namespace App\Entities;

class ArtistEntity
{
    /**
     * @var string
     */
    private $id;

    public function __construct(array $data)
    {
        $this->mapFields($data);
    }

    private function mapFields(array $data)
    {
        $this->id = $data['id'];
    }

    public function getId() : string
    {
        return $this->id;
    }
}