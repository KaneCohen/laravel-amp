<?php
namespace Cohensive\Amp;

use Illuminate\Contracts\View\View;
use Illuminate\Config\Repository;

class AmpMatchComposer
{
    private Amp $amp;

    private Repository $config;

    public function __construct(Amp $amp, Repository $config)
    {
        $this->amp = $amp;
        $this->config = $config;
    }

    public function compose(View $view)
    {
        if ($this->amp->isAmp()) {
            $url = $this->amp->url();
            if ($url) {
                $view->with($this->config->get('amp.url'), $url);
            }
            $view->with($this->config->get('amp.view_bool_name'), !!$url);
        }

        $view->with($this->config->get('amp.url'), null);
        $view->with($this->config->get('amp.view_bool_name'), false);
    }
}
