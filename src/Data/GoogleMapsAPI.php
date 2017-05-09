<?php namespace Danj\Traffic\Data;

use Danj\Traffic\Config;
use Danj\Traffic\Traits\MakeAPIRequests;

class GoogleMapsAPI implements DataSourceContract
{
    use MakeAPIRequests;

    /**
     * The base URL to use for the API request
     * @var string
     */
    protected $base = "https://maps.googleapis.com/maps/api/directions/json";

    /**
     * Stores the data retrieved from the API call
     * @var object
     */
    protected $data;

    /**
     * Stores the fastest route for the journey
     * @var object
     */
    protected $fastest_route;

    /**
     * Makes a new instance of the Data Source, injecting the configuration
     * which contains origin and destination information.
     * @param \Danj\Traffic\Config $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->data = $this->getJSON($this->base, [
            'origin' => $config->getOriginPostcode(),
            'destination' => $config->getDestinationPostcode(),
            'departure_time' => 'now',
            'key' => $config->getAPIKey()
        ]);

        $this->fastest_route = $this->getFastestRoute();
    }

    /**
     * Iterates through the routes and returns the fastest one.
     * @return object
     */
    protected function getFastestRoute()
    {
        $sort = [];
        foreach ($this->data->routes as $route) {
            $sort[$route->legs[0]->duration_in_traffic->value] = $route;
        }
        asort($sort);
        return reset($sort);
    }

    /**
     * Returns the estimated time for the journey including traffic in seconds
     * @return int
     */
    public function getEstimatedTime()
    {
        return $this->fastest_route->legs[0]->duration_in_traffic->value;
    }

    /**
     * Gets the time the journey would take on an average day, in seconds
     * @return int
     */
    public function getUsualTime()
    {
        return $this->fastest_route->legs[0]->duration->value;
    }

    /**
     * Returns how much the journey will be delayed by in seconds
     * @return int
     */
    public function getDelayedTime()
    {
        return $this->getEstimatedTime() - $this->getUsualTime();
    }

    /**
     * Returns the percentage of the delay
     * @return float
     */
    public function getPercentageOfDelay()
    {
        return ($this->getUsualTime() / $this->getEstimatedTime()) * 100;
    }

    /**
     * Returns the name of the fastest route to take, eg. which motorway to take
     * @return string
     */
    public function getFastestRouteName()
    {
        return $this->fastest_route->summary;
    }
}
