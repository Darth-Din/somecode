<?php

class Tag{
    public $name;
    protected $attributes;

    public function __construct($name) {
        $this->name = $name;
        $this->attributes = [];
    }

    public function attr($name, $value = ''){
        $this->attributes[$name] = $value;
        return $this;
    }

    public function render(){
        $attributes = $this->renderAttributes();
        return '<'.$this->name.$attributes.'>';
    }

    public function renderAttributes(){
        $attributes = '';
        if (count($this->attributes)) {
            foreach ($this->attributes as $k => $v) {
                $attributes .= ' '.$k.'="' . $v.'"';
            }
        }
        return $attributes;
    }
}

class SingleTag extends Tag{

}

class PairTag extends Tag{
    protected $childs;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->childs = [];
    }

    public function appendChild(Tag $tag){
        $this->childs[] = $tag;
        return $this;
    }

    public function renderChilds(){
        $childs = '';
        if (count($this->childs)){
            foreach ($this->childs as $child) {
                $childs .= $child->render();
            }
        }
        return $childs;
    }

    public function render(){
        $childs = $this->renderChilds();
        $attributes = $this->renderAttributes();
        return '<'.$this->name.$attributes.'>'.$childs.'</'.$this->name.'>';
    }
}

$img = (new SingleTag('img'))
    ->attr('href', './nz')
    ->attr('alt', 'nz');

$hr = new SingleTag('hr');

print (new PairTag('a'))
    ->attr('href', './nz')
    ->appendChild($img)
    ->appendChild($hr)
    ->render();

function forTest() : PairTag {
    $label1 = (new PairTag('label'))
        ->appendChild((new SingleTag('img'))
        ->attr('src', 'f1.jpg')
        ->attr('alt', 'f1 not found')
        )
        ->appendChild((new SingleTag('input'))
        ->attr('type', 'text')
        ->attr('name', 'f1')
        );

    $label2 = (new PairTag('label'))
        ->appendChild((new SingleTag('img'))
            ->attr('src', 'f2.jpg')
            ->attr('alt', 'f2 not found')
        )
        ->appendChild((new SingleTag('input'))
            ->attr('type', 'password')
            ->attr('name', 'f2')
        );

      $input = (new SingleTag('input'))
          ->attr('type', 'submit')
          ->attr('value', 'Send');

      return (new PairTag('form'))
          ->appendChild ($label1)
          ->appendChild ($label2)
          ->appendChild ($input);
}

