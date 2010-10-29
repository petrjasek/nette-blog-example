<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */

/**
 * Homepage presenter.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class HomepagePresenter extends BasePresenter
{
    private $post = NULL;

	public function renderDefault()
	{
        global $em;
        $this->template->posts = $em->getRepository('Blogpost')->findAll();
		$this->template->anyVariable = 'any value';
	}

    public function actionDetail($id)
    {
        global $em;

        $this->post = $em->find('Blogpost', $id);
        if ($this->post == NULL) {
            $this->flashMessage('Blogpost not found', 'error');
            $this->redirect('default');
        }
    }

    public function actionEdit($id)
    {
        global $em;
        if (!empty($id)) {
            $this->post = $em->find('Blogpost', $id);
            if ($this->post == NULL) {
                $this->flashMessage('Blogpost not found', 'error');
                $this->redirect('default');
            }
        } else {
            $this->post = new Blogpost;
            $em->persist($this->post);
        }
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->template->post = $this->post;
    }

    public function renderEdit()
    {
        if ($this->post->id > 0) {
            $this['editForm']->setDefaults($this->post->getData());
        }
    }

    public function createComponentEditForm()
    {
        $form = new Nette\Application\AppForm();

        $form->addText('title', 'Title')
            ->addRule(':filled', 'Edit title');

        $form->addTextarea('post', 'Post');

        $form->addSubmit('save', 'Save');
        $form->onSubmit[] = array($this, 'handleEditForm');

        return $form;
    }

    public function handleEditForm(Nette\Application\AppForm $form)
    {
        global $em;

        $values = $form->values;

        $this->post->setTitle($values['title']);
        $this->post->setPost($values['post']);
        $em->flush();

        $this->flashMessage('Post saved');
        $this->redirect('default');
    }

    public function handleDelete($id)
    {
        global $em;

        $post = $em->find('Blogpost', $id);
        $em->remove($post);
        $em->flush();

        $this->flashMessage('Post #' . $id . ' was deleted');
        $this->redirect('default');
    }
}
