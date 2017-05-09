<?php namespace Danj\Traffic\Traits;

trait MakeAPIRequests
{
    /**
     * Makes a GET request on the specified URL, passing through any parameters
     * specified.
     * @param string $url
     * @param array $params
     * @return object
     */
    public function getJSON($url, $params = [])
    {
        if (!empty($params)) {
            $url .= "?".http_build_query($params);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode(
            $output
        );
    }
}
