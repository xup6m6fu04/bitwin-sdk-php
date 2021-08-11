<?php

namespace Xup6m6fu04\Bitwin\HTTPClient;

/**
 * cURL session manager
 *
 * @package Xup6m6fu04\Bitwin\HTTPClient
 */
class Curl
{
    /** @var resource */
    private $ch;

    /**
     * Initialize a cURL session
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->ch = curl_init($url);
    }

    /**
     * Set multiple options for a cURL transfer
     *
     * @param array $options Returns TRUE if all options were successfully set. If an option could not be
     * successfully set, FALSE is immediately returned, ignoring any future options in the options array.
     * @return bool
     */
    public function setoptArray(array $options): bool
    {
        return curl_setopt_array($this->ch, $options);
    }

    /**
     * Perform a cURL session
     *
     * @return bool|string Returns TRUE on success or FALSE on failure. However, if the CURLOPT_RETURNTRANSFER
     * option is set, it will return the result on success, FALSE on failure.
     */
    public function exec()
    {
        return curl_exec($this->ch);
    }

    /**
     * Gets information about the last transfer.
     *
     * @return array
     */
    public function getinfo(): array
    {
        return curl_getinfo($this->ch);
    }

    /**
     * @return int Returns the error number or 0 (zero) if no error occurred.
     */
    public function errno(): int
    {
        return curl_errno($this->ch);
    }

    /**
     * @return string Returns the error message or '' (the empty string) if no error occurred.
     */
    public function error(): string
    {
        return curl_error($this->ch);
    }

    /**
     * Closes a cURL session and frees all resources. The cURL handle, ch, is also deleted.
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }
}
