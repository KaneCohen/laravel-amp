<?php
namespace Cohensive\Amp;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;
use Illuminate\Contracts\View\View;

class AmpMatchComposer
{
    private Router $router;

    private UrlGenerator $urlGenerator;

    public function __construct(Router $router, UrlGenerator $urlGenerator)
    {
        $this->router = $router;
        $this->urlGenerator = $urlGenerator;
    }

    public function compose(View $view)
    {
        $currentRoute = $this->router->getCurrentRoute();

        if (!$currentRoute) {
            $view->with('hasAmpUrl', false);
            return;
        }

        $routeName = $currentRoute->getName();
        $matches = preg_match('/\.amp$/', $routeName);

        if ($matches === 0) {
            $action = $currentRoute->getAction();

            if (isset($action['amp'])) {
                $uri = $this->urlGenerator->route($action['amp'], $currentRoute->parameters());

                $view->with('ampUrl', $uri);
            }
        }

        $view->with('hasAmpUrl', isset($uri));
    }
}
