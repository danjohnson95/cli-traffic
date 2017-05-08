<?php namespace Danj\Traffic;

use Danj\Traffic\Data\DataSourceContract;
use Danj\Traffic\Helpers\TimeHelper;

class Output
{
    /**
     * The data source
     * @var \Danj\Traffic\Data\DataSourceContract
     */
    protected $data;

    /**
     * TimeHelper class
     * @var \Danj\Traffic\Helpers\TimeHelper
     */
    protected $time;

    /**
     * Makes a new instance of the Output class.
     * @param \Danj\Traffic\Data\DataSourceContract $data
     * @param \Danj\Traffic\Helpers\TimeHelper $time
     * @return mixed
     */
    public function __construct(
        DataSourceContract $data,
        TimeHelper $time
    ) {
        $this->data = $data;
        $this->time = $time;
    }

    /**
     * Returns the message to display to the user
     * @return string
     */
    public function getOutputMessage()
    {
        return  "| With current traffic..." .
                PHP_EOL .
                "--------------------------" .
                PHP_EOL .
                "| Your commute home will take " . $this->formatEstimatedTime() .
                PHP_EOL .
                "| Take the " . $this->data->getFastestRouteName() .
                PHP_EOL .
                "--------------------------" .
                PHP_EOL .
                "| " . $this->getTrafficDescription();
    }

    /**
     * Outputs the time the journey will take in a suitable unit
     * @return string
     */
    public function formatEstimatedTime()
    {
        return $this->time->niceTime(
            $this->data->getEstimatedTime()
        );
    }

    /**
     * Gets a user-friendly description of the traffic
     * @return string
     */
    public function getTrafficDescription()
    {
        $delay = $this->data->getDelayedTime();

        if ($delay <= 0) {
            return "There's no traffic on route!";
        } else {
            return "Delays of ~ ".$this->time->niceTime($delay);
        }
    }
}

