<?php
class PathControl extends Nette\Application\Control
{
    public function render($title)
    {
        $this->template->title = $title;
        $this->template->setFile(dirname(__FILE__) . '/path.phtml');
        $this->template->render();
    }
}
