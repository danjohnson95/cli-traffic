<?php namespace Danj\Traffic\Tests;

use Danj\Traffic\Helpers\TimeHelper;
use PHPUnit_Framework_TestCase;

class TimeHelperTests extends PHPUnit_Framework_TestCase
{
    public function testSecondsToMinutesFunctionIsAccurate()
    {
        $one = TimeHelper::secToMin(60);
        $two = TimeHelper::secToMin(120);
        $three = TimeHelper::secToMin(180);

        $this->assertEquals(1, $one);
        $this->assertEquals(2, $two);
        $this->assertEquals(3, $three);
    }

    public function testSecondsToMinutesFunctionReturnsInteger()
    {
        $minute = TimeHelper::secToMin(90);

        $this->assertEquals(1, $minute);
    }

    public function testSecondsToHoursFunctionIsAccurate()
    {
        $one = TimeHelper::secToHour(3600);
        $two = TimeHelper::secToHour(7200);
        $three = TimeHelper::secToHour(10800);

        $this->assertEquals(1, $one);
        $this->assertEquals(2, $two);
        $this->assertEquals(3, $three);
    }

    public function testSecondsToHoursFunctionReturnsInteger()
    {
        $hour = TimeHelper::secToHour(4200);

        $this->assertEquals(1, $hour);
    }

    public function testSecondsToRemainingMinsFunctionIsAccurate()
    {
        $time = TimeHelper::secToRemainingMins(9500);

        $this->assertEquals(38, $time);
    }

    public function testNiceTimeCorrectlyOutputsTimeUnderOneHour()
    {
        $helper = new TimeHelper;
        $time = $helper->niceTime(2700);

        $this->assertEquals('45 mins', $time);
    }

    public function testNiceTimeCorrectlyOutputsTimeOverOneHour()
    {
        $helper = new TimeHelper;
        $time = $helper->niceTime(9900);

        $this->assertEquals('2 hours 45 mins', $time);
    }
}