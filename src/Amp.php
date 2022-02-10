<?php
namespace Cohensive\Amp;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\Router;

class Amp
{
    private Router $router;

    private UrlGenerator $urlGenerator;

    public function __construct(Router $router, UrlGenerator $urlGenerator)
    {
        $this->router = $router;
        $this->urlGenerator = $urlGenerator;
    }

    public function isAmp(): bool
    {
        $currentRoute = $this->router->getCurrentRoute();

        if (!$currentRoute) {
            return false;
        }

        $matches = preg_match('/\.amp$/', $currentRoute->getName());

        return $matches === 1;
    }

    public function url(): ?string
    {
        $currentRoute = $this->router->getCurrentRoute();

        if (!$currentRoute) {
            return null;
        }

        if ($this->isAmp()) {
            $action = $currentRoute->getAction();

            if (isset($action['amp'])) {
                return $this->urlGenerator->route($action['amp'], $currentRoute->parameters());
            }
        }

        return null;
    }
}
