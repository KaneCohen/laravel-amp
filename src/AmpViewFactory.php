<?php
namespace Cohensive\Amp;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory as FactoryContract;
use Illuminate\Contracts\View\View;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\ViewFinderInterface;

class AmpViewFactory extends Factory implements FactoryContract
{
    protected string $ampAffix;

    protected string $ampBoolName;

    protected bool $ampFallback;

    /**
     * AmpViewFactory constructor.
     */
    public function __construct(
        EngineResolver $engines,
        ViewFinderInterface $finder,
        Dispatcher $events,
        string $ampAffix,
        string $ampBoolName,
        bool $ampFallback
    ) {
        $this->ampAffix = $ampAffix;
        $this->ampBoolName = $ampBoolName;
        $this->ampFallback = $ampFallback;

        parent::__construct($engines, $finder, $events);
    }

    /**
     * @param string $view
     * @param array  $data
     * @param array  $mergeData
     */
    public function make($view, $data = [], $mergeData = []): View
    {
        $routeName = $this->getContainer()->make('router')->currentRouteName();

        if (preg_match('/\.amp$/', $routeName)) {
            if (isset($this->ampAffix)) {
                if (!$this->ampFallback) {
                    $view .= $this->ampAffix;
                } elseif ($this->ampFallback && $this->exists($view . $this->ampAffix)) {
                    $view .= $this->ampAffix;
                }
            }

            if (isset($this->ampBoolName)) {
                $data[$this->ampBoolName] = true;
            }
        }

        return parent::make($view, $data, $mergeData);
    }
}
