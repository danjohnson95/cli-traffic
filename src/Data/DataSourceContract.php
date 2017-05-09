<?php namespace Danj\Traffic\Data;

use Danj\Traffic\Config;

interface DataSourceContract
{
    /**
     * Makes a new instance of the Data Source, injecting the configuration
     * which contains origin and destination information.
     * @param \Danj\Traffic\Config $config
     * @return void
     */
    public function __construct(Config $config);

    /**
     * Returns the estimated time for the journey including traffic in seconds
     * @return int
     */
    public function getEstimatedTime();

    /**
     * Returns how much the journey will be delayed by in seconds
     * @return int
     */
    public function getDelayedTime();

    /**
     * Returns the percentage of the delay
     * @return float
     */
    public function getPercentageOfDelay();

    /**
     * Returns the name of the fastest route to take, eg. which motorway to take
     * @return string
     */
    public function getFastestRouteName();
}
