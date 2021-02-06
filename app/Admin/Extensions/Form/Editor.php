<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class Editor extends Field
{
  public static $css = [
    '/packages/summernote/summernote-bs4.min.css',
  ];

  public static $js = [
    '/packages/summernote/summernote-bs4.min.js',
  ];

  protected $view = 'admin.editor';

  public function render()
  {
    $this->script = "$('#{$this->getElementClassString()}').summernote()";

    return parent::render();
  }
}
