<?php

namespace gm_build;

class build_carousel
{
    protected $carousel;

    public function __construct(array $text_array, array $attributes)
    {
        $this->carousel = $this->build_carousel($text_array, $attributes);
    }

    protected function build_carousel( array $text_array, array $attributes )
    {
        $first_item = isset($text_array[0]) ? $text_array[0] : '';

        if ( ! empty($attributes) )
        {
            $height = $attributes['height'] . 'px';
            $width  = $attributes['width'] . 'px';

            $html  = "<div class='gm_carousel_wrapper' style='height:$height; width: $width;'>";
        } else {
            $html  = '<div class="gm_carousel_wrapper">';
        }

        $html .= "<div class='gm_carousel_card'><div class='gm_card_content'>$first_item</div></div>";

        $html .= $this->build_dot_nav($text_array);

        $html .= '<ul class="gm_carousel">';

        foreach ($text_array as $key=> $li )
        {
            $html .= "<li>$li</li>";
        }

        $html .= '</ul>';

        $html .= '</div>'; // close wrapper

        return $html;
    }

    protected function build_dot_nav( array $text_array)
    {
        $count = count( $text_array );

        $button_html = "<div class='gm_carousel_nav'>";

        for ($c = 0 ; $c < $count ; ++$c)
        {
            $class = $c === 0 ? 'gm_dot gm_active' : 'gm_dot gm_inactive';
            $id = "gm_dot_$c";
            $button_html .= "<span id='$id' class='$class'><i class='fa fa-circle' aria-hidden='true'></i></span>";
        }

        $button_html .= '</div>';

        return $button_html;
    }

    public function return_ul_html()
    {
        return $this->carousel;
    }
}

