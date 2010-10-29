<?php
/** @entity */
class Blogpost extends Nette\Object
{
    /**
     * @id @column(type="integer")
     * @generatedValue
     */
    private $id = 0;

    /** @column(length=100) */
    private $title;

    /** @column(type="text", nullable=true) */
    private $post;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setPost($post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getData()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'post' => $this->post,
        );
    }
}
